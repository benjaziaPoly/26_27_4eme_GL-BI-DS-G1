<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription/json', name: 'test_json')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/InscriptionController.php',
        ]);
    }
    #[Route('/inscription/html', name: 'test_html')]
    public function testhtml(): Response
    {
        return new Response(
            "<html><body>my first page wityh html</body></html>"
        );
    }
    #[Route('/inscription/number', name: 'test_number')]
    public function number(): Response
    {
        $n=random_int(0,100);

        return $this->render("inscription/number.html.twig",
        ["number"=>$n]
        );
      
    }
     #[Route('/inscription/number/{code}', name: 'test_number_param', requirements:['code'=>'\d+'])]
    public function number_param(int $code): Response
    {
        $n=random_int(0,100);

        return $this->render("inscription/number_param.html.twig",
        ["number"=>$n,"code"=>$code]
        );
      
    }
// seance du 06/10/2026
      #[Route('/indicateur', name: 'test_indicateur')]
    public function test_indicateur(): Response
    {
        $indicateurs=[
            ['libelle' => 'Taux de réussite', 'valeur' => 87.4567, 'unite' => '%'],
            ['libelle' => 'Nombre d\'étudiants', 'valeur' => 1245, 'unite' => ''],
            ['libelle' => 'Budget consommé', 'valeur' => 15230.5, 'unite' => 'DT'],
        ];


        return $this->render("inscription/indicateur.html.twig",
        ["indicateurs"=>$indicateurs]);
      
    }

 #[Route('/Accueil', name: 'accueil')]
    public function welcome(): Response
    {
        $n=random_int(0,100);

        return $this->render("inscription/accueil.html.twig",
        ["number"=>$n]
        );
      
    }
}
