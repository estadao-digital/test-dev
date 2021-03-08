<?php

class Less
{
    protected $lessHash = null;
    protected $lessData = "";

    protected $lessCompiled = null;

    public function __construct($lessString = null)
    {
        $this->lessData = stringEx($lessString)->toString();
        $this->computeHash();
    }

    public static function fromFilePath($filePath)
    {
        $less = new Less();
        $less->lessData = \File::getContents($filePath);
        $less->computeHash();
        return $less;
    }

    public static function fromLessString($lessString)
    {
        $less = new Less($lessString);
        return $less;
    }

    protected function computeHash()
    { $this->lessHash = \Security\Hash::toSha1($this->lessData); }

    protected function compile()
    {
        if ($this->lessCompiled != null)
            return null;

        $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/less/". $this->lessHash . ".css");
        if (\File::exists($packageHashPath))
            $this->lessCompiled = \File::getContents($packageHashPath);

        self::__initialize();

        $lessCompiler = new \lessc();
        $this->lessCompiled = $lessCompiler->compile($this->lessData);
        \File::setContents($packageHashPath, $this->lessCompiled);
    }

    public function getLess()
    { return $this->lessData; }

    public function getStylesheet()
    { $this->compile(); return $this->lessCompiled; }

    public function render()
    {
        $stylesheet = $this->getStylesheet();
        \Connection\Output::execute($stylesheet, "text/css", null, true, 60 * 60 * 24 * 30);
    }

    protected static $__isInitialized = false;
    protected static function __initialize() {
        if (self::$__isInitialized == true) return null;
        \KrupaBOX\Internal\Library::load("LessPHP");
        self::$__isInitialized = true;
    }
}