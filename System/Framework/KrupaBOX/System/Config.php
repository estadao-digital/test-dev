<?php

class Config
{
    const CONFIG_VERSION = '2.3.2.2';

    protected static $config     = null;
    protected static $configHash = null;

    protected static $__isInitialized = false;
    protected static function __initialize()
    {
        if (self::$__isInitialized == true) return;
        self::$__isInitialized = true;

        $configApp = Arr(\KrupaBOX\Internal\Kernel::$configApp);

        $configAppSid = \KrupaBOX\Internal\Kernel::$configSidApp;
        if ($configAppSid !== null) $configAppSid = Arr($configAppSid);

        $configAppHash = \Security\Hash::toSha1($configApp);
        $configAppSidHash = \Security\Hash::toSha1($configAppSid);
        $configHash = \Security\Hash::toSha1($configAppHash . $configAppSidHash . self::CONFIG_VERSION);

        $configPathCache = (CACHE_FOLDER . '.krupabox/config/' . $configHash . '.blob');

        if (\File::exists($configPathCache)) {
            self::loadFromCache($configPathCache);
            return null;
        }

        self::mergeAndValidate($configApp, $configAppSid, $configHash);
        self::onLoadConfig();
        return null;
    }

    protected static function mergeAndValidate($configApp, $configSidApp, $configHash)
    {
        if ($configSidApp !== null)
            $configApp = $configApp->merge($configSidApp);

        $changed = false;

        if (!$configApp->containsKey('app')) {
            $configApp->server = Arr();
            $changed = true;
        }

        if (!$configApp->app->containsKey('name')) {
            $configApp->app->name = 'App Name';
            $changed = true;
        }

        if (!$configApp->app->containsKey('developed')) {
            $configApp->app->name = 'Authors Name';
            $changed = true;
        }

        if (!$configApp->app->containsKey('language') || $configApp->app->language === '') {
            $configApp->app->name = 'en';
            $changed = true;
        }

        if (!$configApp->containsKey('server')) {
            $configApp->server = Arr();
            $changed = true;
        }

        if (!$configApp->server->containsKey('timezone') || $configApp->server->timezone === '') {
            $configApp->server->timezone = 'UTC';
            $changed = true;
        }

        $timezoneTrim = stringEx($configApp->server->timezone)->trim("\r\n\t");
        if ($timezoneTrim !== $configApp->server->timezone) {
            $configApp->server->timezone = $timezoneTrim;
            $changed = true;
        }

        if (!$configApp->server->containsKey('environment')) {
            $configApp->server->environment = 'development';
            $changed = true;
        }

        $environmentLower = stringEx($configApp->server->environment)->toLower();
        if ($environmentLower !== $configApp->server->environment) {
            $configApp->server->environment = $environmentLower;
            $changed = true;
        }

        if ($configApp->server->environment !== 'release' && $configApp->server->environment !== 'development') {
            $configApp->server->environment = 'development';
            $changed = true;
        }

        if (!$configApp->containsKey('connection')) {
            $configApp->connection = Arr();
            $changed = true;
        }

        if (!$configApp->connection->containsKey('keepAlive')) {
            $configApp->connection->keepAlive = false;
            $changed = true;
        }

        if ($configApp->connection->keepAlive !== true && $configApp->connection->keepAlive !== false) {
            $configApp->connection->keepAlive = false;
            $changed = true;
        }

        if (!$configApp->connection->containsKey('onlySecure')) {
            $configApp->connection->onlySecure = false;
            $changed = true;
        }

        if ($configApp->connection->onlySecure !== true && $configApp->connection->onlySecure !== false) {
            $configApp->connection->onlySecure = false;
            $changed = true;
        }

        if (!$configApp->connection->containsKey('onlyWWW')) {
            $configApp->connection->onlyWWW = false;
            $changed = true;
        }

        if ($configApp->connection->onlyWWW !== true && $configApp->connection->onlyWWW !== false) {
            $configApp->connection->onlyWWW = false;
            $changed = true;
        }

        if (!$configApp->connection->containsKey('onlyWWW')) {
            $configApp->connection->onlyWWW = false;
            $changed = true;
        }

        if ($configApp->connection->onlyNonWWW !== true && $configApp->connection->onlyNonWWW !== false) {
            $configApp->connection->onlyNonWWW = false;
            $changed = true;
        }

        if ($configApp->connection->onlyWWW === true && $configApp->connection->onlyNonWWW === true) {
            $configApp->connection->onlyNonWWW = false;
            $changed = true;
        }

        if (!$configApp->containsKey('cryptography')) {
            $configApp->cryptography = Arr();
            $changed = true;
        }

        if (!$configApp->cryptography->containsKey('default') || $configApp->cryptography->default === '') {
            $configApp->cryptography->default = 'KRUPABOX_CRYPTOGRAPHY_KEY_DEFAULT';
            $changed = true;
        }

        if (!$configApp->containsKey('database')) {
            $configApp->database = Arr();
            $changed = true;
        }

        if (!$configApp->database->containsKey('driver') || $configApp->database->driver === '') {
            $configApp->database->driver = 'mysqli';
            $changed = true;
        }

        $driverLower = $configApp->database->driver = stringEx($configApp->database->driver)->toLower();
        if ($driverLower !== $configApp->database->driver) {
            $configApp->database->driver = $driverLower;
            $changed = true;
        }

        if (!$configApp->database->containsKey('sid') || $configApp->database->sid === '') {
            $configApp->database->sid = 'krupabox';
            $changed = true;
        }

        if (!$configApp->database->containsKey('username') || $configApp->database->username === '') {
            $configApp->database->username = 'root';
            $changed = true;
        }

        if (!$configApp->database->containsKey('host') || $configApp->database->host === '') {
            $configApp->database->host = 'localhost';
            $changed = true;
        }

        if (!$configApp->database->containsKey('password') || $configApp->database->password === '') {
            $configApp->database->password = null;
            $changed = true;
        }

        if (!$configApp->database->containsKey('migration')) {
            $configApp->database->migration = true;
            $changed = true;
        }

        if ($configApp->database->migration !== true && $configApp->database->migration !== false) {
            $configApp->database->migration = true;
            $changed = true;
        }

        if (!$configApp->database->containsKey('cache')) {
            $configApp->database->cache = Arr();
            $changed = true;
        }

        if (!$configApp->database->cache->containsKey('file')) {
            $configApp->database->cache->file = true;
            $changed = true;
        }

        if ($configApp->database->cache->file !== true && $configApp->database->cache->file !== false) {
            $configApp->database->cache->file = true;
            $changed = true;
        }

        if (!$configApp->database->cache->containsKey('redis')) {
            $configApp->database->cache->redis = false;
            $changed = true;
        }

        if ($configApp->database->cache->redis !== true && $configApp->database->cache->redis !== false) {
            $configApp->database->cache->redis = false;
            $changed = true;
        }

        if ($configApp->database->cache->redis === true && $configApp->database->cache->file === true) {
            $configApp->database->cache->file = false;
            $changed = true;
        }

        if ($configApp->database->cache->redis === false && $configApp->database->cache->file === false) {
            $configApp->database->cache->file = true;
            $changed = true;
        }


        if (!$configApp->containsKey('render')) {
            $configApp->render = Arr();
            $changed = true;
        }

        if (!$configApp->render->containsKey('cache')) {
            $configApp->render->cache = Arr();
            $changed = true;
        }

        if (!$configApp->render->cache->containsKey('file')) {
            $configApp->render->cache->file = true;
            $changed = true;
        }

        if ($configApp->render->cache->file !== true && $configApp->render->cache->file !== false) {
            $configApp->render->cache->file = true;
            $changed = true;
        }

        if (!$configApp->render->cache->containsKey('redis')) {
            $configApp->render->cache->redis = false;
            $changed = true;
        }

        if ($configApp->render->cache->redis !== true && $configApp->render->cache->redis !== false) {
            $configApp->render->cache->redis = false;
            $changed = true;
        }

        if ($configApp->render->cache->redis === true && $configApp->render->cache->file === true) {
            $configApp->render->cache->file = false;
            $changed = true;
        }

        if ($configApp->render->cache->redis === false && $configApp->render->cache->file === false) {
            $configApp->render->cache->file = true;
            $changed = true;
        }

        if (!$configApp->containsKey('front')) {
            $configApp->front = Arr();
            $changed = true;
        }

        if (!$configApp->front->containsKey('base')) {
            $configApp->front->base = '';
            $changed = true;
        }

        if (stringEx($configApp->front->base)->isEmpty() === false)
        {
            $validBase = $configApp->front->base;
            $validBase = stringEx($validBase)->replace("\\", '/');
            while (stringEx($validBase)->contains('//'))
                $validBase = stringEx($validBase)->replace('//', '/');
            while (stringEx($validBase)->startsWith('/'))
                $validBase = stringEx($validBase)->subString(1);
            while (stringEx($validBase->endsWith('/')))
                $validBase = stringEx($validBase)->subString(0, (stringEx($validBase)->length - 1));

            if (stringEx($validBase)->isEmpty() === false)
                $validBase = ('/' . $validBase);


            if ($validBase !== $configApp->front->base) {
                $configApp->front->base = $validBase;
                $changed = true;
            }
        }


        if (!$configApp->front->containsKey('polyfill')) {
            $configApp->front->polyfill = Arr();
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('blob')) {
            $configApp->front->polyfill->blob = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->blob !== true && $configApp->front->polyfill->blob !== false) {
            $configApp->front->polyfill->blob = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('canvas')) {
            $configApp->front->polyfill->canvas = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->canvas !== true && $configApp->front->polyfill->canvas !== false) {
            $configApp->front->polyfill->canvas = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('legacyBrowser')) {
            $configApp->front->polyfill->legacyBrowser = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->legacyBrowser !== true && $configApp->front->polyfill->legacyBrowser !== false) {
            $configApp->front->polyfill->legacyBrowser = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('ecmaScript5')) {
            $configApp->front->polyfill->ecmaScript5 = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->ecmaScript5 !== true && $configApp->front->polyfill->ecmaScript5 !== false) {
            $configApp->front->polyfill->ecmaScript5 = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('ecmaScript6')) {
            $configApp->front->polyfill->ecmaScript6 = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->ecmaScript6 !== true && $configApp->front->polyfill->ecmaScript6 !== false) {
            $configApp->front->polyfill->ecmaScript6 = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('ecmaScript7')) {
            $configApp->front->polyfill->ecmaScript6 = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->ecmaScript7 !== true && $configApp->front->polyfill->ecmaScript7 !== false) {
            $configApp->front->polyfill->ecmaScript7 = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('html5')) {
            $configApp->front->polyfill->html5 = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->html5 !== true && $configApp->front->polyfill->html5 !== false) {
            $configApp->front->polyfill->html5 = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('keyboard')) {
            $configApp->front->polyfill->keyboard = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->keyboard !== true && $configApp->front->polyfill->keyboard !== false) {
            $configApp->front->polyfill->keyboard = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('typedArray')) {
            $configApp->front->polyfill->typedArray = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->typedArray !== true && $configApp->front->polyfill->typedArray !== false) {
            $configApp->front->polyfill->typedArray = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('url')) {
            $configApp->front->polyfill->url = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->url !== true && $configApp->front->polyfill->url !== false) {
            $configApp->front->polyfill->url = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('web')) {
            $configApp->front->polyfill->web = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->web !== true && $configApp->front->polyfill->web !== false) {
            $configApp->front->polyfill->web = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('webAudio')) {
            $configApp->front->polyfill->webAudio = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->webAudio !== true && $configApp->front->polyfill->webAudio !== false) {
            $configApp->front->polyfill->webAudio = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('xhr')) {
            $configApp->front->polyfill->xhr = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->xhr !== true && $configApp->front->polyfill->xhr !== false) {
            $configApp->front->polyfill->xhr = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('promise')) {
            $configApp->front->polyfill->promise = true;
            $changed = true;
        }

        if ($configApp->front->polyfill->promise !== true && $configApp->front->polyfill->promise !== false) {
            $configApp->front->polyfill->promise = true;
            $changed = true;
        }

        if (!$configApp->front->polyfill->containsKey('prefix')) {
            $configApp->front->polyfill->prefix = false;
            $changed = true;
        }

        if ($configApp->front->polyfill->prefix !== true && $configApp->front->polyfill->prefix !== false) {
            $configApp->front->polyfill->prefix = false;
            $changed = true;
        }

        if (!$configApp->front->containsKey('support')) {
            $configApp->front->support = Arr();
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('render')) {
            $configApp->front->support->render = true;
            $changed = true;
        }

        if ($configApp->front->support->render !== true && $configApp->front->support->render !== false) {
            $configApp->front->support->render = true;
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('validate')) {
            $configApp->front->support->validate = true;
            $changed = true;
        }

        if ($configApp->front->support->validate !== true && $configApp->front->support->validate !== false) {
            $configApp->front->support->validate = true;
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('webgl')) {
            $configApp->front->support->webgl = false;
            $changed = true;
        }

        if ($configApp->front->support->webgl !== true && $configApp->front->support->webgl !== false) {
            $configApp->front->support->webgl = false;
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('screenshot')) {
            $configApp->front->support->screenshot = false;
            $changed = true;
        }

        if ($configApp->front->support->screenshot !== true && $configApp->front->support->screenshot !== false) {
            $configApp->front->support->screenshot = false;
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('gyroscope')) {
            $configApp->front->support->gyroscope = false;
            $changed = true;
        }

        if ($configApp->front->support->gyroscope !== true && $configApp->front->support->gyroscope !== false) {
            $configApp->front->support->gyroscope = false;
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('prefix')) {
            $configApp->front->support->prefix = false;
            $changed = true;
        }

        if ($configApp->front->support->prefix !== true && $configApp->front->support->prefix !== false) {
            $configApp->front->support->prefix = false;
            $changed = true;
        }

        if (!$configApp->front->support->containsKey('react')) {
            $configApp->front->support->react = false;
            $changed = true;
        }

        if ($configApp->front->support->react !== true && $configApp->front->support->react !== false) {
            $configApp->front->support->react = false;
            $changed = true;
        }

        if (!$configApp->containsKey('output')) {
            $configApp->output = Arr();
            $changed = true;
        }

        if (!$configApp->output->containsKey('gzip')) {
            $configApp->output->gzip = true;
            $changed = true;
        }

        if ($configApp->output->gzip !== true && $configApp->output->gzip !== false) {
            $configApp->output->gzip = true;
            $changed = true;
        }

        if (!$configApp->output->containsKey('deflate')) {
            $configApp->output->deflate = true;
            $changed = true;
        }

        if ($configApp->output->deflate !== true && $configApp->output->deflate !== false) {
            $configApp->output->deflate = true;
            $changed = true;
        }

        if (!$configApp->containsKey('redis')) {
            $configApp->redis = Arr();
            $changed = true;
        }

        if (!$configApp->redis->containsKey('host') || $configApp->redis->host === '') {
            $configApp->redis->host = 'localhost';
            $changed = true;
        }

        if (!$configApp->redis->containsKey('port') || $configApp->redis->port === '') {
            $configApp->redis->port = '6379';
            $changed = true;
        }

        $configJSON = \JSON::stringfy($configApp);
        $configApp->sortByKey();

        foreach ($configApp as $configItem)
            if (\Arr::isArr($configItem) === true)
                $configItem->sortByKey();

        self::$config = $configApp;
        $serverSid = \KrupaBOX\Internal\Kernel::$configSid;

        if ($changed === true) {
            if ($serverSid === null || $serverSid === '') {
                $serverData = Arr(self::$config->toArray());
                $serverData->server->removeKey('sid');

                $path = ('config://Application.json');
                \File::setContents($path, \json_encode($serverData, JSON_PRETTY_PRINT));
                return null;
            }
            else
            {
                $serverSidData = Arr(self::$config->toArray());
                $serverSidData->server->removeKey('sid', 'sidPaths');

                $path = ('config://Application/' . $serverSid . '.json');
                \File::setContents($path, \json_encode($serverSidData, JSON_PRETTY_PRINT));
                return null;

            }
        }
        else {
            self::saveToCache($configHash);
        }

        if (!self::$config->server->containsKey('sid'))
            self::$config->server->sid = null;

        return null;
    }

    protected static function checkMissingVars()
    {
        if (!self::$config->containsKey(output))
            self::$config->output = Arr();

        if (!self::$config->output->containsKey(gzip))
            self::$config->output->gzip = "true";
        if (!self::$config->output->containsKey(deflate))
            self::$config->output->deflate = "true";

        self::$config->output->gzip = \boolEx(self::$config->output->gzip)->toBool();
        self::$config->output->deflate = \boolEx(self::$config->output->deflate)->toBool();
    }

    protected static function stringKeysToArrayData($data)
    {
        $withDefaultKey = Arr();
        $withDeepKeys   = Arr();

        foreach ($data as $key => $value)
        {
            if (!stringEx($key)->contains("."))
            { $withDefaultKey[$key] = $value; continue;  }

            $split = stringEx($key)->split(".");
            $deepKey = "";

            foreach ($split as $_split)
                if ($_split != $split[0])
                    $deepKey .= $_split . ".";

            if (stringEx($deepKey)->endsWith("."))
                $deepKey = stringEx($deepKey)->subString(0, -1);

            if (!$withDeepKeys->containsKey($split[0]))
                $withDeepKeys[($split[0])] = Arr();

            $withDeepKeys[($split[0])][$deepKey] = $value;
            $deepArray = self::stringKeysToArrayData($withDeepKeys[($split[0])]);
            $withDeepKeys[($split[0])] = $deepArray;
        }

        $data = Arr();
        foreach ($withDefaultKey as $key => $value) $data[$key] = $value;
        foreach ($withDeepKeys as $key => $value)   $data[$key] = $value;

        return $data;
    }

    protected static function loadFromCache($path)
    {
        \Import::PHP($path);
    }

    public static function get()
    {
        self::__initialize();
        return self::$config;
    }

    public static function __fromCache($cachedConfig)
    {
        self::$config = Arr($cachedConfig);
    }

    protected static function saveToCache($configHash)
    {
        $path = \Garbage\Cache::getCachePath() . ".krupabox/config/" . $configHash . ".blob";

        if (\File::exists($path) === true)
            return null;

        ob_start(); \var_export(self::$config->toArray()); $buffer = ob_get_contents(); ob_end_clean();
        $varExport = ('<?php \Config::__fromCache(' . $buffer . ');');
        \File::setContents(\Garbage\Cache::getCachePath() . ".krupabox/config/" . $configHash . ".blob", $varExport);
    }

    protected static function onLoadConfig()
    {
        \Language::setDefaultISO(self::$config->app->language);
        self::$config->app->language = \Language::getDefaultISO();
    }
}