<?php

namespace Services;

use Models\Post;
use Helpers\Redirect;
use Services\ImageUploadService;

class PostService
{

    protected $db;
    protected $validation;

    protected $imageUploadService;

    public function __construct($db, Validation $validation)
    {
        $this->db = $db;
        $this->validation = $validation;
        $this->imageUploadService = new ImageUploadService();
    }

    public function createPost(string $title, string $content, $image): bool
    {
        // Validate post input
        if (!$this->validation->validateNewPost($title, $content) || !$this->validation->validateImage($image)) {
            Redirect::withErrors($this->validation->getErrors())->back('create_post.php');
            return false;
        }

        $this->imageUploadService->store($image);

        // Create a new Post model and save the post to the database
        $post = new Post($this->db);
        $post->setTitle($title);
        $post->setDescription($content);
        $post->set_created_at();


        return $post->save();
    }

    public function updatePost(int $id, string $title, string $content, string $image): bool
    {
        // Validate post input
        if (!$this->validation->validateNewPost($title, $content, $image)) {
            Redirect::withErrors($this->validation->getErrors())->back('edit_post.php?id=' . $id);
            return false;
        }

        // Find the post by ID
        $post = Post::findByID($this->db, $id);
        if (!$post) {
            Redirect::withErrors(['post' => 'Post not found'])->back('edit_post.php?id=' . $id);
            return false;
        }

        // Update the post
        $post->setTitle($title);
        $post->setContent($content);
        $post->setImage($image);

        return $post->save();
    }

    public function deletePost(int $id): bool
    {
        // Find the post by ID
        $post = Post::findByID($this->db, $id);
        if (!$post) {
            Redirect::withErrors(['post' => 'Post not found'])->back('index.php');
            return false;
        }

        return $post->delete();
    }
}
