<?php

namespace App\Controller;

use App\Entity\Conference;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class ConferenceController extends AbstractController
{
    #[Route(
        '/conference/{name}/{start}/{end}',
        name: 'app_conference_new',
        requirements: ['name' => '[a-zA-Z ]+', 'start' => Requirement::DATE_YMD, 'end' => Requirement::DATE_YMD],
    )]
    public function newConference(string $name, string $start, string $end, EntityManagerInterface $em): Response
    {
        $conference = (new Conference())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        $em->persist($conference);
        $em->flush();

        return new Response('Conference created');
    }
}
