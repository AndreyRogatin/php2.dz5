<?php

namespace App\Models;


class User extends Model
{
    protected static $table = 'users';

    public $login;
    public $password;
    public $email;

    /**
     * Функция производит валидацию данных
     *
     * @param $key
     * @param $value
     */
    protected function validate($key, $value)
    {
        switch ($key) {
            case 'login':
                foreach (static::findAll() as $user) {
                    if ($value === $user->login) {
                        $this->errors->add(new \Exception('Пользователь с таким логином уже существует'));
                    }
                }
                break;
            case 'password':
                if (strlen($value) < 6) {
                    $this->errors->add(new \Exception('Слишком короткий пароль'));
                }
                if (strlen($value) > 12) {
                    $this->errors->add(new \Exception('Слишком длинный пароль'));
                }
                break;
            case 'email':
                if (strpos($value, '@') === false) {
                    $this->errors->add(new \Exception('Неправильный адрес электронной почты'));
                }
                break;
        }
    }
}