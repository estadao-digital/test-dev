<?php

namespace File
{
    class Image
    {
        const FORMAT_PNG  = png;
        const FORMAT_JPEG = jpeg;
        const FORMAT_GIF  = gif;

        const MERGE_TOP    = "top";
        const MERGE_BOTTOM = "bottom";

        protected static $__isLoaded = false;

        protected $image = null;

        protected $prePath  = null;
        protected $preHeight = null;
        protected $preWidth  = null;

        public static function __load()
        {
            if (self::$__isLoaded == true) return;
            self::$__isLoaded = true;

            \KrupaBOX\Internal\Library::load("PhpImageWorkshop");
        }

        protected static function checkExtension()
        {
            if (!@function_exists("imageCreateFromPNG"))
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", message => "Missing GD extension."]); \KrupaBOX\Internal\Kernel::exit(); }
        }

        public function __construct($width = 1, $height = 1)
        {
            self::__load();

            $width  = \intEx($width)->toInt();
            $height = \intEx($height)->toInt();

            if ($width < 1) $width = 1;
            if ($height < 1) $height = 1;

            $this->preHeight = $width;
            $this->preHeight = $height;
            //$this->image = \PHPImageWorkshop\ImageWorkshop::initVirginLayer($width, $height);
        }

        public function __get($key)
        {
            if ($key == width) {
                $this->setupResource();
                return $this->image->getWidth();
            }
            elseif ($key == height) {
                $this->setupResource();
                return  $this->image->getHeight();
            }
        }

        public function __set($key, $value = null)
        {}

        protected function setupResource()
        {
            self::checkExtension();

            if ($this->image == null) {
                if ($this->prePath != null)
                    $this->image = \PHPImageWorkshop\ImageWorkshop::initFromPath($this->prePath);
                if ($this->image == null)
                    $this->image = \PHPImageWorkshop\ImageWorkshop::initVirginLayer($this->preWidth, $this->preHeight);
            }
        }

        public function merge(\File\Image $image = null, $mergeType = self::MERGE_TOP, $positionX = 0, $positionY = 0)
        {
            $this->setupResource();

            if ($image == null) return null;
            $resource = $image->getResource();

            if ($resource == null) return null;
            if (!\Variable::get($resource)->isResource()) return null;

            $imageMerge = \PHPImageWorkshop\ImageWorkshop::initFromResourceVar($resource);

            if ($mergeType != self::MERGE_TOP && $mergeType != self::MERGE_BOTTOM)
                $mergeType = self::MERGE_TOP;

            $positionX = intEx($positionX)->toInt();
            $positionY = intEx($positionY)->toInt();

            if ($mergeType == self::MERGE_TOP)
                $this->image->addLayerOnTop($imageMerge, $positionX, $positionY, "LT");
            else {
                $imageMerge->addLayerOnTop($this->image, $positionX, $positionY, "LT");
                $this->image = $imageMerge;
            }
        }

        public function crop($width = null, $height = null, $positionX = 0, $positionY = 0)
        {
            $this->setupResource();

            $width  = intEx($width)->toInt();
            $height = intEx($height)->toInt();

            if ($width == 0 && $height == 0)
                return null;

            $positionX = intEx($positionX)->toInt();
            $positionY = intEx($positionY)->toInt();

            if ($width == 0)  $width  = null;
            if ($height == 0) $height = null;

            $this->image->cropInPixel($width, $height, $positionX, $positionY, 'LT');
        }

        public function cropSquare()
        {
            $this->setupResource();

            if ($this->height == $this->width)
                return;

            if ($this->height > $this->width)
            {
                $diffPixels = ($this->height - $this->width);
                $this->crop($this->width, $this->width, 0, ($diffPixels / 2));
            }
            else
            {
                $diffPixels = ($this->width - $this->height);
                $this->crop($this->height, $this->height, ($diffPixels / 2), 0);
            }
        }

        public function resize($width = null, $height = null, $forceProportion = false)
        {
            $this->setupResource();

            $width  = intEx($width)->toInt();
            $height = intEx($height)->toInt();

            if ($width == 0 && $height == 0)
                return null;

            if ($width == 0)  $width  = null;
            if ($height == 0) $height = null;

            $this->image->resizeInPixel($width, $height, ($forceProportion == false));
        }

//        public function rotate3dByAngle($xAngle = null, $yAngle = null, $zAngle = null)
//        {
//            $xAngle = intEx($xAngle)->toInt();
//            $yAngle = intEx($yAngle)->toInt();
//            $zAngle = intEx($zAngle)->toInt();
//
//            if ($xAngle == 0 && $yAngle == 0 && $zAngle == 0)
//                return null;
//
//            $xNegative = false;
//            $yNegative = false;
//            $zNegative = false;
//
//            if ($xAngle < 0) { $xNegative = true; $xAngle = ($xAngle * -1); }
//            if ($yAngle < 0) { $yNegative = true; $yAngle = ($yAngle * -1); }
//            if ($zAngle < 0) { $zNegative = true; $zAngle = ($zAngle * -1); }
//
//            $xPi = (($xAngle == 0) ? 0 : (M_PI / (180 / $xAngle)));
//            $yPi = (($yAngle == 0) ? 0 : (M_PI / (180 / $yAngle)));
//            $zPi = (($zAngle == 0) ? 0 : (M_PI / (180 / $zAngle)));
//
//            if ($xNegative == true) $xPi = ($xPi * -1);
//            if ($yNegative == true) $yPi = ($yPi * -1);
//            if ($zNegative == true) $zPi = ($zPi * -1);
//
//            $this->resize($this->width * 2, $this->height * 2);
//            $imagePerpective = new __ImagePerpective__($this);
//            $imagePerpective->rotate($xPi, $yPi, $zPi);
//
//            $this->image = \PHPImageWorkshop\ImageWorkshop::initFromResourceVar($imagePerpective->getResource());
//        }

        public function getResource($backgroundColor = null)
        { $this->setupResource(); return $this->image->getResult($backgroundColor); }

        public function addFilter($filterType, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null)
        {
            $this->setupResource();
            $this->image->applyFilter($filterType, $arg1, $arg2, $arg3, $arg4, true);
        }

        public function opacity($opacity)
        {
            $this->setupResource();
            $opacity = toFloat($opacity);
            $opacity = toInt($opacity * 100);
            $this->image->opacity($opacity);
        }

        public function render($type = self::FORMAT_PNG, $backgroundColor = null, $fileName = "", $cacheAgeInSeconds = 0)
        {
            if ($type != self::FORMAT_PNG && $type != self::FORMAT_GIF && $type != self::FORMAT_JPEG)
                $type = self::FORMAT_PNG;

            $fileName = stringEx($fileName)->toString();
            if (stringEx($fileName)->isEmpty()) $fileName = ("noname" . $type);

            $sendHeader = true; $isDumped = false;
            if (\Dumpper::isPageDumped() || \Connection::isCommandLine())
            { $sendHeader = false; ob_start(); $isDumped = true; }

            if ($backgroundColor == null && $this->image == null && $this->prePath != null) // for fast rendering
            {
                $mime = \File\MIME::getMIMEByFilePath($this->prePath);
                if ($mime == "image/jpeg" && $type == self::FORMAT_JPEG || $mime == "image/png" && $type == self::FORMAT_PNG || $mime == "image/gif" && $type == self::FORMAT_GIF) {
                    if ($sendHeader == true) {
                        $cacheAgeInSeconds = intEx($cacheAgeInSeconds)->toInt();
                        if ($cacheAgeInSeconds > 0)
                            header("Cache-Control: max-age=" . $cacheAgeInSeconds);

                        header('Content-type: ' . $mime);
                        header("Content-Disposition: filename=\"" . $fileName . "\"");
                    }

                    echo \File::getContents($this->prePath);
                    // TODO: setup gzencode system
                }
            }
            else
            {
                $this->setupResource();
                $image = $this->getResource($backgroundColor);

                if ($sendHeader == true) {
                    header("Content-Disposition: filename=\"" . $fileName . "\"");
                    $cacheAgeInSeconds = intEx($cacheAgeInSeconds)->toInt();
                    if ($cacheAgeInSeconds > 0)
                        header("Cache-Control: max-age=" . $cacheAgeInSeconds);
                }

                if ($type == self::FORMAT_PNG)  {
                    if ($sendHeader == true)
                        header("Content-type: image/png");
                    imagepng($image, null, 8); // We choose to show a PNG (quality of 8 on a scale of 0 to 9)
                }
                elseif ($type == self::FORMAT_JPEG) {
                    if ($sendHeader == true)
                        header('Content-type: image/jpeg');
                    imagejpeg($image, null, 95); // We choose to show a JPEG (quality of 95%)
                }
                elseif ($type == self::FORMAT_GIF) {
                    if ($sendHeader == true)
                        header('Content-type: image/gif');
                    imagegif($image); // We choose to show a GIF
                }
            }

            if ($isDumped == true || \Connection::isCommandLine())
            {
                $bufferContent = \ob_get_contents();
                \ob_end_clean();

                $base64Image = (";base64," . \base64_encode($bufferContent));

                if (\Connection::isCommandLine() == false)
                {
                    if ($type == self::FORMAT_PNG)
                        $base64Image = ("png" . $base64Image);
                    elseif ($type == self::FORMAT_JPEG)
                        $base64Image = ("jpeg" . $base64Image);
                    elseif ($type == self::FORMAT_GIF)
                        $base64Image = ("gif" . $base64Image);
                    else $base64Image = ("png" . $base64Image);

                    $base64Image = ("data:image/" . $base64Image);
                    echo "<img src=\"" . $base64Image . "\"><br><br>";
                    return true;
                }

                // Render by pixeler
                $base64PixelerHash = \Security\Hash::toSha1($base64Image. $type);
                $pixelerPath = ("cache://.pixeler/" . $base64PixelerHash . "." . $type);

                if (\File::exists($pixelerPath . ".blob"))
                { echo \File::getContents($pixelerPath . ".blob"); \KrupaBOX\Internal\Kernel::exit(); }

                \KrupaBOX\Internal\Library::load("Pixeler");
                \File::setContents($pixelerPath, $bufferContent);
                $pixelerPath = \File\Wrapper::parsePath($pixelerPath);
                $scaleFactor = (intEx((200 / $this->width) * 100)->toInt() / 100);
                $imagePixeler = \Pixeler\Pixeler::image($pixelerPath, $scaleFactor, true, $scaleFactor, 1);

                \File::setContents($pixelerPath . ".blob", $imagePixeler);
                echo $imagePixeler; \KrupaBOX\Internal\Kernel::exit();
            }

            \KrupaBOX\Internal\Kernel::exit(); // after render, close (if not dumped)
        }

        public function toBase64($type = self::FORMAT_PNG, $backgroundColor = null)
        {
            if ($type != self::FORMAT_PNG && $type != self::FORMAT_GIF && $type != self::FORMAT_JPEG)
                $type = self::FORMAT_PNG;

            $this->setupResource();
            $image = $this->getResource($backgroundColor);

            ob_start();

            if ($type == self::FORMAT_PNG)  {
                imagepng($image, null, 8); // We choose to show a PNG (quality of 8 on a scale of 0 to 9)
            }
            elseif ($type == self::FORMAT_JPEG) {
                imagejpeg($image, null, 95); // We choose to show a JPEG (quality of 95%)
            }
            elseif ($type == self::FORMAT_GIF) {
                imagegif($image); // We choose to show a GIF
            }

            $bufferContent = \ob_get_contents();
            \ob_end_clean();

            $base64Image = (";base64," . \base64_encode($bufferContent));

            if ($type == self::FORMAT_PNG)
                $base64Image = ("png" . $base64Image);
            elseif ($type == self::FORMAT_JPEG)
                $base64Image = ("jpeg" . $base64Image);
            elseif ($type == self::FORMAT_GIF)
                $base64Image = ("gif" . $base64Image);
            else $base64Image = ("png" . $base64Image);

            $base64Image = ("data:image/" . $base64Image);
            return $base64Image;
        }

        public static function fromBase64String($base64 = null)
        {
            self::__load();
            $base64 = stringEx($base64)->replace(" ", "+");

            if (stringEx($base64)->contains("base64,")) {
                $split = stringEx($base64)->split("base64,");
                if ($split->count >= 2) $base64 = $split[1];
            }

            //$decodedImage = \Serialize\Base64::decode($base64);
            //\File::setContents(APPLICATION_FOLDER . "test.png", $decodedImage);
            $imageUri = 'data://application/octet-stream;base64,'  . $base64;

            $imageDetails = @getimagesize($imageUri);
            if ($imageDetails == null) return null;

            $imageDetails = Arr($imageDetails);
            if (!$imageDetails->containsKey(mime))
                return null;

            $split    = stringEx($imageDetails[mime])->split("/");
            $mimeType = $split[1];
            
            if ($mimeType != self::FORMAT_JPEG && $mimeType != self::FORMAT_PNG && $mimeType != self::FORMAT_GIF && $mimeType != wbmp && $mimeType != gd && $mimeType != gd2)

            $image = null;

            if (\function_exists("imageCreateFromPNG") == false)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing GD extension."]); \KrupaBOX\Internal\Kernel::exit(); }

            if ($mimeType == png)
                $image = @imageCreateFromPNG($imageUri);
            elseif ($mimeType == jpg || $mimeType == jpeg)
                $image = @imageCreateFromJPEG($imageUri);
            elseif ($mimeType == gif)
                $image = @imageCreateFromGIF($imageUri);

            if ($image == null) return null;
            return self::fromResource($image);
        }

        public function save($filePath)
        {
            $filePath = \File\Wrapper::parsePath($filePath);

            $directoryPath = \File::getDirectoryPath($filePath);
            $fileName      = \File::getFileName($filePath);

            if (\DirectoryEx::exists($directoryPath) == false)
                \DirectoryEx::create($directoryPath);

            $this->setupResource();
            return $this->image->save($directoryPath, $fileName);
        }

        public static function fromResource($resource = null)
        {
            self::__load();
            if ($resource == null) return null;
            if (!\Variable::get($resource)->isResource()) return null;

            $image = new Image();
            self::checkExtension();
            $image->image = \PHPImageWorkshop\ImageWorkshop::initFromResourceVar($resource);
            return $image;
        }

        public static function fromFilePath($filePath, $instantiate = true)
        {
            self::__load();
            $filePath = stringEx($filePath)->toString();
            $filePath = \File\Wrapper::parsePath($filePath);
            if (\File::exists($filePath) == false || \File::isReadable($filePath) == false) return null;

            $image = new Image();

            if ($instantiate == true) {
                self::checkExtension();
                $image->image = \PHPImageWorkshop\ImageWorkshop::initFromPath($filePath);
                if ($image->image == null) return null;
            }

            $image->prePath = $filePath;
            return $image;
        }

        public static function fromString($string)
        {
            self::__load();
            $string = stringEx($string)->toString();
            $image = new Image();
            self::checkExtension();
            $image->image = \PHPImageWorkshop\ImageWorkshop::initFromString($string);
            return $image;
        }

        public static function fromUrl($url, $checkRedirection = false)
        {
            $request = new \Http\Request($url);
            $data = $request->send();

            if ($data->redirectUrl != null)
                $url = $data->redirectUrl;

            $data = @file_get_contents($url);
            $hash = \Security\Hash::toSha1($data);
            \File::setContents("cache://.image/" . $hash . ".png", $data);
            $image = \File\Image::fromFilePath("cache://.image/" . $hash . ".png");
            \File::delete("cache://.image/" . $hash . ".png");
            return $image;
        }
    }

    class __ImagePerpective__
    {
        //Settings
        private $output_directory = "output_images/";
        private $input_directory = "";

        //Attributes
        private $img;
        private $imgWidth;
        private $imgHeight;
        private $imgName;
        private $ext;
        //Constructor
        function __construct(\File\Image $image){

            $this->imgWidth = $image->width;
            $this->imgHeight = $image->height;
            $this->setExt($this->imgName);
            $this->ext = "png";
            $this->img = $image->getResource();
        }

        //Public Methods

        public function getResource()
        {
            return $this->img;
        }

        /**
         * Demo Function : displays the image in a 3/4 view
         * @author nchourrout
         * @version 0.1
         */
        public function demo(){
            $x0 = 0;$y0 = round(($this->imgHeight)/4);
            $x1 = $this->imgWidth/2;$y1 = 0;
            $x2 = $this->imgWidth/2;$y2 = $this->imgHeight;
            $x3 = 0;$y3 = round(3*($this->imgHeight-1)/4);

            $this->createPerspective($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3);
        }

        /**
         * Create a perspective view of the original image as if it has been rotated in 3D
         * @author nchourrout
         * @version 0.1
         * @param long $rx Rotation angle around X axis
         * @param long $ry Rotation angle around Y axis
         * @param long $rz Rotation angle around Z axis
         */
        public function rotate($rx,$ry,$rz){
            $points = $this->getApexes($rx,$ry,$rz);
            //On doit mieux gérer le fait que l'image résultat ne peut pas être agrandie sous peine d'avoir des zones blanches manquantes
            $ratio = 2;
            if ($rx!=0 || $ry!=0 || $rz!=0)
                for($i=0;$i<count($points);$i++)
                    $points[$i]=array($points[$i][0]/$ratio,$points[$i][1]/$ratio);


            list($x0,$y0) = $points[1];
            list($x1,$y1) = $points[0];
            list($x2,$y2) = $points[3];
            list($x3,$y3) = $points[2];
            $this->createPerspective($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3);
        }

        /**
         * Create an animated gif of the image rotating around Z axis
         * @author nchourrout
         * @version 0.1
         * @param time_div integer Duration in ms between two frames (default : 50ms)
         */
        public function createAnimatedGIF($time_div=50){
            $this->ext = "gif";
            for($i=1;$i<6;$i++){
                $angle = 0.1+M_PI/12*$i;
                $this->rotate(0,0,$angle);
                $this->save($i.".gif");
                $frames[] = $this->output_directory.$i.".gif";
                $time[] = $time_div;
            }
            $loops = 0;//infinite
            $gif = new GIFEncoder($frames,$time,$loops,2,0, 0, 0,"url");
            Header ( 'Content-type:image/gif' );
            echo    $gif->GetAnimation ( ); //Modifier cette ligne par quelquechose qui permette juste de stocker l'image dans un fichier

            for($i=1;$i<6;$i++)
                @unlink($this->output_directory.$i.".gif");
        }

        public function display($outputName=null){
            if($outputName!=null)
                $outputName = $this->output_directory.$outputName;

            switch($this->ext){
                case 'png':
                    $this->displayPNG($outputName);
                    break;
                case 'gif':
                    $this->displayGIF($outputName);
                    break;
                case 'jpeg':
                case 'jpg' :
                    $this->displayJPEG($outputName);
                    break;
            }
        }

        public function displayJPEG($outputName=null){
            if($outputName==null){
                Header ( 'Content-type:image/jpeg' );
                imagejpeg($this->img);
            }else
                imagejpeg($this->img,$outputName);
        }

        public function displayPNG($outputName=null){
            if($outputName==null){
                Header ( 'Content-type:image/png' );
                imagepng($this->img);
            }else
                imagepng($this->img,$outputName);
        }

        public function displayGIF($outputName=null){
            if($outputName==null){
                Header ( 'Content-type:image/gif' );
                imagegif($this->img);
            }else
                imagegif($this->img,$outputName);
        }

        public function save($outputName=null){
            if($outputName==null)
                $outputName = $this->imgName;
            $this->setExt($outputName);
            $this->display($outputName);
        }

        public function setInputDirectory($dir){
            $this->input_directory = $dir;
        }

        public function setOutputDirectory($dir){
            $this->output_directory = $dir;
        }

        //Private Methods

        private function load(){
            $imgSize = getimagesize($this->input_directory.$this->imgName);
            $this->imgWidth = $imgSize[0];
            $this->imgHeight = $imgSize[1];
            $this->setExt($this->imgName);
            $path = $this->input_directory.$this->imgName;
            switch($this->ext){
                case 'png':
                    $this->img = imagecreatefrompng($path);
                    break;
                case 'gif':
                    $this->img = imagecreatefrompng($path);
                    break;
                case 'jpeg':
                case 'jpg' :
                    $this->img = imagecreatefromjpeg($path);
                    break;
                default :
                    die("Incorrect image file extension");
            }
        }

        private function setExt($imgName){
            $this->ext = strtolower(substr(strrchr($imgName,'.'),1));
        }

        private function getApexes($rx,$ry,$rz){
            $cx = cos($rx);
            $sx = sin($rx);
            $cy = cos($ry);
            $sy = sin($ry);
            $cz = cos($rz);
            $sz = sin($rz);

            $ex = $this->imgWidth/2;
            $ey = $this->imgHeight/2;
            $ez = max($this->imgHeight,$this->imgWidth)/2;

            $cam = array($this->imgWidth/2,$this->imgHeight/2,max($this->imgHeight,$this->imgWidth)/2);
            $apexes = array(array(0,$this->imgHeight,0), array($this->imgWidth, $this->imgHeight, 0), array($this->imgWidth, 0, 0), array(0,0,0));
            $points = array();

            $i=0;
            foreach($apexes as $pt) {
                $ax = $pt[0];
                $ay = $pt[1];
                $az = $pt[2];

                $dx = $cy*($sz*($ax-$cam[1])+$cz*($ax-$cam[0])) - $sy*($az-$cam[2]);
                $dy = $sx*($cy*($az-$cam[2])+$sy*($sz*($ay-$cam[1])+$cz*($ax-$cam[0])))+$cx*($cz*($ay-$cam[1])-$sz*($ax-$cam[0]));
                $dz = $cx*($cy*($az-$cam[2])+$sy*($sz*($ay-$cam[1])+$cz*($ax-$cam[0])))-$sx*($cz*($ay-$cam[1])-$sz*($ax-$cam[0]));

                $points[$i] = array(round(($dx-$ex)/($ez/$dz)),round(($dy-$ey)/($ez/$dz)));
                $i++;
            }
            return $points;
        }

        private function createPerspective($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3){
            $SX = max($x0,$x1,$x2,$x3);
            $SY = max($y0,$y1,$y2,$y3);
            $newImage = imagecreatetruecolor($SX, $SY);
            $bg_color=ImageColorAllocateAlpha($newImage,255,255,255,0);
            imagefill($newImage, 0, 0, $bg_color);
            for ($y = 0; $y < $this->imgHeight; $y++) {
                for ($x = 0; $x < $this->imgWidth; $x++) {
                    list($dst_x,$dst_y) = $this->corPix($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3,$x,$y,$this->imgWidth,$this->imgHeight);
                    imagecopy($newImage,$this->img,$dst_x,$dst_y,$x,$y,1,1);
                }
            }
            $this->img = $newImage;
        }

        private function corPix($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3,$x,$y,$SX,$SY) {
            return $this->intersectLines(
                (($SY-$y)*$x0 + ($y)*$x3)/$SY, (($SY-$y)*$y0 + $y*$y3)/$SY,
                (($SY-$y)*$x1 + ($y)*$x2)/$SY, (($SY-$y)*$y1 + $y*$y2)/$SY,
                (($SX-$x)*$x0 + ($x)*$x1)/$SX, (($SX-$x)*$y0 + $x*$y1)/$SX,
                (($SX-$x)*$x3 + ($x)*$x2)/$SX, (($SX-$x)*$y3 + $x*$y2)/$SX);
        }
        private function det($a,$b,$c,$d) {
            return $a*$d-$b*$c;
        }
        private function intersectLines($x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4) {
            $d = $this->det($x1-$x2,$y1-$y2,$x3-$x4,$y3-$y4);

            if ($d==0) $d = 1;

            $px = $this->det($this->det($x1,$y1,$x2,$y2),$x1-$x2,$this->det($x3,$y3,$x4,$y4),$x3-$x4)/$d;
            $py = $this->det($this->det($x1,$y1,$x2,$y2),$y1-$y2,$this->det($x3,$y3,$x4,$y4),$y3-$y4)/$d;
            return array($px,$py);
        }

    }
}
