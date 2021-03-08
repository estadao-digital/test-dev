<?php

namespace Controller
{
    class Polling extends \Controller
    {
        const DEFAULT_TIMEOUT = 60;

        public static function onTimeout()
        { return [
            timeout => self::DEFAULT_TIMEOUT
        ];}

        public static function onPolling($input, $currentTime)
        { return self::error(TIMEOUT); }

        public static function onRequest($input)
        {
            $timeout = self::DEFAULT_TIMEOUT;

            $onTimeout = Arr(static::onTimeout());

            if ($onTimeout->containsKey(timeout))
                $timeout = floatEx($onTimeout->timeout)->toFloat();

            $finishTime = (\Time::getCurrent()->get() + $timeout);

            while (\Time::getCurrent()->get() <= $finishTime || $timeout <= 0)
            {
                $data = static::onPolling($input, ($timeout - ($finishTime - \Time::getCurrent()->get())) * 1000);

                if ($data == null)
                    return self::error(TIMEOUT);

                $data = Arr($data);

                if ($data->containsKey(error))
                    return self::error($data->error->message, $data->error->parameters);

                if ($data->containsKey(__internal__) == true && $data->__internal__ == true &&
                    $data->containsKey(polling) == true && $data->polling = true &&
                    $data->containsKey(action) == true && $data->action == wait)
                {
                    $seconds = (($data->containsKey(seconds)) ? floatEx($data->seconds)->toFloat() : 0.1);
                    if ($seconds <= 0) $seconds = 0.1;

                    \Model::cleanMemory();
                    \Time::sleep($seconds);
                }

                if ($data->containsKey(success))
                    return self::success($data->success);
            }

            return self::error(TIMEOUT);
        }

        protected static function waitForUpdate()
        { return self::waitForSeconds(0); }

        protected static function waitForSeconds($seconds)
        {
            $seconds = floatEx($seconds)->toFloat();
            if ($seconds <= 0) $seconds = 0.1;
            return Arr([polling => true, action => wait, seconds => $seconds, __internal__ => true]);
        }

        public static function timeout()
        { return self::error(TIMEOUT); }
    }
}
