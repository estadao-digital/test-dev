<?php

namespace KrupaBOX\Internal\Log {

class Console
{
    protected static $logs = null;

    public static function register()
    {
        if (self::$logs == null)
            self::$logs = \Arr([]);
    }

    public static function ajaxHandler($code, $message, $file, $line, $context)
    {
        // TODO: if Ajax -> send error with json
        // die()
    }

    // TODO: ajax data send method

    public static function log($value, $varName, $backtrace)
    {
        if (IS_DEVELOPMENT == false && FILE_DEBUGGER_ENABLED == false ||
            (FILE_DEBUGGER_ENABLED == false && CONSOLE_DEBUGGER_ENABLED == false && AJAX_DEBUGGER_ENABLED == false))
            return;

        self::register();

        $varName = stringEx($varName)->toString();
        $backtrace = \Arr($backtrace);

        $compileJson = \Arr();
        $compileJson->message = "";
        $compileJson->data = null;
        $compileJson->backtrace = \Arr();

        $rootPath = \DirectoryEx::getRootPath();
        $traces = \Arr();

        if ($backtrace->containsKey(0) && $backtrace->containsKey(1) && $backtrace[1]->containsKey(0))
        {

            if ($backtrace[1][0]->containsKey("function"))
                $backtrace[0]->function = $backtrace[1][0]->function;
            if ($backtrace[1][0]->containsKey("class"))
                $backtrace[0]->class = $backtrace[1][0]->class;

            $traces[] = $backtrace[0];
        }

        if ($backtrace->containsKey(1))
            foreach ($backtrace[1] as $trace)
                $traces[] = $trace;

        for ($i = 0; $i < $traces->length; $i++)
        {
            $trace = $traces[$i];
            $traceStr = "";

            $filePath = "";
            if ($trace->containsKey("file"))
                $filePath .= stringEx($trace->file)->
                    replace("\\", "/", false)->
                    replace($rootPath, "ROOT");

            $traceStr .= $filePath;

            $line = "";
            if ($trace->containsKey("line"))
            {
                $line = $trace->line;

                if (!stringEx($filePath)->isEmpty())
                    $traceStr .= ":";

                $traceStr .= $line;
            }

            $fullMethod = "";

            $class = "";    if ($trace->containsKey("class"))    $class = $trace->class;
            $type = "";     if ($trace->containsKey("type"))     $type = $trace->type;
            $function = ""; if ($trace->containsKey("function")) $function = $trace->function;

            if (!stringEx($class)->isEmpty() || !stringEx($function)->isEmpty())
            {
                if (!stringEx($class)->isEmpty())
                {
                    if (stringEx($type)->isEmpty())
                        $type = "->";

                    $fullMethod .= $class;

                    if (!stringEx($function)->isEmpty())
                        $fullMethod .= $type;
                }

                $fullMethod .= $function . "()";
            }

            if (!stringEx($fullMethod)->isEmpty() && $fullMethod != "require_once()" && $fullMethod != "include_once()")
            {
                if (!stringEx($filePath)->isEmpty() || !stringEx($line)->isEmpty())
                    $traceStr .= " ";

                $traceStr .= "[" . $fullMethod . "]";
            }

            if (!stringEx($traceStr)->isEmpty())
                $compileJson->backtrace[] = "Called from " . $traceStr;
        }

        $compileJson->message = "----------------------------------------------------------------------------------------\\n" .
            "\\n[KrupaBOX: Console Debugger]\\n";

        if (!stringEx($varName)->isEmpty())
            $compileJson->message  .= "Variable: '" . $varName . "'";

        if ($compileJson->backtrace->length > 0)
        {
            if (!stringEx($varName)->isEmpty())
                $compileJson->message .= " @ ";

            $compileJson->message .= $compileJson->backtrace[0];
        }

        $compileJson->data = $value;
        $compileJson = \Arr($compileJson);

        self::$logs[] = $compileJson;

        if (FILE_DEBUGGER_ENABLED == true)
        { // TODO: save file log
        }

        if (IS_DEVELOPMENT == false)
            return;

        if (CONSOLE_DEBUGGER_ENABLED == true && \Connection::isBrowser())
        {
            $html = <<<HTML
                <script>
                    console.log("{{message}}");
                    console.log({{dataJson}});
                    console.log({{backtraceJson}});
                    console.log("");
                </script>
HTML;
            $backtraces = \Arr();

            $i = 0;
            foreach ($compileJson->backtrace as $backtrace)
            { $backtraces["." . $i] = $backtrace; $i++; }

            $dataJson = json_encode($compileJson->data);
            $backtraceJson = json_encode($compileJson->backtrace);

            $dataJson       = "JSON.parse(\"" . addslashes($dataJson) . "\")";
            $backtraceJson  = "JSON.parse(\"" . addslashes($backtraces) . "\")";

            $html = stringEx($html)->
                replace("{{message}}", $compileJson->message, false)->
                replace("{{dataJson}}", $dataJson, false)->
                replace("{{backtraceJson}}", $backtraceJson);

            echo $html;
        }

        if (AJAX_DEBUGGER_ENABLED == true && \Connection::isAjaxRequest())
        {

        }
    }
}

Console::register();

}
