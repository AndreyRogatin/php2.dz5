<?php

namespace App\Models;


class Person extends Model
{
    protected static $table = 'persons';

    public $firstName;
    public $lastName;
    public $age;

    /**
     * Функция производит валидацию данных
     *
     * @param $key
     * @param $value
     */
    protected function validate($key, $value)
    {
        switch ($key) {
            case 'firstName':
                if (strlen(trim($value)) === 0) {
                    $this->errors->add(new \Exception('Имя не указано'));
                }
                break;
            case 'lastName':
                if (strlen(trim($value)) === 0) {
                    $this->errors->add(new \Exception('Фамилия не указана'));
                }
                break;
            case 'age':
                if ($value <= 0 || $value > 200) {
                    $this->errors->add(new \Exception('Неправильно указан возраст'));
                }
                break;
        }
    }
}