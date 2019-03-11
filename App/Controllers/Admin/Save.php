<?php

namespace App\Controllers\Admin;


use App\Exceptions\NotFoundException;
use App\Models\Article as ArticleModel;

class Save extends Controller
{
    protected function handle()
    {
        if (isset($_POST['id'])) {
            $article = ArticleModel::findById($_POST['id']);

            if (empty($article)) {
                throw new NotFoundException('Не удалось найти запись с id ' . $_POST['id']);
            }

        } else {
            $article = new ArticleModel;
        }

        $article->title = $_POST['title'];
        $article->body = $_POST['body'];
        $article->save();

        header('Location: /Admin/Index/action');
        die();
    }
}