<?php

namespace App\Controller;

use App\Model\PartManager;

class PartController extends AbstractController
{
    public function addPart()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . uniqid() . basename($_FILES['file']['name']);
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg','png', 'jpeg', 'webp'];
            $maxFileSize = 10000000;

            $data = array_map('trim', $_POST);
            $data = array_map('htmlentities', $data);
            if (empty($data['title'])) {
                $errors['title'] = "A title is required";
            }
            if (strlen($data['title']) > 250) {
                $errors['title'] = "The title is too long. Max 250 characters";
            }
            if (empty($data['reference'])) {
                $errors['reference'] = "A reference is required";
            }
            if (strlen($data['reference']) > 100) {
                $errors['reference'] = "The reference is too long. Max 100 characters";
            }
            if (empty($data['category'])) {
                $errors['catagory'] = "A category is required";
            }
            if (empty($data['wear'])) {
                $errors['category'] = "A wear state is required";
            }
            if (empty($data['brand'])) {
                $errors['brand'] = "A brand is required";
            }
            if (empty($data['location'])) {
                $errors['location'] = "A location is required";
            }
            if (empty($data['description'])) {
                $errors['description'] = "A description is required";
            }
            if (strlen($data['description']) > 2000) {
                $errors['description'] = "The description is too long. Max 2000 characters";
            }
            if (empty($data['file'])) {
                $errors['file'] = "A photo is required";
            }
            if ((!in_array($extension, $authorizedExtensions))) {
                $errors['file'] = 'Please select a type image Jpg, Png, jpeg or webp !';
            }
            if (file_exists($_FILES['file']['tmp_name']) && filesize($_FILES['file']['tmp_name']) > $maxFileSize) {
                $errors['file'] = "Your file size has to be less than 10 mega !";
            }
            if (empty($errors)) {
                move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
                $data = $_POST;
                $partsManager = new PartManager();
                if ($partsManager->insert($data)) {
                    return $this->addPart();
                }
            }
        }
        echo $this->twig->render('Part\_form.html.twig', ['errors' => $errors]);
    }
}
