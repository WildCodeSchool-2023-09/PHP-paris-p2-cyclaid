<?php

namespace App\Controller;

use App\Model\PartManager;

class PartController extends AbstractController
{
    public const EXTENSIONS = ['jpg','png', 'jpeg', 'webp'];
    public const MAX_FILE_SIZE = 10000000;
    public const MAX_LENGTH_DESCRIPTION = 2000;
    public const MAX_LENGTH_TITLE = 150;
    public const MAX_LENGTH_REFERENCE = 255;
    public const CATEGORY_MIN = 1;
    public const CATEGORY_MAX = 9;
    public const BRAND_MIN = 1;
    public const BRAND_MAX = 8;
    public array $errors = [];
    private PartManager $partManager;

    public function __construct()
    {
        $this->partManager = new PartManager();
        parent::__construct();
    }

    public function add(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = array_map('trim', array_map('htmlentities', $_POST));

            if ($this->checkIsEmpty($data)) {
                $this->checkUploadErrors($_FILES['file']['name'], $_FILES['file']['tmp_name']);
                $this->checkErrors($data);
            }

            if (empty($this->errors)) {
                $filesCount = count($_FILES['file']['name']);
                $pictures = [];
                for ($i = 0; $i < $filesCount; $i++) {
                    $pictures[$i] = uniqid() . '.' . pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                    $uploadFile = UPLOAD_DIR . $pictures[$i];
                    move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadFile);
                }
                if ($this->partManager->insert($data, $pictures)) {
                    header('Location: /Home/index.html.twig');
                }
            }
        }
        return $this->twig->render('Part\_form.html.twig', [
            'errors' => $this->errors
        ]);
    }

    private function checkUploadErrors(array $files, array $tmpFiles): void
    {
        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            if (!in_array($extension, self::EXTENSIONS)) {
                $this->errors['file'] = 'Please select a type of image jpg, png, jpeg or webp !';
            }
        }

        $fileSize = 0;

        foreach ($tmpFiles as $tmpFile) {
            if (!file_exists($tmpFile)) {
                $this->errors['file'] = "Errors: don\'t find file !";
            } else {
                $fileSize += filesize($tmpFile);
            }
        }

        if ($fileSize > self::MAX_FILE_SIZE) {
            $this->errors['file'] = 'Your files size has to be less than 10 mega !';
        }
    }

    private function checkErrors(array $data): void
    {
        if (strlen($data['title']) > self::MAX_LENGTH_TITLE) {
            $this->errors['title'] = 'The title is too long. Max 150 characters.';
        }

        if (strlen($data['reference']) > self::MAX_LENGTH_REFERENCE) {
            $this->errors['reference'] = 'The reference is too long. Max 255 characters.';
        }

        if (strlen($data['description']) > self::MAX_LENGTH_DESCRIPTION) {
            $this->errors['description'] = 'The description is too long. Max 2000 characters.';
        }

        if (!in_array($data['category'], range(self::CATEGORY_MIN, self::CATEGORY_MAX))) {
            $this->errors['category'] = 'Invalid category !';
        }

        if (!in_array($data['wear'], PartManager::WEAR)) {
            $this->errors['wear'] = 'Invalid wear !';
        }

        if (!in_array($data['brand'], range(self::BRAND_MIN, self::BRAND_MAX))) {
            $this->errors['brand'] = 'Invalid brand !';
        }

        if (!in_array($data['location'], PartManager::LOCATION)) {
            $this->errors['location'] = 'Invalid location !';
        }
    }

    private function checkIsEmpty(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->errors[$key] = 'A ' . $key . ' is required !';
            }
        }
        return empty($this->errors);
    }
}
