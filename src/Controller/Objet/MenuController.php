<?php

namespace App\Controller\Objet;

use App\Entity\Objet\Menu;
use App\Form\Objet\MenuType;
use App\Repository\Objet\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/objet/menu")
 */
class MenuController extends AbstractController {
	/**
	 * @Route("/", name="objet_menu_index", methods="GET")
	 */
	public function index(MenuRepository $menuRepository): Response {
		return $this->render('objet/menu/index.html.twig', ['menus' => $menuRepository->findMainMenu('operations')]);
	}

	/**
	 * @Route("/new", name="objet_menu_new", methods="GET|POST")
	 */
	public function new (Request $request): Response{
		$menu = new Menu();
		$form = $this->createForm(MenuType::class, $menu);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($menu);
			$em->flush();

			return $this->redirectToRoute('objet_menu_index');
		}

		return $this->render('objet/menu/new.html.twig', [
			'menu' => $menu,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="objet_menu_show", methods="GET")
	 */
	public function show(Menu $menu): Response {
		return $this->render('objet/menu/show.html.twig', ['menu' => $menu]);
	}

	/**
	 * @Route("/{id}/edit", name="objet_menu_edit", methods="GET|POST")
	 */
	public function edit(Request $request, Menu $menu): Response{
		$form = $this->createForm(MenuType::class, $menu);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('objet_menu_index', ['id' => $menu->getId()]);
		}

		return $this->render('objet/menu/edit.html.twig', [
			'menu' => $menu,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="objet_menu_delete", methods="DELETE")
	 */
	public function delete(Request $request, Menu $menu): Response {
		if ($this->isCsrfTokenValid('delete' . $menu->getId(), $request->request->get('_token'))) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($menu);
			$em->flush();
		}

		return $this->redirectToRoute('objet_menu_index');
	}
}
