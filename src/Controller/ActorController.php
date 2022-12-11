<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActorRepository;
use App\Entity\Actor;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render(
            'actor/index.html.twig',
            [
                'actors' => $actorRepository->findAll(),
            ]
        );
    }

    #[Route('/{id}', methods: ['GET'], name: 'show')]
    public function show(Actor $actor): Response
    {
        return $this->render(
            'actor/show.html.twig',
            [
                'actor' => $actor,
            ]
        );
    }
}
