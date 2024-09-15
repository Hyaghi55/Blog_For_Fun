<?php

namespace Models;

use PDO;


class Post
{

    protected $id;
    protected $title;
    protected $description;
    protected $created_at;
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function set_created_at(): void
    {
        $this->created_at = date('Y-m-d H:i:s');
    }

    public static function findById($db, $id)
    {
        $query = "SELECT * FROM posts WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchObject('Post');
    }

    public function save(): bool
    {
        $query = "INSERT INTO posts (title, description, created_at) VALUES (:title, :description, :created_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':created_at', $this->created_at);
        return $stmt->execute();
    }

    public function update($id): bool
    {
        $query = "UPDATE posts SET title = :title, description = :description, created_at = :created_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function all($db): array
    {
        $query = "SELECT * FROM posts";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Post');
    }
}
