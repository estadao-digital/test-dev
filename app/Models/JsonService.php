<?php


namespace App\Models;


class JsonService
{
    private static $state;
    public static function load(){
        self::$state = json_decode(file_get_contents(base_path().'/cars.json'));
        return self::$state;
    }
    public static function get($id){
        $data = collect(self::load())->sortBy('id');
        return $data->where('id', $id)->first();
    }
    public static function insert($car){
        $data = collect(self::load())->sortBy('id');
        $id = $data->last()->id + 1;
        $car->id = $id;
        $data->push($car);
        self::save($data);

    }

    public static function change($id, $fields){
        $data = collect(self::load())->sortBy('id');
        foreach($fields as $field => $value){
            $data->where('id', $id)->first()->$field = $value;
        }
        self::save($data);
    }
    public static function delete($id){
        $data = collect(self::load())->sortBy('id');
        $item = $data->where('id', $id)->keys()->first();
        @$data->forget($item);
        self::save($data);
        return collect(self::load())->all();
    }
    private static function save($data){
        file_put_contents(base_path().'/cars.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
