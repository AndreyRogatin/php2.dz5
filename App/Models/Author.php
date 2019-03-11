<?php

namespace App\Models;


class Author extends Model
{
    protected static $table = 'authors';

    public $name;

    /**
     * Функция производит валидацию данных
     *
     * @param $key
     * @param $value
     */
    protected function validate($key, $value)
    {
        switch ($key) {
            case 'name':
                if (strlen(trim($value)) === 0) {
                    $this->errors->add(new \Exception('Имя автора не указано'));
                }
                break;
        }
    }
}