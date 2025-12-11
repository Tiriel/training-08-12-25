<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Volunteering;
use App\Form\VolunteeringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/volunteering')]
final class VolunteeringController extends AbstractController
{
    #[Route('/{id}', name: 'app_volunteering_show', requirements: ['id' => Requirement::DIGITS])]
    public function show(Volunteering $volunteering): Response
    {
        return $this->render('volunteering/show.html.twig', [
            'volunteering' => $volunteering
        ]);
    }

    #[Route('/new/{conferenceId}',
        name: 'app_volunteering_new',
        requirements: ['conferenceId' => Requirement::DIGITS],
        defaults: ['conferenceId' => null]
    )]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        #[MapEntity(mapping: ['conferenceId' => 'id'])] ?Conference $conference
    ): Response
    {
        $volunteering = (new Volunteering())
            ->setForUser($this->getUser())
            ->setConference($conference)
        ;
        $form = $this->createForm(VolunteeringType::class, $volunteering, ['conference' => $conference]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($volunteering);
            $manager->flush();

            return $this->redirectToRoute('app_volunteering_show', ['id' => $volunteering->getId()]);
        }

        return $this->render('volunteering/new.html.twig', [
            'form' => $form,
        ]);
    }
}
