<?php

namespace App\Controller;

use App\Entity\GitLink;
use App\Form\GitFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GitLinkController extends AbstractController
{
    #[Route('/link', name: 'app_git_link', methods: ['GET', 'POST'])]
    public function getLink(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $link = new GitLink();
        $form = $this->createForm(GitFormType::class, $link);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $link->setUser($this->getUser());
            $link = $form->getData();
            $manager->persist($link);
            $manager->flush();
        }
        return $this->render('git_link/link.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
