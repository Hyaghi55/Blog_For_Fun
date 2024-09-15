<?php

namespace Controllers;

use Helpers\Redirect;
use Helpers\View;
use Services\Database;
use Services\ENV;
use Services\PostService;

class PostController
{

    private $env;
    private $baseUrl;
    private $postService;
    private $db;


    public function __construct(ENV $env, Database $db, PostService $postService)
    {
        $this->env = $env;
        $this->baseUrl = $this->env->getbaseurl();
        $this->db = $db->get_connection();
        $this->postService = $postService;
    }
    public function index(): void
    {
        $view = new View();
        return $view->render('index');
    }

    public function show(): void
    {
        $view = new View();
        return $view->render('show');
    }

    public function create(): void
    {
        $view = new View();
        return $view->render('create_post');
    }

    public function store(): void
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image'];

        $postCreated = $this->postService->createPost($title, $content, $image);

        if ($postCreated) {
            header('Location: ' . $this->baseUrl . '/posts');
        } else {
            Redirect::withErrors(['post' => 'Unable to create post'])->back('create_post.php');
        }
    }

    public function edit(): void
    {
        $view = new View();
        return $view->render('edit');
    }

    public function update()
    {
        $id = $_GET['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image'];

        $postUpdated = $this->postService->updatePost($id, $title, $content, $image);

        if ($postUpdated) {
            header('Location: ' . $this->baseUrl . '/posts');
        } else {
            Redirect::withErrors(['post' => 'Unable to update post'])->back('edit_post.php?id=' . $id);
        }
    }
}
