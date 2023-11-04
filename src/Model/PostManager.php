<?php

namespace App\Model;

use PDO;

class PostManager extends AbstractManager
{
    public const TABLE = 'post';

    public function showPost(int $id)
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $post = $statement->fetch(PDO::FETCH_ASSOC);
        return $post;
    }

    public function showAllPosts(): array
    {
        $query = 'SELECT * FROM ' . self::TABLE;
        $statement = $this->pdo->query($query);
        $PostsList = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $PostsList;
    }
}
