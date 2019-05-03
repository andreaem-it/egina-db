<?php

namespace App\Controller;

use App\Entity\Guests;
use App\Entity\TipoArticoli;
use App\Form\GuestsType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GuestsController extends AbstractController
{
    /**
     * @Route("lista-clienti/", name="lista_clienti")
     */
    public function clientsListAction(Request $request, PaginatorInterface $paginator)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Guests::class);
        $query = $repo->createQueryBuilder('a')->getQuery();

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 5);

        return $this->render('guests/list.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/nuovo-cliente", name="nuovo_cliente")
     */
    public function clientsNewAction(Request $request)
    {

        $cliente = new Guests();

        $form = $this->createForm(GuestsType::class, $cliente);
        $form
            ->add('submit', SubmitType::class, [
                'label' => 'Aggiungi'
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Reset'
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cliente = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            $this->addFlash('success', 'Cliente Aggiunto!');

            return $this->redirectToRoute('lista_clienti');
        }

        return $this->render('guests/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mostra-cliente/{id}", name="mostra_cliente")
     */
    public function clientsShowAction($id,Request $request, PaginatorInterface $paginator) {
        $u = $this->getDoctrine()->getRepository(Guests::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT a FROM App:Articoli a WHERE a.lastuser = $id";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 5);

        return $this->render('guests/show.html.twig', [
            'u' => $u,
            'pagination' => $pagination
        ]);
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
