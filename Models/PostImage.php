<?php

namespace Models;

use PDO;


class PostImage
{
    protected $id;
    protected $post_id;
    protected $url;

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

    public function setPostId($post_id): void
    {
        $this->post_id = $post_id;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function setCreatedAt(): void
    {
        $this->created_at = date('Y-m-d H:i:s');
    }

    public static function findByPostId($db, $post_id)
    {
        $query = "SELECT * FROM post_images WHERE post_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$post_id]);
        $PostImage = $stmt->fetch(PDO::FETCH_ASSOC);
        return $PostImage;
    }
}
