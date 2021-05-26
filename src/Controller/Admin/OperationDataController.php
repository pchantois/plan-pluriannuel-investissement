<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Operation;
use App\Entity\Admin\OperationData;
use App\Form\Admin\OperationDataType;
use App\Repository\Admin\OperationDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operations")
 */
class OperationDataController extends AbstractController
{
    /**
     * @Route("/", name="admin_operation_data_index", methods={"GET"})
     */
    public function index(OperationDataRepository $operationDataRepository): Response
    {
        $operations = $operationDataRepository->findAll();
        return $this->render('admin/operation_data/index.html.twig', [
            'operation_datas' => $operations,
        ]);
    }
    /**
     * @Route("/estimation/{operation}", name="admin_operation_data_estimation", methods={"GET"})
     */
    public function estimation(Operation $operation, OperationDataRepository $operationDataRepository): Response
    {
        $items = $operationDataRepository->findBy(
            [
                'operation'=> $operation
            ],
            [
                'type'=>'ASC',
                'annee'=>'ASC'
            ]
        );
        return $this->render('admin/operation_data/index.html.twig', [
            'operation_datas' => $items,
        ]);
    }

    /**
     * @Route("/new", name="admin_operation_data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operationDatum = new OperationData();
        $form = $this->createForm(OperationDataType::class, $operationDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operationDatum);
            $entityManager->flush();

            return $this->redirectToRoute('admin_operation_data_index');
        }

        return $this->render('admin/operation_data/new.html.twig', [
            'operation_datum' => $operationDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_data_show", methods={"GET"})
     */
    public function show(OperationData $operationDatum): Response
    {
        return $this->render('admin/operation_data/show.html.twig', [
            'operation_datum' => $operationDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_operation_data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OperationData $operationDatum): Response
    {
        $form = $this->createForm(OperationDataType::class, $operationDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_operation_data_index', [
                'id' => $operationDatum->getId(),
            ]);
        }

        return $this->render('admin/operation_data/edit.html.twig', [
            'operation_datum' => $operationDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_data_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OperationData $operationDatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operationDatum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operationDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_operation_data_index');
    }

    protected function ppi(Array $operations, String $category = 'global')
    {
        $libelleAnnee = array();
        $ppi = array();

        // construction du tableau des PPI
        foreach($operations as $operation)
        {
            //$libelle = $operation->getId() .'####'. $operation->getLibelle();
            $libelle = $operation->getOperation()->getLibelle();
            $annee = $operation->getAnnee();
            $compte = ($operation->getType() ? 'depense' : 'recette' );

            switch(strtolower($category))
            {
                case 'parcategorie':
                    if (! isset($ppi[$compte][$annee]))
                    {
                        $ppi['depense'][$annee] = $ppi['recette'][$annee] = 0;
                    }
                    $ppi[$compte][$annee] += $operation->getMontant();
        
                    $libelleAnnee[] = $annee;
                    break;
                default:
                    if (! isset($ppi[$libelle][$annee][$compte]))
                    {
                        $ppi[$libelle][$annee]['depense'] = $ppi[$libelle][$annee]['recette'] = 0;
                    }
                    $ppi[$libelle][$annee][$compte] += $operation->getMontant();
        
                    $libelleAnnee[] = $annee;
            }
        }
        
        $libelleAnnee = array_unique($libelleAnnee);

        foreach($ppi as $key => $value)
        {
            foreach($libelleAnnee as $item)
            {
                switch(strtolower($category))
                {
                    case 'parcategory':
                        if (! isset($ppi[$key][$item]))
                        {
                            $ppi[$key][$item] = 0;
                        }
                        break;
                    default:
                        if (! isset($ppi[$key][$item]))
                        {
                            $ppi[$key][$item]['depense'] = 0;
                            $ppi[$key][$item]['recette'] = 0;
                        }
                }
            }
            ksort($ppi[$key]);
        }

		$configs = array(
			'site' => [
				'theme' => 'dimension',
			],
        );

        return $ppi;
        // return $this->render('admin/operation/ppi.html.twig', [
        //     'items' => $ppi,
		// 	//'configs' => $configs,
        // ]);
    }
}
