<?php

namespace Model
{
    class Container extends \Arr
    {
//        protected $logSQL = null;

        public function offsetGet($offset)
        {
//            if ($offset == "logSQL")
//                return $this->logSQL;

            return parent::offsetGet($offset);
        }

        public function offsetSet($offset, $value)
        {
//            if ($offset == "logSQL")
//            { $this->logSQL = $value; return null; }

            parent::offsetSet($offset, $value);
        }

//        public function addLogSQL($logSql)
//        {
//            if (!stringEx($logSql)->isEmpty())
//            {
//                if ($this->logSQL == null)
//                    $this->logSQL = Arr();
//
//                $this->logSQL->add(stringEx($logSql)->toString());
//            }
//
//        }

        public function toArr($includeChildrens = false)
        {
            $arr = Arr($this);
            if ($includeChildrens == true)
                $arr = $arr->convertChildrens();
            return $arr;
        }
    }
}
