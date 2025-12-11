<?php

namespace App\Controller;

use App\Dto\ApiConference;
use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Search\ConferenceSearchInterface;
use App\Search\DatabaseConferenceSearch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/conference')]
final class ConferenceController extends AbstractController
{
    #[Route('', name: 'app_conference_list', methods: ['GET'])]
    public function list(DatabaseConferenceSearch $search, #[MapQueryParameter] int $page = 1, #[MapQueryParameter] ?string $name = null): Response
    {
        return $this->render('conference/list.html.twig', [
            'conferences' => $search->searchByName($name, $page),
        ]);
    }

    #[Route('/search', name: 'app_conference_search', methods: ['GET'])]
    public function search(#[MapQueryParameter] string $name, ConferenceSearchInterface $search)
    {
        return $this->render('conference/search.html.twig', [
            'conferences' => $search->searchByName($name),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_conference_show', methods: ['GET'])]
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    #[Route('/new', name: 'app_conference_new', methods: ['GET', 'POST'])]
    #[Route('/{id<\d+>}/edit', name: 'app_conference_edit', methods: ['GET', 'POST'])]
    public function save(?Conference $conference, Request $request, EntityManagerInterface $manager): Response
    {
        $conference ??= new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($conference);
            $manager->flush();

            return $this->redirectToRoute('app_conference_show', ['id' => $conference->getId()]);
        }

        return $this->render('conference/new.html.twig', [
            'form' => $form,
        ]);
    }
}
