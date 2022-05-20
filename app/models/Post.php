<?php

class Post extends Controller {

    public function __construct() {

        $this->db = new Database();
    }

    //Get all posts
    public function getPosts(){
        $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreatedAt,
                        users.created_at as userCreatedAt
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC
                        ');

        $results = $this->db->resultSet();
        return $results;
//         print_r($results);
    }

    //add posts
    public function addPosts($data) {
        $this->db->query("INSERT INTO posts (user_id, title,body) VALUES(:user_id, :title, :body)");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        return $this->db->execute() ? true : false;

    }
    //find post by ID
    public function findPostById($id) {
        $this->db->query("SELECT * FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updatePost($data) {
        $this->db->query("UPDATE posts SET title = :title, body = :body WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);

        return $this->db->execute() ? true : false;
    }

    public function deletePost($id) {
        $this->db->query("DELETE FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute() ? true : false;
    }
}