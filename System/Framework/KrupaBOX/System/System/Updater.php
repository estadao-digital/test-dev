<?php

namespace System
{
    class Updater
    {
        public static function getMetaFiles($includeData = false)
        {
            $zip = new \ZipArchive();
            $zip->open('file.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $allFiles = Arr();

            $systemDir = \DirectoryEx::listDirectoryPaths(ROOT_FOLDER . "System");
            if ($systemDir != null)
                foreach ($systemDir as $filePath)
                    $allFiles->add("System/" . $filePath);

            $serverDir = \DirectoryEx::listDirectoryPaths(APPLICATION_FOLDER . "Server");
            if ($serverDir != null)
                foreach ($serverDir as $filePath)
                    $allFiles->add("Application/Server/" . $filePath);

            $clientDir = \DirectoryEx::listDirectoryPaths(APPLICATION_FOLDER . "Client");
            if ($clientDir != null)
                foreach ($clientDir as $filePath)
                    $allFiles->add("Application/Client/" . $filePath);

            $configDir = \DirectoryEx::listDirectoryPaths(APPLICATION_FOLDER . "Config");
            if ($configDir != null)
                foreach ($configDir as $filePath)
                    $allFiles->add("Application/Config/" . $filePath);

            if ($includeData == true)
            {
                $dataDir = \DirectoryEx::listDirectoryPaths(APPLICATION_FOLDER . "Data");
                if ($dataDir != null)
                    foreach ($dataDir as $filePath)
                        $allFiles->add("Application/Data/" . $filePath);
            }

            foreach ($allFiles as $filePath)
                $zip->addFile(ROOT_FOLDER . $filePath, $filePath);

            $zip->close();
            \KrupaBOX\Internal\Kernel::exit();



            $allMetaFiles = Arr();

            foreach ($allFiles as $filePath)
            {
                $lastModifiedDateTime = \File::getLastModifiedDateTimeEx(ROOT_FOLDER . $filePath);
                if ($lastModifiedDateTime == null) $lastModifiedDateTime = \DateTimeEx::now();

                $lastModifiedHash = \Security\Hash::toSha1($lastModifiedDateTime->toString());
                $allMetaFiles->add(Arr([file => $filePath, hash => $lastModifiedHash]));
            }

            return $allMetaFiles;
        }
    }
}