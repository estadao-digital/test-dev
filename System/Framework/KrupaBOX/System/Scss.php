<?php

class Scss
{
    protected $scssHash = null;
    protected $scssData = "";

    protected $scssCompiled = null;

    public function __construct($lessString = null)
    {
        $this->scssData = stringEx($lessString)->toString();
        $this->computeHash();
    }

    public static function fromFilePath($filePath)
    {
        $scss = new Scss();
        $scss->scssData = \File::getContents($filePath);
        $scss->computeHash();
        return $scss;
    }

    public static function fromLessString($scssString)
    {
        $scss = new Scss($scssString);
        return $scss;
    }

    protected function computeHash()
    { $this->scssHash = \Security\Hash::toSha1($this->scssData); }

    protected function compile()
    {
        if ($this->scssCompiled != null)
            return null;

        $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/scss/". $this->scssHash . ".css");
        if (\File::exists($packageHashPath))
            $this->scssCompiled = \File::getContents($packageHashPath);

        self::__initialize();

        $scssCompiler = new \Leafo\ScssPhp\Compiler();
        $this->scssCompiled = $scssCompiler->compile($this->scssData);

        \File::setContents($packageHashPath, $this->scssCompiled);
    }

    public function getScss()
    { return $this->scssData; }

    public function getStylesheet()
    { $this->compile(); return $this->scssCompiled; }

    public function render()
    {
        $stylesheet = $this->getStylesheet();
        \Connection\Output::execute($stylesheet, "text/css", null, true, 60 * 60 * 24 * 30);
    }

    protected static $__isInitialized = false;
    protected static function __initialize() {
        if (self::$__isInitialized == true) return null;
        \KrupaBOX\Internal\Library::load("Leafo");
        self::$__isInitialized = true;
    }
}