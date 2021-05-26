<?php

namespace App\Controller\Admin;

use App\Entity\Admin\PolitiquePub;
use App\Form\Admin\PolitiquePubType;
use App\Repository\Admin\PolitiquePubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/politique/pub")
 */
class PolitiquePubController extends AbstractController
{
    /**
     * @Route("/", name="admin_politique_pub_index", methods={"GET"})
     */
    public function index(PolitiquePubRepository $politiquePubRepository): Response
    {
        return $this->render('admin/politique_pub/index.html.twig', [
            'politique_pubs' => $politiquePubRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_politique_pub_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $politiquePub = new PolitiquePub();
        $form = $this->createForm(PolitiquePubType::class, $politiquePub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($politiquePub);
            $entityManager->flush();

            return $this->redirectToRoute('admin_politique_pub_index');
        }

        return $this->render('admin/politique_pub/new.html.twig', [
            'politique_pub' => $politiquePub,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_politique_pub_show", methods={"GET"})
     */
    public function show(PolitiquePub $politiquePub): Response
    {
        return $this->render('admin/politique_pub/show.html.twig', [
            'politique_pub' => $politiquePub,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_politique_pub_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PolitiquePub $politiquePub): Response
    {
        $form = $this->createForm(PolitiquePubType::class, $politiquePub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_politique_pub_index', [
                'id' => $politiquePub->getId(),
            ]);
        }

        return $this->render('admin/politique_pub/edit.html.twig', [
            'politique_pub' => $politiquePub,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_politique_pub_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PolitiquePub $politiquePub): Response
    {
        if ($this->isCsrfTokenValid('delete'.$politiquePub->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($politiquePub);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_politique_pub_index');
    }
}
