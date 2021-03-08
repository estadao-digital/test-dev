<?php

namespace Application\Server\Component
{
    class Fipe
    {
        protected static $brands = null;

        public static function getBrands()
        {
            if (self::$brands !== null)
                return self::$brands;

            $brandsJson     = \File::getContents('config://Fipe/brands.json');
            $brandsData     = \Json::parse($brandsJson);
            self::$brands   = Arr();

            foreach ($brandsData as $brand)
                self::$brands[] = $brand->fipe_name;

            return self::$brands;
        }

        public static function getByBrandId(int $brandId)
        {
            if ($brandId <= 0)
                return null;

            $brands = self::getBrands();
            if ($brands->containsKey($brandId))
                return $brands[$brandId];

            return null;
        }
    }
}

