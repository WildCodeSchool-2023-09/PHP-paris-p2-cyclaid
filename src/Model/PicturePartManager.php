<?php

namespace App\Model;

use App\Model\AbstractManager;

class PicturePartManager extends AbstractManager
{
    public const TABLE = 'post_picture';

    public function insert(string $picture, int $id)
    {
        $query = "INSERT INTO" . self::TABLE . "(post_id, picture) ";
        $query .= " VALUE (:post_id, :picture);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':post_id', $id, \PDO::PARAM_INT);
        $statement->bindvalue(':picture', $picture);
        $statement->execute();

        return(int)$this->pdo->lastinsertid();
    }
}
