<?php

namespace App\Model;

use App\Model\AbstractManager;

class PartManager extends AbstractManager
{
    public const TABLE = 'post';
    public const CATEGORY = ['Accesories', 'Brakes', 'Cables and sheaths', 'Frames', 'Saddles',
                             'Tools', 'Forks and steering', 'Wheels and tires', 'Transmission'];
    public const WEAR = ['New', 'Good', 'Used', 'To fix'];
    public const BRAND = ['Shimano', 'Hutchinson', 'Brooks', 'Continental', 'Schwalbe', 'Magura', 'Brompton', 'Other'];
    public const LOCATION = ['Auverge', 'Rhône-Alpes', 'Bourgogne', 'Frnche-Comté',
                             'Bretagne', 'Centre', 'Val de Loire', 'Corse', 'Grand Est',
                             'Hauts de France', 'Ile de France', 'Normandie', 'Nouvelle Acquitaine',
                             'Occitanie', 'Pays de la Loire', 'Provnce', 'Alpes', 'Côte d\'Azur', 'Undefined'];

    public function insert(array $data)
    {
        $query = "INSERT INTO post (title, reference, category, wear, brand, location, description, file) ";
        $query .= " VALUES (:title, :reference, :category, :wear, :brand, :location, :description, :file);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $data['title']);
        $statement->bindValue(':reference', $data['reference']);
        $statement->bindValue(':category', $data['category']);
        $statement->bindValue(':wear', $data['wear']);
        $statement->bindValue(':brand', $data['brand']);
        $statement->bindValue(':location', $data['location']);
        $statement->bindValue(':description', $data['description']);
        $statement->bindValue(':file', $data['file']);
        $statement->execute();
        return(int)$this->pdo->lastinsertid();
    }
}
