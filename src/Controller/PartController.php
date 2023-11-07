<?php

namespace App\Controller;

use App\Model\PartManager;

class PartController extends AbstractController
{
    public const EXTENSIONS = ['jpg','png', 'jpeg', 'webp'];
    public const MAX_SIZE = 10000000;
    public const MAX_LENGTH_DESCRIPTION = 2000;
    public const MAX_LENGTH_TITLE = 250;
    public const MAX_LENGTH_REFERENCE = 100;

    public function add()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . uniqid() . basename($_FILES['file']['name']);
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            $data = array_map('trim', $_POST);
            $data = array_map('htmlentities', $data);
            // foreach($data as $field) {
            //     if(empty($field)) {
            //         $errors[] = 'The field' . $field . 'must be fill !';
            //     }
            // }
            if (empty($data['title'])) {
                $errors['title'] = "A title is required";
            }
            if (strlen($data['title']) > self::MAX_LENGTH_TITLE) {
                $errors['title'] = "The title is too long. Max 250 characters";
            }
            if (empty($data['reference'])) {
                $errors['reference'] = "A reference is required";
            }
            if (strlen($data['reference']) > self::MAX_LENGTH_REFERENCE) {
                $errors['reference'] = "The reference is too long. Max 100 characters";
            }
            if (!in_array($data['category'], PartManager::CATEGORY)) {
                $errors['catagory'] = "A category is required";
            }
            if (!in_array($data['wear'], PartManager::WEAR)) {
                $errors['wear'] = "A wear state is required";
            }
            if (!in_array($data['brand'], PartManager::BRAND)) {
                $errors['brand'] = "A brand is required";
            }
            if (!in_array($data['location'], PartManager::LOCATION)) {
                $errors['location'] = "A location is required";
            }
            if (empty($data['description'])) {
                $errors['description'] = "A description is required";
            }
            if (strlen($data['description']) > self::MAX_LENGTH_DESCRIPTION) {
                $errors['description'] = "The description is too long. Max 2000 characters";
            }
            if ((!in_array($extension, self::EXTENSIONS))) {
                $errors['file'] = 'Please select a type image Jpg, Png, jpeg or webp !';
            }
            if (file_exists($_FILES['file']['tmp_name']) && filesize($_FILES['file']['tmp_name']) > self::MAX_SIZE) {
                $errors['file'] = "Your file size has to be less than 10 mega !";
            }
            if (empty($errors)) {
                move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
                $partManager = new PartManager();
                $part = $partManager->insert($data);
                if ($part) {
                    header('Location:/Home/index.html.twig');
                }
            }
        }
        echo $this->twig->render('Part\_form.html.twig', ['errors' => $errors]);
    }
}
