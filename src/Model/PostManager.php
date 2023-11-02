<?php

namespace App\Model;

use PDO;

class PostManager extends AbstractManager
{
    public const TABLE = 'post';

    public function showPost(int $id)
    {
        $query = 'SELECT * FROM' . self::TABLE . 'JOIN post_picture ON post_picture.picture.id WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $post = $statement->fetch(PDO::FETCH_ASSOC);
        return $post;
    }
}
