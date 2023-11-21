<?php

namespace App\Controller;

use App\Model\PieceManager;
use App\Model\PiecePictureManager;
use PDO;

class PieceController extends AbstractController 
{
 public function show(int $id): string
    {
        $pieceManager = new PieceManager();
        $piecePictureManager = new PiecePictureManager();
        $post = $pieceManager->selectOneById($id);
        $postPicture = $piecePictureManager->selectPicturesByPostId($id);
        return $this->twig->render('Piece/piece.html.twig', ['post' => $post, 'images' => $postPicture]);
    }
}
