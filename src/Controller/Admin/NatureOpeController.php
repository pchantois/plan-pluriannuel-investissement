<?php

namespace App\Controller\Admin;

use App\Entity\Admin\NatureOpe;
use App\Form\Admin\NatureOpeType;
use App\Repository\Admin\NatureOpeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nature/ope")
 */
class NatureOpeController extends AbstractController
{
    /**
     * @Route("/", name="admin_nature_ope_index", methods={"GET"})
     */
    public function index(NatureOpeRepository $natureOpeRepository): Response
    {
        return $this->render('admin/nature_ope/index.html.twig', [
            'nature_opes' => $natureOpeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_nature_ope_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $natureOpe = new NatureOpe();
        $form = $this->createForm(NatureOpeType::class, $natureOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($natureOpe);
            $entityManager->flush();

            return $this->redirectToRoute('admin_nature_ope_index');
        }

        return $this->render('admin/nature_ope/new.html.twig', [
            'nature_ope' => $natureOpe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_nature_ope_show", methods={"GET"})
     */
    public function show(NatureOpe $natureOpe): Response
    {
        return $this->render('admin/nature_ope/show.html.twig', [
            'nature_ope' => $natureOpe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_nature_ope_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NatureOpe $natureOpe): Response
    {
        $form = $this->createForm(NatureOpeType::class, $natureOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_nature_ope_index', [
                'id' => $natureOpe->getId(),
            ]);
        }

        return $this->render('admin/nature_ope/edit.html.twig', [
            'nature_ope' => $natureOpe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_nature_ope_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NatureOpe $natureOpe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$natureOpe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($natureOpe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_nature_ope_index');
    }
}
