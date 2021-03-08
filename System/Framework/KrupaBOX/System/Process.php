<?php

class Process
{
    protected $pid  = null;
    protected $name = null;

    protected function __construct($pid = null, $name = null)
    {
        $this->pid  = $pid;
        $this->name = $name;
    }

    public function toArr()
    { return Arr([pid => $this->pid, name => $this->name]); }

    public static function getByPid($pid)
    {
        $pid = intEx($pid)->toInt();
        if ($pid <= 0) return null;
    }

    public static function getCurrent($withName = true)
    {
        $pid = intEx(\posix_getpid())->toInt();
        if ($pid <= 0) return null;

        if ($withName == true) {
            $processes = \Process::getAll();
            foreach ($processes as $process)
                if ($process->pid == $pid)
                    return $process;
        }

        return new Process($pid);
    }

    public function __get($key)
    {
        if ($key == pid)
            return $this->pid;
        if ($key == name)
            return $this->name;
        return null;
    }

    public function destroy()
    { return $this->kill(); }

    public function kill($forceKill = false)
    {
        if ($this->pid == null)
            return null;
        if (\System::isWindows())
            return $this->killWindows();

        $success = false;
        if ($forceKill == false)
            $success = @\posix_kill($this->pid, 15);

        if ($success == false)
            \System\Shell::execute("kill -15 " . $this->pid);

        $success = (\posix_getsid($this->pid) === false);
        if ($success == false)
            \System\Shell::execute("sudo kill -15 " . $this->pid);

        if ($success == false)
            @\posix_kill($this->pid, 15);

        return (\posix_getsid($this->pid) === false);
    }

    protected function killWindows()
    {
        \System\Shell::execute("taskkill /f /pid " . $this->pid);
        $processes = self::getAll();
        $success = true;
        foreach ($processes as $process)
            if ($process->pid == $this->pid)
            { $success = false; break; }
        return $success;
    }

    public static function getAll()
    {
        if (\System::isWindows() == true)
            return self::getAllWindows();

        $processes = Arr();
        $data = \System\Shell::execute("ps -A");
        if (stringEx($data)->isEmpty()) return $processes;

        $split = stringEx($data)->split("\n");
        for ($i = 1; $i < $split->count; $i++) {
            $extract = stringEx($split[$i])->split(" ");
            if ($extract->count >= 4) {
                $pid = intEx($extract[0])->toInt();
                if ($pid > 0) {
                    $name = stringEx($extract[3])->toString();
                    $process = new Process($pid, $name);
                    $processes->add($process);
                }
            }
        }

        return $processes;
    }

    protected static function getAllWindows()
    {
        $processes = Arr();

        $data = \System\Shell::execute("tasklist");
        if (stringEx($data)->isEmpty()) return $processes;

        $split = stringEx($data)->split("\n");
        for ($i = 1; $i < $split->count; $i++) {
            $extract = stringEx($split[$i])->split(" ");
            if ($extract->count >= 4 && \File::getFileExtension($extract[0]) != null) {
                $pid = intEx($extract[1])->toInt();
                if ($pid > 0) {
                    $process = new Process($pid, stringEx($extract[0])->toString());
                    $processes->add($process);
                }
            }
        }

        return $processes;
    }
}