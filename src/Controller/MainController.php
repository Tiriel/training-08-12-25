<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main_index')]
    public function index(Request $request): Response
    {
        $name = $request->query->getString('name', 'World');

        return new Response(<<<EOD
<html>
    <head>
        <title>Hello World</title>
    </head>
    <body>
        <h1 style="color: red;">Hello $name</h1>
    </body>
</html>
EOD
);
    }

    #[Route('/contact', name: 'app_main_contact')]
    public function contact(): Response
    {
        return new Response('Contact');
    }
}
