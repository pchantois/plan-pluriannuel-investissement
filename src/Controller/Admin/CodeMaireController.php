<?php

namespace App\Controller\Admin;

use App\Entity\Admin\CodeMaire;
use App\Form\Admin\CodeMaireType;
use App\Repository\Admin\CodeMaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/code/maire")
 */
class CodeMaireController extends AbstractController
{
    /**
     * @Route("/", name="admin_code_maire_index", methods={"GET"})
     */
    public function index(CodeMaireRepository $codeMaireRepository): Response
    {
        return $this->render('admin/code_maire/index.html.twig', [
            'code_maires' => $codeMaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_code_maire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $codeMaire = new CodeMaire();
        $form = $this->createForm(CodeMaireType::class, $codeMaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($codeMaire);
            $entityManager->flush();

            return $this->redirectToRoute('admin_code_maire_index');
        }

        return $this->render('admin/code_maire/new.html.twig', [
            'code_maire' => $codeMaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_code_maire_show", methods={"GET"})
     */
    public function show(CodeMaire $codeMaire): Response
    {
        return $this->render('admin/code_maire/show.html.twig', [
            'code_maire' => $codeMaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_code_maire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CodeMaire $codeMaire): Response
    {
        $form = $this->createForm(CodeMaireType::class, $codeMaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_code_maire_index', [
                'id' => $codeMaire->getId(),
            ]);
        }

        return $this->render('admin/code_maire/edit.html.twig', [
            'code_maire' => $codeMaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_code_maire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CodeMaire $codeMaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$codeMaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($codeMaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_code_maire_index');
    }
}
