<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render(
            'program/index.html.twig',
            [
                'programs' => $programs,
            ]
        );
    }

    #[Route('/{id<0-9]+$>}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if(!$program) {
            throw $this->createNotFoundException(
                'No program with id: '.$id.' found in Programs table.'
            );
        }

        return $this->render(
            'program/show.html.twig',
            [
                'program' => $program
            ]
        );
    }
}
/*     public function new(): Response
    {
        return $this->redirectToRoute('program_show', ['id' => 4]);
    }
*/
