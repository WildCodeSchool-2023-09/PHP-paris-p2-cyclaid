<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByEmail(string $email): array|false
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email_address=:email;";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(":email", $email);

        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert(array $data, string $profilePicture): int|false
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (firstname, lastname, city, postal_code, email_address, ';
        $query .= 'password, profile_picture) ';
        $query .= 'VALUES (:firstname, :lastname, :city, :postal_code, :email_address, :password, :profile_picture);';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':firstname', $data['firstname']);
        $statement->bindValue(':lastname', $data['lastname']);
        $statement->bindValue(':city', $data['city']);
        $statement->bindValue(':postal_code', $data['postal_code']);
        $statement->bindValue(':email_address', $data['email']);
        $statement->bindValue(':password', password_hash($data["password"], PASSWORD_DEFAULT));
        $statement->bindValue(':profile_picture', $profilePicture);

        $statement->execute();

        return (int)$this->pdo->lastinsertid();
    }

    public function modifyCoin(int $id, string $operator): void
    {
        $query = "UPDATE " . self::TABLE . " SET coin = coin " . $operator . " 1 WHERE id=:id";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }
}
