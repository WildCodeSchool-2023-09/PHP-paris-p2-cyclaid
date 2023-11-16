<?php

namespace App\Model;

use PDO;

class PiecePictureManager extends AbstractManager
{
    public const TABLE = 'post_picture';

    public function selectPicturesByPostId(int $postId): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare('SELECT * FROM ' . static::TABLE . ' JOIN post ON post.id = post_picture.post_id WHERE post.id=:id');
        $statement->bindValue('id', $postId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}