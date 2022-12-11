<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, Request $request): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            [
                'programs' => $programs
            ]
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            $this->addFlash('success', 'The new program has been created');
            return $this->redirectToRoute('program_index');
        }

        // Render the form (best practice)
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{program}', methods: ['GET'], name: 'show')]
    public function show(Program $program, SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findBy(['program' => $program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id: ' . $program . ' found in Programs table.'
            );
        }

        return $this->render(
            'program/show.html.twig',
            [
                'program' => $program,
                'seasons' => $seasons,
            ]
        );
    }

    #[Route('/{program}/seasons/{season}', name: 'season_show')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository): Response
    {
        $episodes = $episodeRepository->findBy(['season' => $season]);

        return $this->render(
            'program/season_show.html.twig',
            [
                'program' => $program,
                'season' => $season,
                'episodes' => $episodes,
            ]
        );
    }

    #[Route('/{program}/seasons/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render(
            'program/episode_show.html.twig',
            [
                'program' => $program,
                'season' => $season,
                'episode' => $episode,
            ]
        );
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Season $season, SeasonRepository $seasonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $season->getId(), $request->request->get('_token'))) {
            $seasonRepository->remove($season, true);

            $this->addFlash('danger', 'This program has been deleted');
        }

        return $this->redirectToRoute('app_season_index', [], Response::HTTP_SEE_OTHER);
    }
}
/*     public function new(): Response
    {
        return $this->redirectToRoute('program_show', ['id' => 4]);
    }
*/
