<?php

namespace Models;

use PDO;

class User
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;
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

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setCreatedAt(): void
    {
        $this->created_at = date('Y-m-d H:i:s');
    }

    public static function findById($db, $id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchObject('User');
    }

    public function save()
    {
        $query = "INSERT INTO users (name, email, password,created_at) VALUES (:name2,:email,:password2,:created_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name2', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password2', $this->password);
        $stmt->bindParam(':created_at', $this->created_at);
        return $stmt->execute();
    }

    public function update($id)
    {
        $query = "UPDATE users SET name = :name2, email = :email, password = :password2 , created_at = :created_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name2', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password2', $this->password);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function findByEmail($db, $email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
