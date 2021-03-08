<?php

class Language
{
    const DEFAULT_ISO = "en";

    protected static $languagesNames = [];

    protected static $validISOs  = ["af", "af_NA", "af_ZA", "ak", "ak_GH", "am", "am_ET", "ar", "ar_AE", "ar_BH", "ar_DJ", "ar_DZ", "ar_EG", "ar_EH", "ar_ER", "ar_IL", "ar_IQ", "ar_JO", "ar_KM", "ar_KW", "ar_LB", "ar_LY", "ar_MA", "ar_MR", "ar_OM", "ar_PS", "ar_QA", "ar_SA", "ar_SD", "ar_SO", "ar_SS", "ar_SY", "ar_TD", "ar_TN", "ar_YE", "as", "as_IN", "az", "az_AZ", "az_Cyrl", "az_Cyrl_AZ", "az_Latn", "az_Latn_AZ", "be", "be_BY", "bg", "bg_BG", "bm", "bm_Latn", "bm_Latn_ML", "bn", "bn_BD", "bn_IN", "bo", "bo_CN", "bo_IN", "br", "br_FR", "bs", "bs_BA", "bs_Cyrl", "bs_Cyrl_BA", "bs_Latn", "bs_Latn_BA", "ca", "ca_AD", "ca_ES", "ca_FR", "ca_IT", "cs", "cs_CZ", "cy", "cy_GB", "da", "da_DK", "da_GL", "de", "de_AT", "de_BE", "de_CH", "de_DE", "de_LI", "de_LU", "dz", "dz_BT", "ee", "ee_GH", "ee_TG", "el", "el_CY", "el_GR", "en", "en_AG", "en_AI", "en_AS", "en_AU", "en_BB", "en_BE", "en_BM", "en_BS", "en_BW", "en_BZ", "en_CA", "en_CC", "en_CK", "en_CM", "en_CX", "en_DG", "en_DM", "en_ER", "en_FJ", "en_FK", "en_FM", "en_GB", "en_GD", "en_GG", "en_GH", "en_GI", "en_GM", "en_GU", "en_GY", "en_HK", "en_IE", "en_IM", "en_IN", "en_IO", "en_JE", "en_JM", "en_KE", "en_KI", "en_KN", "en_KY", "en_LC", "en_LR", "en_LS", "en_MG", "en_MH", "en_MO", "en_MP", "en_MS", "en_MT", "en_MU", "en_MW", "en_MY", "en_NA", "en_NF", "en_NG", "en_NR", "en_NU", "en_NZ", "en_PG", "en_PH", "en_PK", "en_PN", "en_PR", "en_PW", "en_RW", "en_SB", "en_SC", "en_SD", "en_SG", "en_SH", "en_SL", "en_SS", "en_SX", "en_SZ", "en_TC", "en_TK", "en_TO", "en_TT", "en_TV", "en_TZ", "en_UG", "en_UM", "en_US", "en_VC", "en_VG", "en_VI", "en_VU", "en_WS", "en_ZA", "en_ZM", "en_ZW", "eo", "es", "es_AR", "es_BO", "es_CL", "es_CO", "es_CR", "es_CU", "es_DO", "es_EA", "es_EC", "es_ES", "es_GQ", "es_GT", "es_HN", "es_IC", "es_MX", "es_NI", "es_PA", "es_PE", "es_PH", "es_PR", "es_PY", "es_SV", "es_US", "es_UY", "es_VE", "et", "et_EE", "eu", "eu_ES", "fa", "fa_AF", "fa_IR", "ff", "ff_CM", "ff_GN", "ff_MR", "ff_SN", "fi", "fi_FI", "fo", "fo_FO", "fr", "fr_BE", "fr_BF", "fr_BI", "fr_BJ", "fr_BL", "fr_CA", "fr_CD", "fr_CF", "fr_CG", "fr_CH", "fr_CI", "fr_CM", "fr_DJ", "fr_DZ", "fr_FR", "fr_GA", "fr_GF", "fr_GN", "fr_GP", "fr_GQ", "fr_HT", "fr_KM", "fr_LU", "fr_MA", "fr_MC", "fr_MF", "fr_MG", "fr_ML", "fr_MQ", "fr_MR", "fr_MU", "fr_NC", "fr_NE", "fr_PF", "fr_PM", "fr_RE", "fr_RW", "fr_SC", "fr_SN", "fr_SY", "fr_TD", "fr_TG", "fr_TN", "fr_VU", "fr_WF", "fr_YT", "fy", "fy_NL", "ga", "ga_IE", "gd", "gd_GB", "gl", "gl_ES", "gu", "gu_IN", "gv", "gv_IM", "ha", "ha_GH", "ha_Latn", "ha_Latn_GH", "ha_Latn_NE", "ha_Latn_NG", "ha_NE", "ha_NG", "he", "he_IL", "hi", "hi_IN", "hr", "hr_BA", "hr_HR", "hu", "hu_HU", "hy", "hy_AM", "id", "id_ID", "ig", "ig_NG", "ii", "ii_CN", "is", "is_IS", "it", "it_CH", "it_IT", "it_SM", "ja", "ja_JP", "ka", "ka_GE", "ki", "ki_KE", "kk", "kk_Cyrl", "kk_Cyrl_KZ", "kk_KZ", "kl", "kl_GL", "km", "km_KH", "kn", "kn_IN", "ko", "ko_KP", "ko_KR", "ks", "ks_Arab", "ks_Arab_IN", "ks_IN", "kw", "kw_GB", "ky", "ky_Cyrl", "ky_Cyrl_KG", "ky_KG", "lb", "lb_LU", "lg", "lg_UG", "ln", "ln_AO", "ln_CD", "ln_CF", "ln_CG", "lo", "lo_LA", "lt", "lt_LT", "lu", "lu_CD", "lv", "lv_LV", "mg", "mg_MG", "mk", "mk_MK", "ml", "ml_IN", "mn", "mn_Cyrl", "mn_Cyrl_MN", "mn_MN", "mr", "mr_IN", "ms", "ms_BN", "ms_Latn", "ms_Latn_BN", "ms_Latn_MY", "ms_Latn_SG", "ms_MY", "ms_SG", "mt", "mt_MT", "my", "my_MM", "nb", "nb_NO", "nb_SJ", "nd", "nd_ZW", "ne", "ne_IN", "ne_NP", "nl", "nl_AW", "nl_BE", "nl_BQ", "nl_CW", "nl_NL", "nl_SR", "nl_SX", "nn", "nn_NO", "no", "no_NO", "om", "om_ET", "om_KE", "or", "or_IN", "os", "os_GE", "os_RU", "pa", "pa_Arab", "pa_Arab_PK", "pa_Guru", "pa_Guru_IN", "pa_IN", "pa_PK", "pl", "pl_PL", "ps", "ps_AF", "pt", "pt_AO", "pt_BR", "pt_CV", "pt_GW", "pt_MO", "pt_MZ", "pt_PT", "pt_ST", "pt_TL", "qu", "qu_BO", "qu_EC", "qu_PE", "rm", "rm_CH", "rn", "rn_BI", "ro", "ro_MD", "ro_RO", "ru", "ru_BY", "ru_KG", "ru_KZ", "ru_MD", "ru_RU", "ru_UA", "rw", "rw_RW", "se", "se_FI", "se_NO", "se_SE", "sg", "sg_CF", "sh", "sh_BA", "si", "si_LK", "sk", "sk_SK", "sl", "sl_SI", "sn", "sn_ZW", "so", "so_DJ", "so_ET", "so_KE", "so_SO", "sq", "sq_AL", "sq_MK", "sq_XK", "sr", "sr_BA", "sr_Cyrl", "sr_Cyrl_BA", "sr_Cyrl_ME", "sr_Cyrl_RS", "sr_Cyrl_XK", "sr_Latn", "sr_Latn_BA", "sr_Latn_ME", "sr_Latn_RS", "sr_Latn_XK", "sr_ME", "sr_RS", "sr_XK", "sv", "sv_AX", "sv_FI", "sv_SE", "sw", "sw_KE", "sw_TZ", "sw_UG", "ta", "ta_IN", "ta_LK", "ta_MY", "ta_SG", "te", "te_IN", "th", "th_TH", "ti", "ti_ER", "ti_ET", "tl", "tl_PH", "to", "to_TO", "tr", "tr_CY", "tr_TR", "ug", "ug_Arab", "ug_Arab_CN", "ug_CN", "uk", "uk_UA", "ur", "ur_IN", "ur_PK", "uz", "uz_AF", "uz_Arab", "uz_Arab_AF", "uz_Cyrl", "uz_Cyrl_UZ", "uz_Latn", "uz_Latn_UZ", "uz_UZ", "vi", "vi_VN", "yi", "yo", "yo_BJ", "yo_NG", "zh", "zh_CN", "zh_HK", "zh_Hans", "zh_Hans_CN", "zh_Hans_HK", "zh_Hans_MO", "zh_Hans_SG", "zh_Hant", "zh_Hant_HK", "zh_Hant_MO", "zh_Hant_TW", "zh_MO", "zh_SG", "zh_TW", "zu", "zu_ZA"];
    protected static $validISOMC = ["af", "afna", "afza", "ak", "akgh", "am", "amet", "ar", "arae", "arbh", "ardj", "ardz", "areg", "areh", "arer", "aril", "ariq", "arjo", "arkm", "arkw", "arlb", "arly", "arma", "armr", "arom", "arps", "arqa", "arsa", "arsd", "arso", "arss", "arsy", "artd", "artn", "arye", "as", "asin", "az", "azaz", "azcyrl", "azcyrlaz", "azlatn", "azlatnaz", "be", "beby", "bg", "bgbg", "bm", "bmlatn", "bmlatnml", "bn", "bnbd", "bnin", "bo", "bocn", "boin", "br", "brfr", "bs", "bsba", "bscyrl", "bscyrlba", "bslatn", "bslatnba", "ca", "caad", "caes", "cafr", "cait", "cs", "cscz", "cy", "cygb", "da", "dadk", "dagl", "de", "deat", "debe", "dech", "dede", "deli", "delu", "dz", "dzbt", "ee", "eegh", "eetg", "el", "elcy", "elgr", "en", "enag", "enai", "enas", "enau", "enbb", "enbe", "enbm", "enbs", "enbw", "enbz", "enca", "encc", "enck", "encm", "encx", "endg", "endm", "ener", "enfj", "enfk", "enfm", "engb", "engd", "engg", "engh", "engi", "engm", "engu", "engy", "enhk", "enie", "enim", "enin", "enio", "enje", "enjm", "enke", "enki", "enkn", "enky", "enlc", "enlr", "enls", "enmg", "enmh", "enmo", "enmp", "enms", "enmt", "enmu", "enmw", "enmy", "enna", "ennf", "enng", "ennr", "ennu", "ennz", "enpg", "enph", "enpk", "enpn", "enpr", "enpw", "enrw", "ensb", "ensc", "ensd", "ensg", "ensh", "ensl", "enss", "ensx", "ensz", "entc", "entk", "ento", "entt", "entv", "entz", "enug", "enum", "enus", "envc", "envg", "envi", "envu", "enws", "enza", "enzm", "enzw", "eo", "es", "esar", "esbo", "escl", "esco", "escr", "escu", "esdo", "esea", "esec", "eses", "esgq", "esgt", "eshn", "esic", "esmx", "esni", "espa", "espe", "esph", "espr", "espy", "essv", "esus", "esuy", "esve", "et", "etee", "eu", "eues", "fa", "faaf", "fair", "ff", "ffcm", "ffgn", "ffmr", "ffsn", "fi", "fifi", "fo", "fofo", "fr", "frbe", "frbf", "frbi", "frbj", "frbl", "frca", "frcd", "frcf", "frcg", "frch", "frci", "frcm", "frdj", "frdz", "frfr", "frga", "frgf", "frgn", "frgp", "frgq", "frht", "frkm", "frlu", "frma", "frmc", "frmf", "frmg", "frml", "frmq", "frmr", "frmu", "frnc", "frne", "frpf", "frpm", "frre", "frrw", "frsc", "frsn", "frsy", "frtd", "frtg", "frtn", "frvu", "frwf", "fryt", "fy", "fynl", "ga", "gaie", "gd", "gdgb", "gl", "gles", "gu", "guin", "gv", "gvim", "ha", "hagh", "halatn", "halatngh", "halatnne", "halatnng", "hane", "hang", "he", "heil", "hi", "hiin", "hr", "hrba", "hrhr", "hu", "huhu", "hy", "hyam", "id", "idid", "ig", "igng", "ii", "iicn", "is", "isis", "it", "itch", "itit", "itsm", "ja", "jajp", "ka", "kage", "ki", "kike", "kk", "kkcyrl", "kkcyrlkz", "kkkz", "kl", "klgl", "km", "kmkh", "kn", "knin", "ko", "kokp", "kokr", "ks", "ksarab", "ksarabin", "ksin", "kw", "kwgb", "ky", "kycyrl", "kycyrlkg", "kykg", "lb", "lblu", "lg", "lgug", "ln", "lnao", "lncd", "lncf", "lncg", "lo", "lola", "lt", "ltlt", "lu", "lucd", "lv", "lvlv", "mg", "mgmg", "mk", "mkmk", "ml", "mlin", "mn", "mncyrl", "mncyrlmn", "mnmn", "mr", "mrin", "ms", "msbn", "mslatn", "mslatnbn", "mslatnmy", "mslatnsg", "msmy", "mssg", "mt", "mtmt", "my", "mymm", "nb", "nbno", "nbsj", "nd", "ndzw", "ne", "nein", "nenp", "nl", "nlaw", "nlbe", "nlbq", "nlcw", "nlnl", "nlsr", "nlsx", "nn", "nnno", "no", "nono", "om", "omet", "omke", "or", "orin", "os", "osge", "osru", "pa", "paarab", "paarabpk", "paguru", "paguruin", "pain", "papk", "pl", "plpl", "ps", "psaf", "pt", "ptao", "ptbr", "ptcv", "ptgw", "ptmo", "ptmz", "ptpt", "ptst", "pttl", "qu", "qubo", "quec", "qupe", "rm", "rmch", "rn", "rnbi", "ro", "romd", "roro", "ru", "ruby", "rukg", "rukz", "rumd", "ruru", "ruua", "rw", "rwrw", "se", "sefi", "seno", "sese", "sg", "sgcf", "sh", "shba", "si", "silk", "sk", "sksk", "sl", "slsi", "sn", "snzw", "so", "sodj", "soet", "soke", "soso", "sq", "sqal", "sqmk", "sqxk", "sr", "srba", "srcyrl", "srcyrlba", "srcyrlme", "srcyrlrs", "srcyrlxk", "srlatn", "srlatnba", "srlatnme", "srlatnrs", "srlatnxk", "srme", "srrs", "srxk", "sv", "svax", "svfi", "svse", "sw", "swke", "swtz", "swug", "ta", "tain", "talk", "tamy", "tasg", "te", "tein", "th", "thth", "ti", "tier", "tiet", "tl", "tlph", "to", "toto", "tr", "trcy", "trtr", "ug", "ugarab", "ugarabcn", "ugcn", "uk", "ukua", "ur", "urin", "urpk", "uz", "uzaf", "uzarab", "uzarabaf", "uzcyrl", "uzcyrluz", "uzlatn", "uzlatnuz", "uzuz", "vi", "vivn", "yi", "yo", "yobj", "yong", "zh", "zhcn", "zhhk", "zhhans", "zhhanscn", "zhhanshk", "zhhansmo", "zhhanssg", "zhhant", "zhhanthk", "zhhantmo", "zhhanttw", "zhmo", "zhsg", "zhtw", "zu", "zuza"];
    protected static $currentISO = "en";

    protected static $__isInitialized = false;
    protected static function __initialize()
    {
        if (self::$__isInitialized == true) return null;

        self::$validISOs      = Arr(self::$validISOs);
        self::$validISOMC     = Arr(self::$validISOMC);
        self::$languagesNames = Arr(self::$languagesNames);

        self::$__isInitialized = true;
    }

    public static function getDefaultISO()
    { return self::$currentISO; }

    public static function getDefaultFallbackISO()
    { return \Language::getFallbackISO(\Language::getDefaultISO()); }

    public static function setDefaultISO($isoCode)
    {
        self::$currentISO = self::formatISO($isoCode);
        if (self::$currentISO == null) self::$currentISO = self::DEFAULT_ISO;
    }

    protected static function validateAndFormat($isoCode)
    {
        self::__initialize();

        $isoCode = stringEx($isoCode)->toString();
        if (stringEx($isoCode)->isEmpty()) return Arr([valid => false, format => null]);

        $isValid = false;

        foreach (self::$validISOs as $validISO)
            if ($isoCode == $validISO)
            { $isValid = true; $isoCode = $validISO; break; }

        if ($isValid == false)
            foreach (self::$validISOs as $validISO)
                if ($isoCode == stringEx($validISO)->toLower())
                { $isValid = true; $isoCode = $validISO; break; }

        if ($isValid == true)
            return Arr([valid => true, format => $isoCode]);

        $isoCodeMC   = stringEx($isoCode)->toLower(false)->getOnlyLetters();
        $formatedISO = null;

        for ($i = 0; $i < self::$validISOMC->count; $i++)
            if (self::$validISOMC[$i] == $isoCodeMC)
            { $formatedISO = (self::$validISOs->containsKey($i) ? self::$validISOs[$i] : null); break;  }

        if ($formatedISO == null)
            return Arr([valid => false, format => null]);

        return Arr([valid => true, format => $formatedISO]);
    }

    public static function isValidISO($isoCode)
    {
        $validate = self::validateAndFormat($isoCode);
        return $validate->valid;
    }

    public static function formatISO($isoCode)
    {
        $validate = self::validateAndFormat($isoCode);
        if ($validate->valid == false) return false;
        return $validate->format;
    }

    public static function getFallbackISO($isoCode)
    {
        $validate = self::validateAndFormat($isoCode);
        if ($validate->valid == false) return false;

        if (stringEx($validate->format)->contains("_"))
            return stringEx($validate->format)->split("_")[0];
        return null;
    }

    public static function getAllLanguageName($formatIsoCode = null)
    {
        self::__initialize();

        if ($formatIsoCode != null) {
            $formatIsoCode = self::formatISO($formatIsoCode);
            if ($formatIsoCode == null) return null;
        }

        if ($formatIsoCode == null) $formatIsoCode = self::getDefaultISO();

        if (self::$languagesNames->containsKey($formatIsoCode))
            return self::$languagesNames[$formatIsoCode];

        self::loadLanguageISO($formatIsoCode);

        if (self::$languagesNames->containsKey($formatIsoCode))
            return self::$languagesNames[$formatIsoCode];

        return null;
    }

    public static function getAllLanguageISO()
    {
        $isos = Arr();
        $languages = self::getAllLanguageName();
        if ($languages != null)
            foreach ($languages as $iso => $value)
                $isos->add($iso);
        return $isos;
    }

    public static function getLanguageNameByISO($isoCode, $formatIsoCode = null)
    {
        self::__initialize();

        $isoCode = self::formatISO($isoCode);
        if ($isoCode == null) return null;

        if ($formatIsoCode != null) {
            $formatIsoCode = self::formatISO($formatIsoCode);
            if ($formatIsoCode == null) return null;
        }

        if ($formatIsoCode == null) $formatIsoCode = self::getDefaultISO();

        if (self::$languagesNames->containsKey($formatIsoCode)) {
            $languagePack = self::$languagesNames[$formatIsoCode];
            if ($languagePack->containsKey($isoCode))
                return $languagePack[$isoCode];

            return null;
        }

        self::loadLanguageISO($formatIsoCode);

        if (!self::$languagesNames->containsKey($formatIsoCode))
            return null;

        $languagePack = self::$languagesNames[$formatIsoCode];
        if ($languagePack->containsKey($isoCode))
            return $languagePack[$isoCode];

        return null;
    }

    protected static function getLanguageFolder()
    {
        $config = \Config::get();
        $pharEnabled = (\Connection::isCommandLineRequest() == false);

        if ($pharEnabled == false)
        {
            $cachePath = (\Garbage\Cache::getCachePath() . ".phar/Umpirsky.phar/");

            if (!\File::exists($cachePath . ".installed"))
            {
                \DirectoryEx::createDirectory($cachePath);
                $phar = new \Phar(__KRUPA_PATH_LIBRARY__ . "Umpirsky.phar", 0);
                $extracted = $phar->extractTo($cachePath, null, true);
                if ($extracted == true)
                    \File::setContents($cachePath . ".installed", "OK");

                if (!\File::exists($cachePath . ".installed"))
                { echo \Serialize\Json::encode([error => INTERNAL_SERVER_ERROR, message => "Missing Umpirsky lib."]); \KrupaBOX\Internal\Kernel::exit(); }
            }

            return $cachePath . "Language/";
        }

        return ("phar://" . __KRUPA_PATH_LIBRARY__ . "Umpirsky.phar/Language/");
    }

    protected static function loadLanguageISO($formatIsoCode)
    {
        self::__initialize();
        
        if (self::$languagesNames->containsKey($formatIsoCode)) return;
        $path = (self::getLanguageFolder() . $formatIsoCode . "/");

        $data   = null;
        $decode = null;

        if (\DirectoryEx::exists($path) && \File::exists($path . "language.json"))
            $data = \File::getContents($path . "language.json");
        
        if ($data != null)   $decode = \Serialize\Json::decode($data);
        if ($decode != null) self::$languagesNames[$formatIsoCode] = Arr($decode);
    }
}