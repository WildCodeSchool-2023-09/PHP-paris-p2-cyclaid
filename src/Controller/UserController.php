<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\PostManager;
use App\Model\PostPictureManager;

class UserController extends AbstractController
{
    public const MAX_FILE_SIZE = 2000000;
    public const MAX_LENGTH_FIRSTNAME = 100;
    public const MAX_LENGTH_LASTNAME = 100;
    public const MAX_LENGTH_CITY = 150;
    public const MAX_LENGTH_EMAIL = 255;
    public const MAX_LENGTH_PASSWORD = 255;
    public const PATH_TO_PICTURES = '/uploads/';
    public array $errors = [];
    private PostManager $postManager;
    private PostPictureManager $postPictureManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->postPictureManager = new PostPictureManager();
        parent::__construct();
    }

    public function logout()
    {
        session_unset();
        header('Location: /');
    }

    public function profile(): string
    {
        $postsUser = $this->postManager->selectAllByUserId($_SESSION['user_id']);

        foreach ($postsUser as $key => $post) {
            $postsUser[$key]['picture'] = $this->postPictureManager->selectOnePictureByPostId($post['id']);
        }
        return $this->twig->render('User/profile.html.twig', [
            'postsList' => $postsUser
        ]);
    }

    public function login(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);

            $this->checkLoginErrors($data);

            if (empty($this->errors)) {
                $user = $this->userManager->selectOneByEmail($data['email']);
                if ($user && password_verify($data['password'], $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: /user/profile');
                    exit();
                } else {
                    $this->errors['password_login'] = 'Email and/or password incorrect !';
                }
            }
        }

        return $this->twig->render('User/login.html.twig', [
            'errors' => $this->errors,
        ]);
    }

    public function checkLoginErrors(array $data)
    {
        if (!isset($data['email']) || empty($data['email'])) {
            $this->errors['email'] = 'Email is mandatory !';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid !";
        }

        if (!isset($data['password']) || empty($data['password'])) {
            $this->errors['password'] = 'Password is mandatory !';
        }
    }

    public function signIn(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);

            if ($this->checkIsEmpty($data)) {
                $this->checkSignInErrors($data);
                $this->checkUploadErrors($_FILES['file']['name'], $_FILES['file']['tmp_name']);
            }

            if (empty($this->errors)) {
                if (file_exists($_FILES['file']['tmp_name'])) {
                    $profilePicture = uniqid() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $uploadFile = UPLOAD_DIR . $profilePicture;
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
                } else {
                    $profilePicture = '';
                }

                if ($this->userManager->insert($data, $profilePicture)) {
                    return $this->login();
                }
            }
        }
        return $this->twig->render('User/signin.html.twig', [
            'errors' => $this->errors,
        ]);
    }

    public function checkUploadErrors(string $file, string $tmpFile): void
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if (file_exists($tmpFile) && !in_array($extension, PostController::EXTENSIONS)) {
            $this->errors['file'] = 'Please select a type of image jpg, png, jpeg or webp !';
        }

        if (file_exists($tmpFile) && filesize($tmpFile) > self::MAX_FILE_SIZE) {
            $this->errors['file'] = 'Your files size has to be less than 2 MO !';
        }
    }

    private function checkSignInErrors(array $data): void
    {
        if (strlen($data['firstname']) > self::MAX_LENGTH_FIRSTNAME) {
            $this->errors['firstname'] = 'The firstname cannot exceed 100 characters.';
        }

        if (strlen($data['lastname']) > self::MAX_LENGTH_LASTNAME) {
            $this->errors['firstname'] = 'The lastname cannot exceed 100 characters.';
        }

        if (strlen($data['city']) > self::MAX_LENGTH_CITY) {
            $this->errors['city'] = 'The city\'s name cannot exceed 100 characters.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email is not valid !';
        } elseif (strlen($data['email']) > self::MAX_LENGTH_EMAIL) {
            $this->errors['email'] = 'Email cannot exceed 255 characters.';
        }

        if (strlen($data['password']) > self::MAX_LENGTH_PASSWORD) {
            $this->errors['password'] = 'Password cannot exceed 255 characters.';
        }

        if (strlen($data['postal_code']) !== 5) {
            $this->errors['postal_code'] = 'The postal code must be in good format (5 digits).';
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

    public function getPart(int $postId, int $userId)
    {
        $this->postManager->delete($postId);

        $pictureFiles = $this->postPictureManager->selectByPostId($postId);
        foreach ($pictureFiles as $file) {
            unlink(self::PATH_TO_PICTURES . $file['picture']);
        }

        $this->postPictureManager->deleteByPostId($postId);
        $this->userManager->modifyCoin($_SESSION['user_id'], '-');
        $this->userManager->modifyCoin($userId, '+');
        header('Location: /user/profile');
    }
}
