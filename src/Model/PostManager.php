<?php

namespace App\Model;

use App\Model\AbstractManager;
use App\Model\PostPictureManager;
use PDO;

class PostManager extends AbstractManager
{
    public const TABLE = 'post';
    public const WEAR_NEW = 'new';
    public const WEAR_GOOD = 'good';
    public const WEAR_USED = 'used';
    public const WEAR_TO_FIX = 'to-fix';

    public const CATEGORY = ['Accessories', 'Brakes', 'Cables and sheaths', 'Frames', 'Saddles',
                             'Tools', 'Forks and steering', 'Wheels and tires', 'Transmission',];

    public const WEAR = [
        self::WEAR_NEW    => 'New',
        self::WEAR_GOOD   => 'Good',
        self::WEAR_USED   => 'Used',
        self::WEAR_TO_FIX => 'To fix',
    ];

    public const BRAND = ['Shimano', 'Hutchinson', 'Brooks', 'Continental', 'Schwalbe', 'Magura', 'Brompton', 'Other',];
    public const LOCATION = ['Auvergne', 'Rhône-Alpes', 'Bourgogne', 'Franche-Comté',
                             'Bretagne', 'Centre', 'Val de Loire', 'Corse', 'Grand Est',
                             'Hauts de France', 'Ile de France', 'Normandie', 'Nouvelle Acquitaine',
                             'Occitanie', 'Pays de la Loire', 'Provence', 'Alpes', 'Côte d\'Azur', 'Undefined',];
    private PostPictureManager $postPictureManager;

    public function __construct()
    {
        $this->postPictureManager = new PostPictureManager();
        parent::__construct();
    }

    public function insert(array $data, array $pictures): int|false
    {
        $query = "INSERT INTO " . self::TABLE . " (title, reference, creation_date, description, ";
        $query .= "wear_status, user_id, brand_id, category_id) ";
        $query .= " VALUES (:title, :reference, NOW(), :description, :wear, 1, :category_id, :brand_id);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $data['title']);
        $statement->bindValue(':reference', $data['reference']);
        $statement->bindValue(':description', $data['description']);
        $statement->bindValue(':wear', $data['wear']);
        $statement->bindValue(':brand_id', $data['brand']);
        $statement->bindValue(':category_id', $data['category']);
        $statement->execute();

        $postId = (int)$this->pdo->lastinsertid();

        if ($postId) {
            foreach ($pictures as $picture) {
                $this->postPictureManager->insert($picture, $postId);
            }
            return $postId;
        } else {
            return false;
        }
    }

    public function selectOnePostById(int $id): array|false
    {
        $query = "SELECT p.id, p.title, p.reference, p.creation_date, p.description, p.wear_status, p.user_id, ";
        $query .= "b.label AS brand, c.label AS category FROM " . self::TABLE . " AS p ";
        $query .= "INNER JOIN brand AS b ON b.id=p.brand_id ";
        $query .= "INNER JOIN category AS c ON c.id=p.category_id WHERE p.id=:id;";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
