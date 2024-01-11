<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

// /**
//  * @psalm-suppress PossiblyUnusedMethod
//  */
// class TestController extends AbstractController
// {
//     #[Route('/test', name: 'test_php')]
//     public function takesAnInt(): Response
//     {
//         $data = 5;
//         $condition = rand(0, 6);
//         if ($condition === $data) {
//             echo 'true number';
//         } elseif ($condition != $data) {
//             echo 'false number';
//         }
//         return $this->render('car/index.html.twig', [
//             'var' => $condition
//         ]);
//     }
// }
