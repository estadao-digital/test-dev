<?php

namespace Database\Table
{
    class Field
    {
        protected static $__CI = null;
        protected static function __initialize()
        {
            self::$__CI = \CodeIgniter::getInstance();
            self::$__CI->load->dbutil();
            self::$__CI->load->dbforge();
            \KrupaBOX\Internal\Loader::loadLinkDB();
        }

        public static function getAllByTable($table)
        {
            self::__initialize();
            if (\Database\Table::exists($table) == false)
                return null;

            $data = \Database::query("SHOW COLUMNS FROM `" . $table . "`");
            if ($data->count <= 0) $data = Arr();

            $fields = Arr();

            foreach ($data as $_field)
            {
                $field = Arr();
                $field->field      = $_field->Field;
                $field->type       = null;
                $field->constraint = null;
                $field->enumerators = null;

                $type = stringEx($_field->Type)->split("(");
                if ($type->count >= 2)
                {
                    $field->type = $type[0];

                    if ($field->type == "enum")
                    {
                        $enum = stringEx($type[1])->subString(0, -1, false)->decode();
                        $enum = stringEx($enum)->split(",");

                        $field->enumerators = Arr();
                        foreach ($enum as $_enum) {
                            $_enum = stringEx($_enum)->subString(1);
                            $_enum = stringEx($_enum)->subString(0, -1);
                            $field->enumerators->add($_enum);
                        }
                    }
                    else
                    {
                        $type[1] = stringEx($type[1])->remove(")");
                        $type[1] = toInt($type[1]);
                        if ($type[1] > 0) $field->constraint = $type[1];
                    }
                }
                else $field->type = $_field->Type;

                $field->isNullable = toBool($_field->Null);
                $field->isPrimary  = stringEx($_field->Key)->toLower(false)->contains("pri");
                $field->default    = $_field->Default;
                $field->autoIncrement = stringEx($_field->Extra)->toLower(false)->contains("auto_increment");

                $fields->addKey($field->field, $field);
            }

            return $fields;
        }

        public static function getByTableAndField($table, $fieldName)
        {
            $fields = self::getAllByTable($table);
            if ($fields == null) return null;

            foreach ($fields as $key => $field)
                if ($key == $fieldName)
                    return $field;
            return null;
        }

        public static function remove($table, $field)
        {
            self::__initialize();

            $fields = self::getAllByTable($table);
            self::$__CI->load->dbforge();

            return self::$__CI->dbforge->drop_column($table, $field);
        }

        public static function addOrUpdate($table, $fieldData, $afterField = null, $forceUpdateLength = false)
        {
            self::__initialize();

            $field = Arr($fieldData);
            $afterField = toString($afterField);

            $table = toString($table);
            if (stringEx($table)->isEmpty()) return null;
            if (\Database\Table::exists($table) == false)
                return null;

            $fields = self::getAllByTable($table);

            if ($fields->containsKey($fieldData->field))
            {
                $dbField = Arr($fields[$fieldData->field])->copy();

                if ($fieldData->containsKey(type) && stringEx($fieldData->type)->isEmpty() == false) {
                    if ($dbField->type != $fieldData->type)
                        $forceUpdateLength = true;
                    $dbField->type = $fieldData->type;
                }

                if ($forceUpdateLength == true && $fieldData->containsKey(constraint) && toInt($fieldData->constraint) > 0)
                    $dbField->constraint = $fieldData->constraint;

                if($fieldData->containsKey(enumerators))
                    $dbField->enumerators = $fieldData->enumerators;
                if($fieldData->containsKey(isNullable))
                    $dbField->isNullable = $fieldData->isNullable;
                if($fieldData->containsKey(isPrimary))
                    $dbField->isPrimary = $fieldData->isPrimary;
                if($fieldData->containsKey("default"))
                    $dbField->default = $fieldData->default;
                if($fieldData->containsKey(autoIncrement))
                    $dbField->autoIncrement = $fieldData->autoIncrement;

                $fieldData = $dbField;

                if ($fieldData->containsKey(field) == false || stringEx($fieldData->field)->isEmpty() == true)
                    return false;
                if ($fieldData->containsKey(type) == false || stringEx($fieldData->type)->isEmpty() == true)
                    return null;


                $query = "ALTER TABLE `" . $table . "` CHANGE `";
                $query .= stringEx($fieldData->field)->remove("`");
                $query .= "` `" . stringEx($fieldData->field)->remove("`") . "` ";
                $query .= stringEx($fieldData->type)->toUpper();

                if (stringEx($fieldData->type)->toLower() == "enum")
                {
                    if ($fieldData->containsKey(enumerators) == false)
                        return null;

                    $fieldData->enumerators = Arr($fieldData->enumerators);
                    if ($fieldData->enumerators->count <= 0) return null;

                    $query .= "(";
                    foreach ($fieldData->enumerators as $enum)
                        $query .= (\Database::escape($enum) . ",");
                    $query = stringEx($query)->subString(0, -1);
                    $query .= ")";

                    $query .= " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                    $fieldData->isNullable = false;
                    $fieldData->default = $fieldData->enumerators[0];
                }
                else
                {
                    if ($fieldData->containsKey(constraint) == true)
                    {
                        $constraint = toInt($fieldData->constraint);
                        if ($constraint > 0)
                            $query .= ("(" . $constraint . ")");
                    }
                }

                $query .= " ";

                if ($fieldData->containsKey(isNullable) == false)
                    $fieldData->isNullable = false;

                if ($fieldData->isNullable == true)
                    $query .= "NULL ";
                else $query .= "NOT NULL ";

                if ($fieldData->containsKey("default") && $fieldData->default != "")
                    $query .= ("DEFAULT " . \Database::escape($fieldData->default) . " ");

                if ($fieldData->containsKey("autoIncrement") && $fieldData->autoIncrement == true)
                    $query .= ("AUTO_INCREMENT ");

                if ($afterField != "" && $fields->containsKey($afterField))
                    $query .= ("AFTER `" . $afterField . "` ");

                if (($fieldData->containsKey(isPrimary) && $fieldData->isPrimary == true) || ($fieldData->containsKey(autoIncrement) && $fieldData->autoIncrement == true))
                {
                    foreach ($fields as $dbField)
                    {
                        if (($dbField->isPrimary == true || $dbField->autoIncrement == true) && $dbField->field != $fieldData->field)
                        {
                            $dbField->isPrimary = false;
                            $dbField->autoIncrement = false;
                            self::addOrUpdate($table, $dbField, null, true);
                        }
                    }

                    $query .= (", ADD PRIMARY KEY (`" . stringEx($fieldData->field)->remove("`") . "`)");
                }

                $dbField = $fields[$fieldData->field];

                \Database::query($query);

                // Case is removing primary key
                if (($dbField->isPrimary == true && $fieldData->isPrimary == false) || ($dbField->autoIncrement == true && $fieldData->autoIncrement == false))
                {
                    $queryRemoveKey = "ALTER TABLE `" . $table . "` DROP PRIMARY KEY;";
                    \Database::query($queryRemoveKey);
                }

                $fields = self::getAllByTable($table);
                return $fields->containsKey($fieldData->field);
            }
            else
            {
                if ($fieldData->containsKey(field) == false || stringEx($fieldData->field)->isEmpty() == true)
                    return false;
                if ($fieldData->containsKey(type) == false || stringEx($fieldData->type)->isEmpty() == true)
                    return null;


                $query = "ALTER TABLE `" . $table . "` ADD `";
                $query .= stringEx($fieldData->field)->remove("`");
                $query .= "` ";
                $query .= stringEx($fieldData->type)->toUpper();

                if (stringEx($fieldData->type)->toLower() == "enum")
                {
                    if ($fieldData->containsKey(enumerators) == false)
                        return null;

                    $fieldData->enumerators = Arr($fieldData->enumerators);
                    if ($fieldData->enumerators->count <= 0) return null;

                    $query .= "(";
                    foreach ($fieldData->enumerators as $enum)
                        $query .= (\Database::escape($enum) . ",");
                    $query = stringEx($query)->subString(0, -1);
                    $query .= ")";

                    $query .= " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                    $fieldData->isNullable = false;
                    $fieldData->default = $fieldData->enumerators[0];
                }
                else
                {
                    if ($fieldData->containsKey(constraint) == true)
                    {
                        $constraint = toInt($fieldData->constraint);
                        if ($constraint > 0)
                            $query .= ("(" . $constraint . ")");
                    }
                }

                $query .= " ";

                if ($fieldData->containsKey(isNullable) == false)
                    $fieldData->isNullable = false;

                if ($fieldData->isNullable == true)
                    $query .= "NULL ";
                else $query .= "NOT NULL ";

                if ($fieldData->containsKey("default") && $fieldData->default != "")
                    $query .= ("DEFAULT " . \Database::escape($fieldData->default));

                if ($fieldData->containsKey("autoIncrement") && $fieldData->autoIncrement == true)
                    $query .= ("AUTO_INCREMENT ");

                if ($afterField != "" && $fields->containsKey($afterField))
                    $query .= ("AFTER `" . $afterField . "` ");

                if (($fieldData->containsKey(isPrimary) && $fieldData->isPrimary == true) || ($fieldData->containsKey(autoIncrement) && $fieldData->autoIncrement == true))
                {
                    foreach ($fields as $dbField)
                    {
                        if (($dbField->isPrimary == true || $dbField->autoIncrement == true) && $dbField->field != $fieldData->field)
                        {
                            $dbField->isPrimary = false;
                            $dbField->autoIncrement = false;
                            self::addOrUpdate($table, $dbField, null, true);
                        }
                    }

                    $query .= (", ADD PRIMARY KEY (`" . stringEx($fieldData->field)->remove("`") . "`)");
                }

                \Database::query($query);
                $fields = self::getAllByTable($table);
                return $fields->containsKey($fieldData->field);
            }
        }
    }
}