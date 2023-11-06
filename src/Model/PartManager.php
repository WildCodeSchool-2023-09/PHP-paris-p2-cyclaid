<?php

namespace App\Model;

use App\Model\AbstractManager;

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

    public function insert(array $data)
    {
        $query = "SELECT id FROM category WHERE label LIKE :category;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':category', $data['category']);
        $statement->execute();
        $categoryId = $statement->fetch(\PDO::FETCH_ASSOC);

        $query = "SELECT id FROM brand WHERE label LIKE :brand;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':brand', $data['brand']);
        $statement->execute();
        $brandId = $statement->fetch(\PDO::FETCH_ASSOC);

        $query = "INSERT INTO post (title, reference, description, wear_status, brand_id, category_id) ";
        $query .= " VALUES (:title, :reference, :description, :wear, :category_id, :brand_id);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $data['title']);
        $statement->bindValue(':reference', $data['reference']);
        $statement->bindValue(':description', $data['description']);
        $statement->bindValue(':wear', $data['wear']);
        $statement->bindValue(':brand_id', $brandId);
        $statement->bindValue(':category_id', $categoryId);
        $statement->execute();

        return(int)$this->pdo->lastinsertid();
    }
}
