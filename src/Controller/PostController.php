<?php

namespace App\Controller;

use App\Model\PostManager;

class PostController extends AbstractController
{
    public function show(int $id): string
    {
        $postManager = new PostManager();
        $post = $postManager->showPost($id);
        return $this->twig->render('Post/show.html.twig', ['post' => $post]);
    }

    public function showAll()
    {
        $postManager = new PostManager();
        $PostsList = $postManager->showAllPosts();
        return $this->twig->render('Home/index.html.twig', ['PostsList' => $PostsList]);
    }
}