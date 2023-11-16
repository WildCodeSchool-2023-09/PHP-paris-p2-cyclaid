<?php

namespace App\Model;

use PDO;

class PieceManager extends AbstractManager
{
    public const TABLE = 'post';

    public function selectPicturesByPostId(int $postId): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare('SELECT * FROM ' . static::TABLE .
         ' JOIN post ON brand.id = brand.post_id WHERE post.id=:id');
        $statement->bindValue('id', $postId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}