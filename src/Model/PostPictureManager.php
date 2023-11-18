<?php

namespace App\Model;

use App\Model\AbstractManager;

class PostPictureManager extends AbstractManager
{
    public const TABLE = 'post_picture';

    public function insert(string $picture, int $id)
    {
        $query = "INSERT INTO " . self::TABLE . " (post_id, picture)";
        $query .= " VALUE (:post_id, :picture);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':post_id', $id, \PDO::PARAM_INT);
        $statement->bindvalue(':picture', $picture);
        $statement->execute();

        return(int)$this->pdo->lastinsertid();
    }

    public function selectByPostId(int $id): array
    {
        $query = 'SELECT pp.id, pp.picture, pp.post_id FROM ' . self::TABLE . ' AS pp ';
        $query .= 'INNER JOIN post AS p ON p.id=pp.post_id WHERE pp.post_id=:id;';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectOnePictureByPostId(int $id)
    {
        $query = 'SELECT pp.picture FROM ' . self::TABLE . ' AS pp ';
        $query .= 'INNER JOIN post AS p ON p.id=pp.post_id WHERE pp.post_id=:id;';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $statement->fetch(\PDO::FETCH_ASSOC);

        // return $result['picture'];
    }
}
