<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @psalm-suppress UnusedClass
 */
class CarController extends AbstractController
{
    #[Route('/parser/php', name: 'app_parser_php')]
    public function plainCode(): Response
    {
        $myCar = new Car;

        $myCar->setBrand('Volvo');
        $myCar->setModel('C30');
        $myCar->setYear(2009);

        $data = 5;
        $condition = rand(0, 6);
        if ($condition === $data) {
            echo 'true number';
        } elseif ($condition != $data) {
            echo 'false number';
        }


        return $this->render('car/index.html.twig', [
            'object' => $myCar,
            'var' => $condition
        ]);
    }
}
