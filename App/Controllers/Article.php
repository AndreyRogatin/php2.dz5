<?php

namespace App\Controllers;


use App\Exceptions\NotFoundException;
use App\Models\Article as ArticleModel;

class Article extends Controller
{
    protected function handle()
    {

        $this->view->article = ArticleModel::findById($_GET['id']);

        if (empty($this->view->article)) {
            throw new NotFoundException('Не удалось найти запись с id ' . $_GET['id']);
        }

        $this->view->display(__DIR__ . '/../templates/article.php');
    }
}