<?php

namespace models;

use Aura\Sql\ExtendedPdo;

abstract class Model
{
    abstract static public function tableName();

    public function load(array $data)
    {
        foreach (array_intersect_key($data, get_object_vars($this)) as $field => $value) {
            $this->$field = $value;
        }
    }

    public static function getPdo(): ExtendedPdo
    {
        return \Application::getInstance()->getPdo();
    }

    public static function getTotalCount(): int
    {
        $table = static::tableName();
        return self::getPdo()->perform("SELECT COUNT(*) FROM $table")->fetchColumn()[0];
    }
}