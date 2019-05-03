<?php

namespace App\Controller;

use App\Entity\Articoli;
use App\Entity\Prenotazioni;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        $outCount = $this->getDoctrine()->getRepository(Articoli::class)->findBy(['is_avaiable' => 0]);
        $inCount = $this->getDoctrine()->getRepository(Articoli::class)->findBy(['is_avaiable' => 1]);
        //$preCount = $this->getDoctrine()->getRepository(Prenotazioni::class)->findAll();
        $preCount = [];

        return $this->render('default/index.html.twig', [
            'outCount' => count($outCount),
            'inCount' => count($inCount),
            'preCount' => count($preCount),
        ]);
    }

}
