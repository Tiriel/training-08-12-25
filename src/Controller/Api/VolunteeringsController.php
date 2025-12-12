<?php

namespace App\Controller\Api;

use App\Entity\Volunteering;
use App\Repository\VolunteeringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class VolunteeringsController extends AbstractController
{
    #[Route('/api/volunteerings', name: 'app_api_volunteerings')]
    public function index(VolunteeringRepository $repository, int $maxResults, #[MapQueryParameter] int $page = 1): JsonResponse
    {
        $volunteerings = $repository->findBy([], [], $maxResults, $maxResults * ($page - 1));

        return $this->json($volunteerings, context: [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn(object $o) => $o->getId(),
            AbstractNormalizer::GROUPS => ['volunteering'],
        ]);
    }
}
