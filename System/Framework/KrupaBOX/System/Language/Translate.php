<?php

namespace Language
{
    class Translate
    {
        protected static $languageFiles = null;

        public static function getBySid($sid, $iso = null, $fallback = true)
        {
            $sid = stringEx($sid)->toString();
            $data = self::getAll($iso, $fallback);
            return (($data->containsKey($sid)) ? $data[$sid] : null);
        }

        public static function getAll($iso = null, $fallback = true)
        {
            if (self::$languageFiles == null)
                self::$languageFiles = Arr();

            $iso = stringEx($iso)->toString();
            if (stringEx($iso)->isEmpty())
                $iso = \Language::getDefaultISO();
            if (!\Language::isValidISO($iso))
                $iso = "en";

            $iso = \Language::formatISO($iso);
            $isos = Arr([$iso]);

            if ($fallback == true)
            {
                $fallbackIso = \Language::getFallbackISO($iso);
                if ($fallbackIso != null) $isos->add($fallbackIso);
                if (!$isos->contains("en"))
                    $isos->add("en");
            }

            $data = Arr();

            if ($isos->count > 0)
                for ($i = 0; $i < $isos->count; $i++) {
                    $_data = self::getLanguageFile($isos[$i]);
                    if ($_data != null)
                        foreach ($_data as $key => $value)
                            if ($data->containsKey($key) == false)
                                $data[$key] = $value;
                }

            foreach ($data as $insert)
                $insert->html = ("<!--" . $insert->sid . "|" . $insert->iso . "-->" . $insert["value"] . "<!--/" . $insert->sid . "|" . $insert->iso . "-->");
            return $data;
        }

        protected static function getLanguageFile($iso)
        {
            if (self::$languageFiles->containsKey($iso))
                return self::$languageFiles[$iso];

            $isoFix = stringEx($iso)->toLower(false)->replace("_", "/");

            $filePath = ("config://Language/" . $isoFix . ".json");

            // FALLBACK XML to JSON
            if (\File::exists($filePath) == false && \File::exists("config://Language/" . $isoFix . ".xml"))
            {
                $file   = \File::getContents("config://Language/" . $isoFix . ".xml");
                $decode = \Serialize\Xml::decode($file);
                $data   = Arr();

                if ($decode != null && $decode->containsKey("Language"))
                    $data = $decode->Language;

                $parseData = Arr();
                foreach ($data as $key => $value) {
                    $key   = stringEx($key)->trim("\r\n\t");
                    $value = stringEx($value)->trim("\r\n\t");
                    $parseData[$key] = $value;
                }

                $data = $parseData;
                \File::setContents($filePath, $data);
            }

            if (\File::exists($filePath) == null) return null;
            $hash = \Security\Hash::toSha1(\File::getLastModifiedDateTimeEx($filePath)->toString());

            $cachePath = ("cache://.language/" . $isoFix . ".json/" . $hash . ".dat");
            if (\File::exists($cachePath)) {
                self::$languageFiles[$iso] = \Serialize\Json::decode(\File::getContents($cachePath));
                self::$languageFiles[$iso] = Arr(self::$languageFiles[$iso]);
                return self::$languageFiles[$iso];
            }

            $file   = \File::getContents($filePath);
            $data = Arr(\Serialize\Json::decode($file));

            $parseData = Arr();
            foreach ($data as $key => $value) {
                $parseData[$key] = Arr([
                    sid   => $key,
                    iso   => $iso,
                    value => $value
                ]);
            }

            \File::setContents($cachePath, $parseData);
            self::$languageFiles[$iso] = $parseData;
            return self::$languageFiles[$iso];
        }
    }
}