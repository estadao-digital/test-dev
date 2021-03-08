<?php


class Serialize
{
    public static function fromInstance($instance = null)
    { return new Serialize(null, null, null, $instance, null); }

    public static function fromSerialized($serializedString = null)
    {
        $decodeSerialized = \Serialize\Base64::decode($serializedString);
        $serializeInstance = \Serialize\Php::decode($decodeSerialized);

        if ($serializeInstance == null) return null;

        return new Serialize(
            null,
            (isset($serializeInstance->dateCreate)   ? $serializeInstance->dateCreate : null),
            (isset($serializeInstance->dateUpdate)   ? $serializeInstance->dateUpdate : null),
            (isset($serializeInstance->instance))    ? \Serialize\Php::decode($serializeInstance->instance) : null,
            (isset($serializeInstance->instanceType) ? $serializeInstance->instanceType : null)
        );
    }
    
    public static function fromPhpString($phpString = null)
    { if ($phpString == null) return null; return new Serialize($phpString); }
    
    public static function fromJsonString($jsonString = null)
    {
        if ($jsonString == null) return null;

        $decode = \Serialize\Json::decode($jsonString);
        $encode = \Serialize\Php::encode($decode);

        if ($encode == null) return null;
        return new Serialize($encode);
    }
    
    public static function fromXmlString($xmlString = null)
    {
        if ($xmlString == null) return null;
        $json = \Serialize\Json::encodeFromXmlString($xmlString);

        if ($json == null) return null;
        return self::fromJsonString($json);
    }

    protected $instance = null;
    protected $phpString = null;

    protected $instanceType = null;

    protected $dateCreate = null;
    protected $dateUpdate = null;

    protected function __construct($phpString = null, $dateCreate = null, $dateUpdate = null, $instance = null, $instanceType = null)
    {
        $this->phpString = $phpString;
        $this->instance = $instance;

        $this->instanceType = $instanceType;
        $this->updateInstanceType();

        $this->dateCreate = $dateCreate;
        $this->dateUpdate = $dateUpdate;
    }

    public function __get($key)
    {
        if ($key == dateCreate)
        {
            if ($this->dateCreate == null)
                $this->dateCreate = \DateTimeEx::now();

            if ($this->dateUpdate == null)
                $this->dateUpdate = new \DateTimeEx($this->dateCreate);

            return $this->dateCreate;
        }
        elseif ($key == dateUpdate)
        {
            if ($this->dateUpdate == null)
            {
                if ($this->dateCreate == null)
                    $this->dateCreate = \DateTimeEx::now();

                $this->dateUpdate = new \DateTimeEx($this->dateCreate);
            }

            if ($this->dateCreate == null)
                $this->dateCreate = \DateTimeEx::now();

            return $this->dateUpdate;
        }
        elseif ($key == instanceType)
            return $this->instanceType;

        return null;
    }

    public function __set($key, $value)
    {
        if ($key == dateCreate)
        {
            $this->__get(dateCreate);
            $this->dateCreate = new \DateTimeEx($value);
        }
        elseif ($key == dateUpdate)
        {
            $this->__get(dateUpdate);
            $this->dateUpdate = new \DateTimeEx($value);
        }
    }

    protected function updateInstanceType()
    {
        if ($this->instance != null && $this->instanceType == null)
        {
            $this->instanceType = \Instance::getNameForInstantiate($this->instance);

            if ($this->instanceType == null)
                \Variable::get($this->instance)->getType();
        }
    }

    public function toInstance()
    {
        $dateCreate = $this->__get(dateCreate);
        $dateUpdate = $this->__get(dateUpdate);

        if ($this->instance != null)
            return $this->instance;

        $this->instance = \Serialize\Php::decode($this->phpString);
        $this->updateInstanceType();
        return $this->instance;
    }

    public function toJson()
    {
        $instance = $this->toInstance();
        return \Serialize\Json::encode($instance);
    }

    public function toSerialized()
    {
        $serializedObject = (object)[
            instance     => \Serialize\Php::encode($this->toInstance()),
            dateCreate   => $this->__get(dateCreate),
            dateUpdate   => $this->__get(dateUpdate),
            instanceType => $this->__get(instanceType)
        ];

        //dump($serializedObject);
        $encodeSerializeObject = \Serialize\Php::encode($serializedObject);
        //dump($encodeSerializeObject);
        $encodeBase64 = \Serialize\Base64::encode($encodeSerializeObject);
        //dump($encodeBase64);
        return $encodeBase64;
    }
}