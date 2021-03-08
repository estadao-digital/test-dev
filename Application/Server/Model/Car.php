<?php

namespace Application\Server\Model
{
    use Application\Server\Model;

    /**
     * Class User
     * @package Application\Server\Model
     * @table car
     */
    class Car extends \Model
    {
        /**
         * @type int
         * @define isPrimary
         * @define autoIncrement
         * @define cantUpdate
         */
        public $carId;

        /**
         * @type int
         * @define isNullable
         */
        public $brandId;

        /**
         * @type varchar(128)
         * @define isNullable
         */
        public $model;

        /**
         * @type varchar(4)
         * @define isNullable
         */
        public $year;

        /**
         * @type bool
         * @define isEnumerated
         */
        public $deleted;

        /**
         * @type \DateTimeEx
         * @define isNullable
         */
        public $date;

        /**
         * @type \DateTimeEx
         * @define isNullable
         */
        public $dateUpdate;

        public static function getByCarId(int $carId)
        {
            if ($carId <= 0)
                return null;

            $result = self::selectAll() ->
                whereEquals ('carId', $carId) ->
                limit(1)->
                result();

            return ($result === null)
                ? null : $result[0];
        }

        public static function getAll(int $limit = null)
        {
            if ($limit <= 0)
                $limit = \intEx::LIMIT;

            $result = self::selectAll() ->
                whereEquals ('deleted', 'false')->
                limit($limit)->
                result();

            return $result;
        }

        public static function getCount()
        {
            return self::selectAll()->
                whereEquals('deleted', false)->
                getCount();
        }

        protected function onSave($model)
        {
            $data = null;

            if (!$model->containsField('date') || $model->date === null) {
                $model->date = null;

                if ($model->containsField('carId') && $model->carId !== null && $model->carId > 0) {
                    $data           = self::getByCarId($model->carId);
                    $model->date    = $data->date;
                }

                if ($model->date === null)
                    $model->date = \DateTimeEx::now();
            }

            $model->dateUpdate = \DateTimeEx::now();
            return $model;
        }
    }
}