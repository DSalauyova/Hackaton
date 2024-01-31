<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', methods: ['GET', 'POST'])]
    public function createUser(User $user): Response
    {
        $user = new User();
        // ... (set properties of the user)
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
