<?php

namespace App\Controllers\Admin;


use App\Exceptions\NotFoundException;
use App\Models\Article;

class Update extends Controller
{
    protected function handle()
    {
        $this->view->article = Article::findById($_GET['id']);

        if (empty($this->view->article)) {
            throw new NotFoundException('Не удалось найти запись с id ' . $_GET['id']);
        }

        $this->view->display(__DIR__ . '/../../templates/admin/update.php');
    }
}