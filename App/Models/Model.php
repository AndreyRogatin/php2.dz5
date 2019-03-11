<?php

namespace App\Models;


use App\Db;
use App\Exceptions\MultiException;
use App\Exceptions\NotFoundException;

abstract class Model
{
    protected static $table = '';
    protected $errors;

    public $id;

    public function __construct()
    {
        $this->errors = new MultiException;
    }

    /**
     * Функция заполняет поля объекта данными из массива
     *
     * @param array $data
     * @throws MultiException
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {

            $cnt = count($this->errors->all());
            $this->validate($key, $value);

            if (count($this->errors->all()) === $cnt) {
                $this->$key = $value;
            }
        }

        if (!$this->errors->empty()) {
            throw $this->errors;
        }
    }

    /**
     * Функция производит валидацию данных
     *
     * @param $key
     * @param $value
     */
    protected function validate($key, $value)
    {
    }

    /**
     * Функция возвращает все записи из таблицы
     *
     * @return array
     */
    public static function findAll()
    {
        $db = new Db;
        $sql = 'SELECT * FROM ' . static::$table;
        return $db->query($sql, [], static::class);
    }

    /**
     * Функция возвращает одну запись из таблицы с заданным id
     *
     * @param $id integer
     * @return bool|object
     * @throws NotFoundException
     */
    public static function findById(int $id)
    {
        $db = new Db;
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
        $params = [':id' => $id];
        $res = $db->query($sql, $params, static::class);
        return $res[0] ?? false;
    }

    /**
     * Функция вставляет новую запись в таблицу
     */
    public function insert()
    {
        $fields = get_object_vars($this);
        $sets = [];
        $values = [];
        $params = [];

        foreach ($fields as $key => $value) {
            if ('id' === $key || 'errors' === $key) {
                continue;
            }
            $sets[] = $key;
            $values[] = ':' . $key;
            $params[':' . $key] = $value;
        }

        $sql = 'INSERT INTO ' . static::$table . ' (' . implode(', ', $sets) . ') 
                VALUES (' . implode(', ', $values) . ')';

        $db = new Db;
        $db->execute($sql, $params);
        $this->id = $db->getLastId();
    }

    /**
     * Функция обновляет существующую запись в таблице
     */
    public function update()
    {
        $fields = get_object_vars($this);
        $sets = [];
        $params = [];

        foreach ($fields as $key => $value) {
            if ('errors' === $key) {
                continue;
            }
            $params[':' . $key] = $value;
            if ('id' === $key) {
                continue;
            }
            $sets[] = $key . '=:' . $key;
        }

        $sql = 'UPDATE ' . static::$table . ' 
                SET ' . implode(', ', $sets) . ' 
                WHERE id=:id';

        $db = new Db;
        $db->execute($sql, $params);
    }

    /**
     * Фукция сохранят запись в таблицу
     */
    public function save()
    {
        if (isset($this->id)) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    /**
     * Фукция удаляет запись из таблицы
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . static::$table . ' WHERE id=:id';
        $params = [':id' => $this->id];
        $db = new Db;
        $db->execute($sql, $params);
    }
}