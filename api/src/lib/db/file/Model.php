<?php

namespace app\lib\db\file;

use app\lib\db\Model as DbModel;
use app\models\Carros;

class Model extends DbModel{

    public static function checkFile()
    {
        $filepath = __DIR__ . '/../../../../data/';
        $filename = self::tablename() . '.json';

        $file = fopen($filepath . $filename, 'r+');
        if (!file_exists($filepath . $filename)) {
            @mkdir($filepath);
            fwrite($file, '');
        }

        return $file;
    }

    public static function findAll()
    {
        $filepath = __DIR__ . '/../../../../data/';
        $filename = self::tablename() . '.json';


        $file = self::checkFile();
        $content = file_get_contents($filepath . $filename);
        fclose($file);

        return json_decode($content);
    }

    public function save(): bool
    {
        $result = false;
        $filename = __DIR__ . '/../../../../data/' . self::tablename() . '.json';
        $file = self::checkFile();

        $content = file_get_contents($filename);

        if (empty($content)) {
            $list = [];
            array_push($list, get_object_vars($this));
            fwrite($file, json_encode($list));
            $result = true;
        } else {
            $list = json_decode($content);
            array_push($list, get_object_vars($this));
            fwrite($file, json_encode($list));
            $result = true;
        }
        fclose($file);

        return $result;
    }

    public function update()
    {
        $this->delete();
        $this->save();
    }

    public static function findOne($id)
    {
        $list = self::findAll();
        $data = (array) current(array_filter($list, function ($row) use ($id) {
            return $row->id === $id;
        }));

        $class = get_called_class();
        $object = new $class;
        $object->load($data);
        return $object;
    }

    public function delete() : bool
    {
        $filepath = __DIR__ . '/../../../../data/';
        $filename = self::tablename() . '.json';

        $list = array_filter(self::findAll(), function ($value) {
            return $value->id != $this->id;
        });
        array_splice($list, 0, 0);
        
        $file = fopen($filepath.$filename, 'w');
        fwrite($file, json_encode($list));
        fclose($file);
        
        return false;
    }
}