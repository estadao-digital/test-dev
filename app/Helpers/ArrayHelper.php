<?php

namespace App\Helpers;

class ArrayHelper {

    public function searchKeyRecursive( $key , $array )
    {
        if (array_key_exists($key, $array))
            return true;
            foreach ($array as $nested)
            {
                if (is_array($nested) && $this->searchKeyRecursive($key, $nested))
                    return true;
            }

        return false;
    }

    public function getFirstValueKeyRecursive( $keySearch , $array )
    {
        $iterator = new \RecursiveIteratorIterator( new \RecursiveArrayIterator( $array ) );
        foreach($iterator as $key => $value) {
            $d = $iterator->getDepth();
            if($key == $keySearch ){
                return $value;
            }
        }
    }
    
    public function generateKeySimpleValueByList( $key , $value , $list , $firstItem = null )
    {
        $finalList = [];
        if( !is_null( $firstItem ) )
            $finalList[ '' ] = $firstItem;
        foreach( $list as $item ){
            $finalList[ $item[$key] ] = $item[$value];
        }
        return $finalList;
    }

}