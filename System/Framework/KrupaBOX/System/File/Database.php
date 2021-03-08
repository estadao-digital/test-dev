<?php

namespace File
{
    class Database
    {
        protected $data      = null;
        protected $fileSid   = null;
        protected $parameter = null;
        protected $extra     = null;

        protected static function getHashByFileSid($fileSid)
        {
            $fileId = \stringEx($fileSid)->toString();
            if (\stringEx($fileSid)->isEmpty()) return null;

            return $fileId;
            //$key = "KRUPABOX_HASH_203781293216019233092187382137021";
            //return \Security\Hash::toSha1($fileId, $key);
        }

//        protected static function getLastFileId()
//        {
//            $directoryPath = (APPLICATION_FOLDER . "Data/FileDatabase");
//            if (!\File::exists($directoryPath))
//                \DirectoryEx::createDirectory($directoryPath);
//
//            $directoryPath .= "/";
//            $indexPath  = ($directoryPath . "index.dat");
//            $lastFileId = 0;
//
//            if (!\File::exists($indexPath))
//            {
//                $serialize = \Serialize::fromInstance([data => $lastFileId]);
//                \File::setContents($indexPath, $serialize->toSerialized());
//            }
//
//            $data = \File::getContents($indexPath);
//            $serialize = \Serialize::fromSerialized($data);
//            $data      = $serialize->toInstance();
//
//            if ($data != null)
//            {
//                $data = Arr($data);
//                if ($data->containsKey(data))
//                    $lastFileId = \intEx($data->data)->toInt();
//            }
//
//            if ($lastFileId < 0) $lastFileId = 0;
//            return $lastFileId;
//        }

        public static function getFromFileSid($fileSid)
        { return self::getByFileSid($fileSid); }
        
        public static function getByFileSid($fileSid)
        {
            $filePath   = (APPLICATION_FOLDER . "Data/FileDatabase/" . $fileSid . ".dat");

            if (\File::exists($filePath))
            {
                $data = \File::getContents($filePath);
                $serialize = \Serialize::fromSerialized($data);
                if ($serialize == null) return null;
                $instance = $serialize->toInstance();

                if ($instance->parameter == "File\\Image")
                {
                    $directoryPath = (APPLICATION_FOLDER . "Data/FileDatabase");
                    $tmpPath = ($directoryPath . "/" . $instance->fileSid . ".dat.binary.png");

                    $instance->parameter = null;
                    $instance->data = \File\Image::fromFilePath($tmpPath, false);
                }
                
                return $instance;
            }

            return null;
        }

        public function __get($key)
        {
            if ($key == data)
                return $this->data;
            elseif ($key == parameter)
                return $this->parameter;
            elseif ($key == extra)
                return $this->extra;
            elseif ($key == fileSid)
                return $this->fileSid;

            return null;
        }

        public function __set($key, $value)
        {
            if ($key == fileSid)
                $this->fileSid = \stringEx($value)->toString();
            elseif ($key == data)
                $this->data = $value;
            elseif ($key == extra)
                $this->extra = $value;
            elseif ($key == parameter)
                $this->data = $value;
        }

        public function save()
        {
            if (\stringEx($this->fileSid)->isEmpty())
            {
                return null;
//                $fileId = (self::getLastFileId() + 1);
//                $this->fileId = $fileId;
            }

            $directoryPath = (APPLICATION_FOLDER . "Data/FileDatabase");
            if (!\File::exists($directoryPath))
                \DirectoryEx::createDirectory($directoryPath);

            $directoryPath .= "/";
            $indexPath  = ($directoryPath . "index.dat");

            $serialize = \Serialize::fromInstance([data => $this->fileSid]);
            \File::setContents($indexPath, $serialize->toSerialized());

            // SAVE THIS INSTANCE
            $type = \Variable::get($this->data)->getType(); // )
            if ($type == "instance" || $type == "object") {
                $instanceName = \Instance::getName($this->data);
                if ($instanceName != null) $type = $instanceName;
            }

            if ($type == "File\\Image")
            {
                $tmpPath = ($directoryPath . $this->fileSid . ".dat.binary.png");
                $this->data->save($tmpPath);

                $fileDatabase = new Database();
                $fileDatabase->fileSid = $this->fileSid;
                $fileDatabase->data    = null;
                $fileDatabase->extra   = $this->extra;
                $fileDatabase->parameter = "File\\Image";
                $fileDatabase->save();

                return $this;
            }
            
            $serialize = \Serialize::fromInstance($this);
            \File::setContents($directoryPath . $this->fileSid . ".dat", $serialize->toSerialized());
            return $this;
        }

        public function delete()
        {
            $filePath = (APPLICATION_FOLDER . "Data/FileDatabase/" . $this->fileSid . ".dat");
            if (\File::exists($filePath)) \File::delete($filePath);

            $fileImagePath = (APPLICATION_FOLDER . "Data/FileDatabase/" . $this->fileSid . ".dat.binary.png");
            if (\File::exists($fileImagePath)) \File::delete($fileImagePath);
        }

    }
}