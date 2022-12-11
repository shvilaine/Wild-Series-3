<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActorRepository;
use App\Entity\Actor;

#[Route('/actor', name: 'actor_', method: ['GET'])]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();

        return $this->render(
            'actor/index.html.twig',
            [
                'actors' => $actors,
            ]
        );
    }

    #[Route('/{id}', methods: ['GET'], name: 'show')]
    public function show(Actor $actor): Response
    {
        $programs = $actor->getPrograms();

        return $this->render(
            'actor/show.html.twig',
            [
                'actor' => $actor,
            ]
        );
    }
}
