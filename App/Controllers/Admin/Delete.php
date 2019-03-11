<?php

namespace App\Controllers\Admin;


use App\Exceptions\NotFoundException;
use App\Models\Article as ArticleModel;

class Delete extends Controller
{

    protected function handle()
    {
        $article = ArticleModel::findById($_GET['id']);

        if (empty($article)) {
            throw new NotFoundException('Не удалось найти запись с id ' . $_GET['id']);
        }

        $article->delete();

        header('Location: /Admin/Index/action');
        die();
    }
}