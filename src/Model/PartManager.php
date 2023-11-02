<?php

namespace App\Model;

use App\Model\AbstractManager;

class PartManager extends AbstractManager
{
    public const TABLE = 'post';

    public function insert(array $data)
    {
        $query = "INSERT INTO post (title, reference, category, wear, brand, location, description, file)";
        $query .= " VALUES (:title, :reference, :category, :wear, :brand, :location, :description, :file);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $data['title']);
        $statement->bindValue(':reference', $data['reference']);
        $statement->bindValue(':category', $data['category']);
        $statement->bindValue(':wear', $data['wear']);
        $statement->bindValue(':brand', $data['brand']);
        $statement->bindValue(':location', $data['location']);
        $statement->bindValue(':description', $data['description']);
        $statement->bindValue(':file', $data['file']);
        $statement->execute();
        return(int)$this->pdo->lastinsertid();
    }
}
