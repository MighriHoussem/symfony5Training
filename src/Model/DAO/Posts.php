<?php

namespace App\Model\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Monolog\Logger;

class Posts {
    private $connection = null;
    private $tableName = null;
    public function __construct(Connection $connection){
      $this->tableName = "post";
      $this->connection = $connection;
    }
    public function getPosts(){
        try{
            $posts = [];
            $query = "SELECT * FROM ". $this->tableName;
            $posts = $this->connection->fetchAllAssociative($query);
            return $posts;
        } catch (Exception $e) {
            return [];
        }
    }

    public function addPost(string $title){
        try{
            $id = 20;
            $query = "INSERT INTO ".$this->tableName." (title) VALUES(:title)";
            $params = [
                'title' => $title
            ];
            $this->connection->executeQuery($query, $params);
            return true;
        }catch(\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function deletePost(string $idPost){
        try{
            $query = "DELETE FROM ".$this->tableName." WHERE id = :idPost;";
            $this->connection->executeQuery($query,[
                'idPost' => $idPost
            ]);
            return true;

        }catch(Exception $exception){
            return $exception;
        }
    }
    public function getPostById(string $id){
        try{
            $query = "SELECT * FROM ".$this->tableName." WHERE id = :id;";
            $result = $this->connection->fetchAllAssociative($query,[
                'id'=> $id
            ]);
            return $result;
        }catch(Exception $exception){
            return $exception;
        }
    }

}