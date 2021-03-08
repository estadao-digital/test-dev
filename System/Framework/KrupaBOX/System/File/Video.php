<?php

namespace File
{

    use KrupaBOX\Internal\Library\FFMpeg;

    class Video
    {
        const FORMAT_X264 = "x264";
        const FORMAT_WEBM = "webm";
        const FORMAT_WMW  = "wmv";
//
//        const MERGE_TOP    = "top";
//        const MERGE_BOTTOM = "bottom";

        protected static $__isLoaded = false;

        protected static $ffmpeg  = null;
        protected static $ffprobe = null;

        protected $video = null;
        protected $videoStream = null;

        protected $prePath  = null;

        protected $currentHeight = null;
        protected $currentWidth  = null;

        protected $useFilters = false;

        public static function __load()
        {
            if (self::$__isLoaded == true) return;
            self::$__isLoaded = true;

            \KrupaBOX\Internal\Library::load("FFMpeg");
        }

        public function __get($key)
        {
            if ($key == width)
            {
                if ($this->currentWidth != null)
                    return $this->currentWidth;

                $this->setupResource();
                $this->setupStream();

                if ($this->videoStream == null)
                    return null;

                $dimensions = $this->videoStream->videos()->first()->getDimensions();
                if ($dimensions != null) $this->currentWidth = $dimensions->getWidth();
                return $this->currentWidth;
            }
            elseif ($key == height)
            {
                if ($this->currentHeight != null)
                    return $this->currentHeight;

                $this->setupResource();
                $this->setupStream();

                if ($this->videoStream == null)
                    return null;

                $dimensions = $this->videoStream->videos()->first()->getDimensions();
                if ($dimensions != null) $this->currentHeight = $dimensions->getHeight();
                return $this->currentHeight;
            }
        }

        public function __set($key, $value = null)
        {}

        protected function setupResource()
        {
            if ($this->video == null) {
                if ($this->prePath != null)
                    $this->video = @self::getFFMpeg()->open($this->prePath);
            }
        }

        protected function setupStream()
        {
            self::setupResource();
            if ($this->video == null) return null;
            if ($this->videoStream != null) return null;

            $this->videoStream = @self::getFFProbe()->streams($this->prePath);
        }

        public function resize($width = null, $height = null, $forceProportion = false)
        {
            $this->setupResource();

            if ($this->video == null)
                return null;

            $width  = intEx($width)->toInt();
            $height = intEx($height)->toInt();

            if ($width == 0 && $height == 0)
                return null;

            $this->useFilters = true;
            $dimension = new \FFMpeg\Coordinate\Dimension($width, $height);

            if ($width == 0)
            {
                $this->video->filters()->resize($dimension, \FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_SCALE_HEIGHT);
                // recalculate width/height
            }

            elseif ($height == 0)
            {
                $this->video->filters()->resize($dimension, \FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_SCALE_WIDTH);
                // recalculate width/height
            }
            else
            {
                $this->video->filters()->resize($dimension, \FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT);
//                $this->currentWidth  = $width;
//                $this->currentHeight = $height;
            }
        }

        public function save($path, $format = self::FORMAT_X264, $progress)
        {
            $this->setupResource();

            if ($this->video == null)
                return null;

            if (stringEx($path)->isEmpty()) return false;
            $path = \File\Wrapper::parsePath($path);

            @\File::setContents($path, "ok");
            $pathData = \File::getContents($path);
            if (stringEx($pathData)->trim("\r\n\t") != "ok") return false;
            @\File::delete($path);

            $formatWrap = null;

            if ($format != self::FORMAT_X264 && $format != self::FORMAT_WEBM && $format != self::FORMAT_WMW)
                $format = self::FORMAT_X264;

            if ($format == self::FORMAT_X264) {
                $formatWrap = new \FFMpeg\Format\Video\X264();
                $formatWrap->setAudioCodec("libmp3lame");
            }
            elseif ($format == self::FORMAT_WMW)
                $formatWrap = new \FFMpeg\Format\Video\WMV();
            elseif ($format == self::FORMAT_WEBM)
                $formatWrap = new \FFMpeg\Format\Video\WebM();

            if (\FunctionEx::isFunction($progress) == true)
                $formatWrap->on('progress', function ($video, $format, $percentage) use($progress) {
                    if (\FunctionEx::isFunction($progress) == true)
                    {
                        $percent = (floatEx($percentage)->toFloat() / 100);
                        $progress($percent);
                    }
                });

            if ($this->useFilters == true)
                $this->video->filters()->synchronize();

            return @$this->video->save($formatWrap, $path);
        }

        public static function isVideo($filePath)
        {
            self::__load();
            $filePath = stringEx($filePath)->toString();
            $filePath = \File\Wrapper::parsePath($filePath);
            if (\File::exists($filePath) == false || \File::isReadable($filePath) == false) return null;

            $ffprobe = self::getFFProbe();
            return ($ffprobe->isValid($filePath) == false);
        }

        public static function fromFilePath($filePath, $instantiate = true)
        {
            self::__load();
            $filePath = stringEx($filePath)->toString();
            $filePath = \File\Wrapper::parsePath($filePath);
            if (\File::exists($filePath) == false || \File::isReadable($filePath) == false) return null;

            $ffprobe = @self::getFFProbe();
            if ($ffprobe->isValid($filePath) == false)
                return null;

            $video = new Video();

            if ($instantiate == true) {
                $video->video = @self::getFFMpeg()->open($filePath);
                if ($video->video == null) return null;
            }

            $video->prePath = $filePath;
            return $video;
        }

        protected static function getFFMpeg()
        {
            if (self::$ffmpeg != null) return self::$ffmpeg;

            $data = [
                'timeout'          => 0,
                'ffmpeg.threads'   => 12,
            ];
            if (\System::isWindows()) {
                $config = \Config::get();
                if ($config->containsKey(ffmpeg) && Arr($config->ffmpeg)->containsKey(path) && stringEx($config->ffmpeg->path)->isEmpty() == false)
                    $data["ffmpeg.binaries"] = $config->ffmpeg->path;
                if ($config->containsKey(ffprobe) && Arr($config->ffprobe)->containsKey(path) && stringEx($config->ffprobe->path)->isEmpty() == false)
                    $data["ffprobe.binaries"] = $config->ffprobe->path;
            }
            self::$ffmpeg = @\FFMpeg\FFMpeg::create($data);

            if (self::$ffprobe == null)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", message => "Missing FFMpeg extension."]); \KrupaBOX\Internal\Kernel::exit(); }
            return self::$ffmpeg;
        }

        protected static function getFFProbe()
        {
            if (self::$ffprobe != null)  return self::$ffprobe;

            $data = [
                'timeout'          => 0,
                'ffmpeg.threads'   => 12,
            ];
            if (\System::isWindows()) {
                $config = \Config::get();
                if ($config->containsKey(ffmpeg) && Arr($config->ffmpeg)->containsKey(path) && stringEx($config->ffmpeg->path)->isEmpty() == false)
                    $data["ffmpeg.binaries"] = $config->ffmpeg->path;
                if ($config->containsKey(ffprobe) && Arr($config->ffprobe)->containsKey(path) && stringEx($config->ffprobe->path)->isEmpty() == false)
                    $data["ffprobe.binaries"] = $config->ffprobe->path;
            }
            self::$ffprobe = @\FFMpeg\FFProbe::create($data);

            if (self::$ffprobe == null)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", message => "Missing FFMpeg (FFProbe) extension."]); \KrupaBOX\Internal\Kernel::exit(); }
            return self::$ffprobe;
        }
    }
}
