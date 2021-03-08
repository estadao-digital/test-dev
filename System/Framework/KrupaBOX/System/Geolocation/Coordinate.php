<?php

namespace Geolocation
{
    class Coordinate
    {
        protected $latitude  = 0;
        protected $longitude = 0;

        public function __construct($latitude = null, $longitude = null)
        {
            $this->__set(latitude, $latitude);
            $this->__set(longitude, $longitude);
        }

        public function __set($key, $value = null)
        {
            if ($key == latitude) $this->latitude = floatEx($value)->toFloat();
            elseif ($key == longitude) $this->longitude = floatEx($value)->toFloat();
        }

        public function __get($key)
        {
            if ($key == latitude) return $this->latitude;
            elseif ($this->longitude) return $this->longitude;

            return null;
        }

        public function getDistanceMeters(Coordinate $coordinate)
        {
            $earthRadius = 6371000;

            $latFrom = deg2rad($this->latitude);
            $lonFrom = deg2rad($this->longitude);
            $latTo = deg2rad($coordinate->latitude);
            $lonTo = deg2rad($coordinate->longitude);

            $lonDelta = $lonTo - $lonFrom;
            $a = pow(cos($latTo) * sin($lonDelta), 2) +
                pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
            $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

            $angle = atan2(sqrt($a), $b);
            $meters = floatEx($angle * $earthRadius)->toFloat();
            return $meters;
        }

        public function toArr()
        { return Arr([latitude => $this->latitude, longitude => $this->longitude]); }
    }
}
