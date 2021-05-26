<?php

namespace App\Controller\Admin;

use App\Entity\Admin\RegroupementOpe;
use App\Form\Admin\RegroupementOpeType;
use App\Repository\Admin\RegroupementOpeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/regroupement/ope")
 */
class RegroupementOpeController extends AbstractController
{
    /**
     * @Route("/", name="admin_regroupement_ope_index", methods={"GET"})
     */
    public function index(RegroupementOpeRepository $regroupementOpeRepository): Response
    {
        return $this->render('admin/regroupement_ope/index.html.twig', [
            'regroupement_opes' => $regroupementOpeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_regroupement_ope_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $regroupementOpe = new RegroupementOpe();
        $form = $this->createForm(RegroupementOpeType::class, $regroupementOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($regroupementOpe);
            $entityManager->flush();

            return $this->redirectToRoute('admin_regroupement_ope_index');
        }

        return $this->render('admin/regroupement_ope/new.html.twig', [
            'regroupement_ope' => $regroupementOpe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_regroupement_ope_show", methods={"GET"})
     */
    public function show(RegroupementOpe $regroupementOpe): Response
    {
        return $this->render('admin/regroupement_ope/show.html.twig', [
            'regroupement_ope' => $regroupementOpe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_regroupement_ope_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RegroupementOpe $regroupementOpe): Response
    {
        $form = $this->createForm(RegroupementOpeType::class, $regroupementOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_regroupement_ope_index', [
                'id' => $regroupementOpe->getId(),
            ]);
        }

        return $this->render('admin/regroupement_ope/edit.html.twig', [
            'regroupement_ope' => $regroupementOpe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_regroupement_ope_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RegroupementOpe $regroupementOpe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$regroupementOpe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($regroupementOpe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_regroupement_ope_index');
    }
}
