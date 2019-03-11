<?php

namespace App\Models;


class Article extends Model
{
    protected static $table = 'news';

    public $title;
    public $body;
    public $author_id;

    /**
     * Функция возвращает автора статьи в виде объекта класса Author
     *
     * @param $key string
     * @return Author
     */
    public function __get(string $key)
    {
        if ('author' === $key) {
            if (!empty($this->author_id)) {
                return Author::findById($this->author_id);
            }
        }
    }

    /**
     * Функция проверяет существование поля author
     *
     * @param $key string
     * @return bool
     */
    public function __isset(string $key)
    {
        if ('author' === $key) {
            return isset($this->author_id);
        }
    }

    /**
     * Функция возвращает $num последних записей из таблицы
     *
     * @param $num integer
     * @return array
     */
    public static function findNLastArticles(int $num)
    {
        return array_reverse(array_slice(static::findAll(), -$num));
    }

    /**
     * Функция производит валидацию данных
     *
     * @param $key
     * @param $value
     */
    protected function validate($key, $value)
    {
        switch ($key) {
            case 'title':
                if (strlen(trim($value)) === 0) {
                    $this->errors->add(new \Exception('Заголовок не указан'));
                }
                if (strlen(trim($value)) > 255) {
                    $this->errors->add(new \Exception('Слишком длинный заголовок'));
                }
                break;
            case 'body':
                if (strlen(trim($value)) < 255) {
                    $this->errors->add(new \Exception('Мало текста в статье'));
                }
                break;
        }
    }
}