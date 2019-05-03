<?php

namespace App\Controller;

use App\Entity\Articoli;
use App\Entity\Guests;
use App\Entity\Prenotazioni;
use App\Entity\Prestiti;
use App\Entity\TipoArticoli;
use App\Form\ArticoliType;
use App\Form\PrestitiType;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use SGK\BarcodeBundle\Generator\Generator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{

    /**
     * @Route("/lista-articoli", name="lista_articoli")
     */
    public function articlesListAction(Request $request, PaginatorInterface $paginator)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Articoli::class);
        $query = $repo->createQueryBuilder('a')->getQuery();

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('articles/list.html.twig', [
            'pagination' => $pagination,
            'fun' => $this
        ]);
    }

    /**
     * @Route("/nuovo-articolo", name="nuovo_articolo")
     */
    public function articlesNewAction(Request $request)
    {

        $article = new Articoli();

        $form = $this->createForm(ArticoliType::class, $article);
        $form
            ->add('submit', SubmitType::class, [
                'label' => 'Aggiungi'
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Reset'
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setDateAdd(new DateTime("now"));
            $article->setIsAvaiable(1);
            $article->setType($form->getData()->getType()->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            //$this->addFlash('success', 'Articolo Aggiunto!');

            return $this->redirectToRoute('lista_articoli', [
                'toast_message' => 'Articolo aggiunto con successo'
            ]);
        }

        return $this->render('articles/add.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Aggiungi Articolo',
        ]);
    }

    /**
     * @Route("/modifica-articolo/{id}", name="modifica_articolo")
     */
    public function articlesEditAction(Request $request, $id)
    {

        $article = $this->getDoctrine()->getRepository(Articoli::class)->find($id);

        $form = $this->createForm(ArticoliType::class, $article);
        $form
            ->add('submit', SubmitType::class, [
                'label' => 'Aggiungi'
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Reset'
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setIsAvaiable(1);
            $article->setType($form->getData()->getType()->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);

            return $this->redirectToRoute('lista_articoli');
        }

        return $this->render('articles/add.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Modifica Articolo'
        ]);
    }

    /**
     * @Route("/scheda-articolo/{id}", name="scheda_articolo")
     */
    public function articlesShowAction($id, PaginatorInterface $paginator, Request $request)
    {
        $item = $this->getDoctrine()->getRepository(Articoli::class)->find($id);

        if ($item == null) {
            $this->redirectToRoute('lista_articoli');
            $this->createNotFoundException('Articolo non trovato');
        } else {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT a FROM App:Prestiti a WHERE a.item = $id";
            $query = $em->createQuery($dql);
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                5, [
                    'defaultSortFieldName' => 'a.date',
                    'defaultSortDirection' => 'desc'
                ]);
            $dql2 = "SELECT a FROM App:Prenotazioni a WHERE a.item = $id";
            $query2 = $em->createQuery($dql2);
            $pagination2 = $paginator->paginate(
                $query2,
                $request->query->getInt('page', 1),
                5, [
                'defaultSortFieldName' => 'a.date',
                'defaultSortDirection' => 'desc'
            ]);
        }

        $options = array(
            'code'   => $this->generateUrl('scheda_articolo', ['id' => $item->getId()]),
            'type'   => 'qrcode',
            'format' => 'png',
            'width'  => 7,
            'height' => 7,
            'color'  => array(100, 100, 100),
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);

        return $this->render('articles/show.html.twig', [
            'fun' => $this,
            'pagination' => $pagination,
            'pagination2' => $pagination2,
            'item' => $item,
            'barcode' => $barcode,
            'delete' => false
        ]);

    }

    /**
     * @Route("/elimina-articolo/{id}", name="elimina_articolo")
     */
    public function articlesDeleteAction(Request $request,$id)
    {

        $item = $this->getDoctrine()->getRepository(Articoli::class)->find($id);

        $options = array(
            'code'   => $request->getUri() . $this->generateUrl('scheda_articolo', ['id' => $item->getId()]),
            'type'   => 'qrcode',
            'format' => 'png',
            'width'  => 8,
            'height' => 8,
            'color'  => array(100, 100, 100),
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);

        return $this->render('articles/show.html.twig', [
            'barcode' => $barcode,
            'fun' => $this,
            'pagination' => null,
            'item' => $item,
            'delete' => true
        ]);
    }

    /**
     * @Route("/elimina-articolo/conferma/{id}", name="elimina_articolo_conferma")
     */
    public function articlesDeleteConfirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository(Articoli::class)->find($id);
        $movements = $em->getRepository(Prestiti::class)->findBy(['item' => $id]);

        $em->remove($item);
        $em->flush();

        foreach ($movements as $movement) {
            $em->remove($movement);
            $em->flush();
        }



        return $this->redirectToRoute('lista_articoli');
    }


    /**
     * @Route("/aggiungi-movimento/{id}", name="aggiungi_movimento")
     */
    public function addMovementAction(Request $request, $id)
    {

        $movimento = new Prestiti();

        $form = $this->createForm(PrestitiType::class, $movimento);
        $form
            ->add('submit', SubmitType::class, [
                'label' => 'Aggiungi'
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Reset'
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item = $this->getDoctrine()->getRepository(Articoli::class)->find($id);

            $movimento = $form->getData();
            $movimento->setDate(new DateTime("now"));
            $movimento->setItem($id);

            $item->setIsAvaiable($form->getData()->getStatus());
            $item->setLastuser($movimento->getGuest());
            $item->setLastmovement($movimento->getDate());
            $item->setLocation($movimento->getLocation());
            $item->setMotivation($movimento->getMotivation());

            $em = $this->getDoctrine()->getManager();
            $em->persist($movimento);
            $em->flush();

            $em->flush($item);

            return $this->redirectToRoute('scheda_articolo', [
                'id' => $id
            ]);
        }

        return $this->render('movements/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("api/json/avaiabilty/{id}", name="json_avaiability")
     */
    public function aggregateJSONAvaiability($id) {

        $events = $this->getDoctrine()->getRepository(Prestiti::class)->findBy(['item' => $id]);
        $prenotazioni = $this->getDoctrine()->getRepository(Prenotazioni::class)->findBy(['item' => $id]);

        $response = new Response();
        $array = ['monthly' => []];

        foreach ($events as $event) {
            $new = [
                'id' => $event->getId(),
                'name' => $this->getDoctrine()->getRepository(Guests::class)->find($event->getGuest())->getName() . ' - PRESTITO',
                'startdate' => $event->getDate()->format("Y-m-d"),
                'enddate' => $event->getDateBack()->format("Y-m-d"),
                'starttime' => $event->getDate()->format("h:i"),
                'endtime' => $event->getDateBack()->format("h:i"),
                'color' => "#FF5733",
                'url' => ''
            ];
            array_push( $array['monthly'], $new);
        }

        foreach ($prenotazioni as $prenotazione) {
            $new = [
                'id' => $prenotazione->getId(),
                'name' => $this->getDoctrine()->getRepository(Guests::class)->find($prenotazione->getUser())->getName() . ' - PRENOTAZIONE',
                'startdate' => $prenotazione->getDate()->format("Y-m-d"),
                'enddate' => $prenotazione->getDateBack()->format("Y-m-d"),
                'starttime' => $prenotazione->getDate()->format("h:i"),
                'endtime' => $prenotazione->getDateBack()->format("h:i"),
                'color' => "#FFC300",
                'url' => ''
            ];
            array_push( $array['monthly'], $new);
        }


        $response->setContent(json_encode($array));
        //$response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function convertType($id)
    {
        return $this->getDoctrine()->getRepository(TipoArticoli::class)->find($id)->getName();
    }

    public function convertClient($id)
    {
        return $this->getDoctrine()->getRepository(Guests::class)->find($id)->getName();
    }

}
