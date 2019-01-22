<?php

namespace models;

use Application;
use components\Paginator;

class Task extends Model
{
    public $id;
    public $title;
    public $author;
    public $email;
    public $text;
    public $status = 0;

    public static function tableName()
    {
        return 'tasks';
    }

    public static function getPage($pageNo = 1, $orderBy = '', $order = '')
    {
        $table = static::tableName();
        $limit = Paginator::PAGE_ITEMS;
        $offset = ($pageNo - 1) * $limit;

        $sql = "SELECT id, title, author, email, text, status FROM $table ";

        //echo '<pre>';
        //print_r(array_keys(get_class_vars(static::class)));
        //die($orderBy);

        //var_dump(in_array($orderBy, array_keys(get_class_vars(static::class), true)));

        if (in_array($orderBy, array_keys(get_class_vars(static::class)), true)) {
            $sql .= " ORDER BY $orderBy ";
            if (in_array(strtoupper($order), ['DESC', 'ASC'])) {
                $sql .= " $order ";
            } else {
                $sql .= " ASC ";
            }
        }
        //die($sql);


        $sql .= " LIMIT $limit OFFSET $offset ";

        return self::getPdo()->fetchObjects($sql, [], static::class);
    }

    public static function getOne($id)
    {
        $table = static::tableName();
        $sql = "SELECT id, title, author, email, text, status FROM $table WHERE id = :id";

        return self::getPdo()->fetchObject($sql, ['id' => $id], static::class);
    }

    public function insert()
    {
        $table = static::tableName();
        $sql = "INSERT INTO $table(title, author, email, text, status) VALUES (:title, :author, :email, :text, :status)";
        $data = (array) $this;
        unset($data['id']);

        return self::getPdo()->perform($sql, $data);
    }

    public function update()
    {
        $table = static::tableName();
        $sql = "UPDATE $table SET title = :title, author = :author, email = :email, text = :text, status = :status WHERE id = :id";
        $data = (array) $this;

        return self::getPdo()->perform($sql, $data);
    }

    public function getDeleteLink()
    {
        return Application::getInstance()->getRouter()->createUrl('task/delete', ['id' => $this->id]);
    }

    public function getUpdateLink()
    {
        return Application::getInstance()->getRouter()->createUrl('task/update', ['id' => $this->id]);
    }
}