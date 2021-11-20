<?php
namespace App\Service;

use App\Model\DAO\Posts;
use Doctrine\DBAL\Connection;


class PostServices {
    private $postDAO = null;
    public function __construct(Connection $connection)
    {
        $this->postDAO = new Posts($connection);
    }

    public function getPosts() {
        $posts = $this->postDAO->getPosts();
        return $posts;
    }

    public function addPost(string $title){
        $result = $this->postDAO->addPost($title);
        return $result;
    }
    public function deletePost(string $idPost){
        $result = $this->postDAO->deletePost($idPost);
        return $result;
    }
    public function getPost(string $idPost){
        $result = $this->postDAO->getPostById($idPost);
        return $result;
    }


}