<?php

namespace App\Controller;

use App\Entity\Articoli;
use App\Entity\Guests;
use App\Entity\Prenotazioni;
use App\Form\PrenotazioniType;
use ErrorException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\Cloner\Data;

class PrenotazioniController extends AbstractController
{
    /**
     * @Route("/lista-prenotazioni", name="lista_prenotazioni")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Prenotazioni::class);
        $query = $repo->createQueryBuilder('a')->getQuery();

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 5);

        return $this->render('prenotazioni/list.html.twig', [
            'pagination' => $pagination,
            'fun' => $this
        ]);
    }

    /**
     * @Route("/nuova-prenotazione", name="nuova_prenotazione")
     */
    public function newPrenotazioneAction(Request $request) {
        $prenotazione = new Prenotazioni();

        $form = $this->createForm(PrenotazioniType::class, $prenotazione);
        $form
            ->add('submit', SubmitType::class, [
                'label' => 'Aggiungi'
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Reset'
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$previous = $this->getDoctrine()->getRepository(Prenotazioni::class)->findBy(['date' => $prenotazione->getDate()]);

            //if($prenotazione->getDate() == $previous) {
            //    return new ErrorException('Attenzione: L\'oggetto non è disponibile per la data scelta');
            //} else {
                $prenotazione = $form->getData();
                $prenotazione->setUser(intval($form->getData()->getUser()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($prenotazione);
                $em->flush();

                return $this->redirectToRoute('lista_prenotazioni');
            //}
        }

        return $this->render('prenotazioni/add.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Aggiungi Prenotazione'
        ]);
    }

    public function convertClient($id)
    {
        return $this->getDoctrine()->getRepository(Guests::class)->find($id)->getName();
    }

    public function convertItem($id)
    {
        return $this->getDoctrine()->getRepository(Articoli::class)->find($id)->getName();
    }
}
