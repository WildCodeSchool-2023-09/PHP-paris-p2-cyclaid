<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\AbstractManager;

class PostController extends AbstractController
{
    protected PostManager $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostManager();
    }

    public function show(int $id): string
    {
        $post = $this->postManager->selectOneById($id);
        return $this->twig->render('Post/show.html.twig', ['post' => $post]);
    }

    public function showAll()
    {
        $postsList = $this->postManager->selectAll();
        return $this->twig->render('Home/index.html.twig', ['postsList' => $postsList]);
    }
}
