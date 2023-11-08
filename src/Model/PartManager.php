<?php

namespace App\Model;

use App\Model\AbstractManager;
use App\Model\PartPictureManager;

class PartManager extends AbstractManager
{
    public const TABLE = 'post';
    public const CATEGORY = ['Accessories', 'Brakes', 'Cables and sheaths', 'Frames', 'Saddles',
                             'Tools', 'Forks and steering', 'Wheels and tires', 'Transmission',];
    public const WEAR = ['New', 'Good', 'Used', 'To fix',];
    public const BRAND = ['Shimano', 'Hutchinson', 'Brooks', 'Continental', 'Schwalbe', 'Magura', 'Brompton', 'Other',];
    public const LOCATION = ['Auverge', 'Rhône-Alpes', 'Bourgogne', 'Franche-Comté',
                             'Bretagne', 'Centre', 'Val de Loire', 'Corse', 'Grand Est',
                             'Hauts de France', 'Ile de France', 'Normandie', 'Nouvelle Acquitaine',
                             'Occitanie', 'Pays de la Loire', 'Provnce', 'Alpes', 'Côte d\'Azur', 'Undefined',];
    private PicturePartManager $picturePartManager;

    public function __construct()
    {
        $this->picturePartManager = new PicturePartManager();
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
                $this->picturePartManager->insertPicture($picture, $postId);
            }
            return $postId;
        } else {
            return false;
        }
    }
}
