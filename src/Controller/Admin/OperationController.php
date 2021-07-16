<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Operation;
use App\Form\Admin\OperationType;
use App\Entity\Admin\OperationData;
use App\Repository\Admin\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include Snappy required namespaces
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * @Route("/")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/", name="operation_index_par_dept_dir", methods={"GET"})
     */
    public function indexParDeptDir(OperationRepository $operationRepository): Response
    {
        $operations = $operationRepository->findAll();

        return $this->render('admin/operation/index2.html.twig', [
            'operations' => $operations,
            'ppi'  => $this->ppi($operations,'global'),
			'configs' => $this->configs(),
            'mode' => 'category',
            'version' => 'default',
        ]);
    }
    /**
     * @Route("/filtre/{version}", name="operation_index_filtre", methods={"GET"})
     */
    public function indexFiltre(OperationRepository $operationRepository, string $version): Response
    {
        $operations = $operationRepository->findBy(
            ['recueil' => true]
        );

        return $this->render('admin/operation/index2.html.twig', [
            'operations' => $operations,
            'ppi'  => $this->ppi($operations,'global'),
            'configs' => $this->configs(),
            'mode' => 'filter',
            'version' => $version,
        ]);
    }
    /**
     * @Route("/index/{version}", name="operation_index", methods={"GET"})
     */
    public function index(OperationRepository $operationRepository, String $version): Response
    {
        $operations = $operationRepository->findAll();

        return $this->render('admin/operation/index.html.twig', [
            'operations' => $operations,
            'ppi'  => $this->ppi($operations,'global'),
			'configs' => $this->configs(),
            'mode' => 'default',
            'version' => $version,
        ]);
    }
    /**
     * @Route("/reccueil", name="operation_reccueil", methods={"GET"})
     */
    public function reccueil(OperationRepository $operationRepository, Pdf $snappy): Response
    {
        $operations = $operationRepository->findAll();

        // return $this->render('admin/operation/reccueilFiltre.html.twig', [
        //     'operations' => $operations,
		// 	'configs' => $this->configs(),
        //     'mode' => 'category',
        // ]);

        // Generate PDF with WKHTMLTOPDF
        $snappy->setOption("encoding","UTF-8");
        $snappy->setOption("toc",true);
        $snappy->setOption("toc-level-indentation",3);
        // $urlToGeneratePdf = 'http://ppi/operation/reccueilQuartier';
        // $snappy->generate($urlToGeneratePdf, '/files/pdf/recueil_'.date('Ymd').'.pdf');
        $html = $this->renderView(
            'admin\operation\reccueilFiltre.html.twig',
            [
                'operations' => $operations,
                'configs' => $this->configs(),
                'mode' => 'quartier',
                'version' => 'default',
            ]
        );

        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            'recueil_'.date('Ymd').'.pdf'
        );
        // return new Response(
        //     $snappy->getOutputFromHtml($html),
        //     200,
        //     [
        //         'Content-Type'  => 'application/pdf',
        //         'Content-Disposition'   => 'inline; filename="recueil.pdf'
        //     ]
        // );
    }
    /**
     * @Route("/reccueilQuartier", name="operation_reccueil_quartier", methods={"GET"})
     */
    public function reccueilParQuartier(OperationRepository $operationRepository): Response
    {
        $this->configs['site']['libelle']['mainTitle'] = ' ';
        //$operations = $operationRepository->findByRecueil(true);
        $operations = $this->getOperationParQuartier();

        return $this->render('admin/operation/reccueilFiltre.html.twig', [
            'operations' => $operations,
			'configs' => $this->configs(),
            'mode' => 'quartier',
            'version' => 'default',
        ]);
    }
    /**
     * @Route("/reccueilQuartierPrint", name="operation_reccueil_quartier_print", methods={"GET"})
     */
    public function reccueilParQuartierPrint(OperationRepository $operationRepository, Pdf $snappy): Response
    {
        $this->configs['site']['libelle']['mainTitle'] = ' ';
        $operations = $this->getOperationParQuartier($operationRepository);

        // Generate PDF with WKHTMLTOPDF
        $snappy->setOption("encoding","UTF-8");
        $snappy->setOption("toc",true);
        $snappy->setOption("toc-level-indentation",3);

        $html = $this->renderView(
            'admin\operation\reccueilFiltre.html.twig',
            [
                'operations' => $operations,
                'configs' => $this->configs(),
                'mode' => 'quartier',
                'version' => 'default',
            ]
        );

        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            'recueilParQuartier_'.date('Ymd-Hm').'.pdf'
        );
    }
    /**
     * @Route("/reccueilparpolpub", name="operation_reccueil_polpub", methods={"GET"})
     */
    public function reccueilParPolPub(OperationRepository $operationRepository): Response
    {
        $operations = $operationRepository->findBy(
            ['recueil' => true],
            ['politiquePub' => 'asc']
        );

        return $this->render('admin/operation/reccueilFiltre.html.twig', [
            'operations' => $operations,
			'configs' => $this->configs(),
            'mode' => 'polpub',
            'version' => 'seminaire',
        ]);
    }
    /**
     * @Route("/reccueilparpolpubprint", name="operation_reccueil_polpub_print", methods={"GET"})
     */
    public function reccueilParPolPubPrint(OperationRepository $operationRepository, Pdf $snappy): Response
    {
        $this->configs['site']['libelle']['mainTitle'] = ' ';
        $operations = $this->getOperationParPolPub($operationRepository);

        // Generate PDF with WKHTMLTOPDF
        $snappy->setOption("encoding","UTF-8");
        $snappy->setOption("toc",true);
        $snappy->setOption("toc-level-indentation",3);

        $html = $this->renderView(
            'admin\operation\reccueilFiltre.html.twig',
            [
                'operations' => $operations,
                'configs' => $this->configs(),
                'mode' => 'polpub',
                'version' => 'seminaire',
            ]
        );

        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            'recueilParPolitiquePublique_'.date('Ymd-Hm').'.pdf'
        );
    }
    /**
     * @Route("/recueilpardeptdir", name="operation_recueil_deptdir", methods={"GET"})
     */
    public function reccueilParDeptDir(OperationRepository $operationRepository): Response
    {
        $operations = $operationRepository->findBy(
            ['recueil' => true],
            ['user' => 'asc', 'libelle' => 'asc']
        );

        return $this->render('admin/operation/reccueilFiltre.html.twig', [
            'operations' => $operations,
			'configs' => $this->configs(),
            'mode' => 'deptdir',
            'version' => 'default',
        ]);
    }
    /**
     * @Route("/recueilpardeptdirprint", name="operation_recueil_deptdir_print", methods={"GET"})
     */
    public function reccueilParDeptDirPrint(OperationRepository $operationRepository, Pdf $snappy): Response
    {
        $this->configs['site']['libelle']['mainTitle'] = ' ';
        $operations = $this->getOperationParDeptDir($operationRepository);

        // Generate PDF with WKHTMLTOPDF
        $snappy->setOption("encoding","UTF-8");
        $snappy->setOption("toc",true);
        $snappy->setOption("toc-level-indentation",3);

        $html = $this->renderView(
            'admin\operation\reccueilFiltre.html.twig',
            [
                'operations' => $operations,
                'configs' => $this->configs(),
                'mode' => 'deptdir',
                'version' => 'default',
            ]
        );

        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            'recueilParDeptDir_'.date('Ymd-Hm').'.pdf'
        );
    }

    /**
     * @Route("/new", name="operation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $start = 2021;
        $end = 2028;
        $configs = $this->configs();
        $configs['site']['libelle']['currentTitle'] = "Ajout d'une opération";
        $operation = new Operation();
        $operation->setUser($this->getUser());
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('operation_index_par_dept_dir');
        } else {
            // Initialisation des opérations
            // foreach (range($start, $end) as $date) {
            //     $operationData = new OperationData();
            //     $operationData2 = new OperationData();
            //     $operationData->setAnnee($date);
            //     $operationData->setMontant(0);
            //     $operationData->setType(true);
            //     $operationData2->setAnnee($date);
            //     $operationData2->setMontant(0);
            //     $operationData2->setType(false);
            //     $operation->addOperationDatum($operationData);
            //     $operation->addOperationDatum($operationData2);
            // }
        }

        return $this->render('admin/operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
            'configs'   => $configs,
        ]);
    }

    /**
     * @Route("/{id}-{version}", name="operation_show", methods={"GET"})
     */
    public function show(Operation $operation, string $version): Response
    {
        return $this->render('admin/operation/show.html.twig', [
            'operation' => $operation,
            //'ppi'  => $this->ppi([$operation],'parCategorie'),
            'configs'   => $this->configs(),
            'version'   => $version
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_operation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operation $operation): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operation_index', [
                'id' => $operation->getId(),
            ]);
        }

        return $this->render('admin/operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
            'configs'   => $this->configs(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Operation $operation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operation_index');
    }

    protected function ppi(Array $operations, String $category)
    {
        $libelleAnnee = array();
        $ppi = array();

        // construction du tableau des PPI
        foreach($operations as $operation)
        {
            //$libelle = $operation->getId() .'####'. $operation->getLibelle();
            $datas = $operation->getOperationData();
            foreach($datas as $item) {
                $departement = $direction = '';
                $regroupement = $operation->getRegroupementOpe();
                $quartier = $operation->getQuartier();
                $natureOpe = $operation->getNatureOpe();
                $politiquePub = $operation->getPolitiquePub();
                $description = $operation->getDescription();
                $commentaire = $operation->getCommentaire();
                $dob = $operation->getDob();
                $recueil = $operation->getRecueil();
                $coupParti = $operation->getCoutParti();
                $dateLivraison = 'Aucune';
                if ($operation->getDateLivraison())
                {
                    $dateLivraison = $operation->getDateLivraison()->format("d/m/Y");
                }
                $codeMaire = $operation->getCodeMaire();
                $code = $operation->getCode();
                if (! empty($operation->getUser()))
                {
                    $departement = $operation->getUser()->getDepartement();
                    $direction = $operation->getUser()->getDirection();
                }
                $libelle = $operation->getLibelle().'####'.$operation->getId().'####'.$departement.'####'.$direction.'####'.$code.'####'.$regroupement.'####'.$codeMaire.'####'.$quartier.'####'.$natureOpe.'####'.$politiquePub.'####'.$dob.'####'.$recueil.'####'.$coupParti.'####'.$dateLivraison;
                $annee = $item->getAnnee();
                $compte = ($item->getType() ? 'depense' : 'recette' );
    
                switch(strtolower($category))
                {
                    case 'parcategorie':
                        if (! isset($ppi[$compte][$annee]))
                        {
                            $ppi['depense'][$annee] = $ppi['recette'][$annee] = 0;
                        }
                        $ppi[$compte][$annee] += $item->getMontant();
            
                        $libelleAnnee[] = $annee;
                        break;
                    default:
                        if (! isset($ppi[$libelle][$annee][$compte]))
                        {
                            $ppi[$libelle][$annee]['depense'] = $ppi[$libelle][$annee]['recette'] = 0;
                        }
                        $ppi[$libelle][$annee][$compte] += $item->getMontant();
            
                        $libelleAnnee[] = $annee;
                }
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

        return $ppi;
    }

    private function getOperationParQuartier(OperationRepository $operationRepository)
    {
        return $operationRepository->findBy(
            ['recueil' => true]
        );
    }

    private function getOperationParPolPub(OperationRepository $operationRepository)
    {
        return $operationRepository->findBy(
            ['recueil' => true],
            ['politiquePub' => 'asc']
        );
    }

    private function getOperationParDeptDir(OperationRepository $operationRepository)
    {
        return $operationRepository->findBy(
            ['recueil' => true],
            ['user' => 'asc', 'libelle' => 'asc']
        );
    }

    private function configs ()
    {
		return array(
			'site' => [
                'theme' => 'dimension',
                'libelle' => [
                    'mainTitle' => "Plan Pluriannuel d'Investissement 2020 - 2026",
                    'description' => "description de l’opération d’investissement",
                    'datelivraison' => "date de livraison",
                    'coutparti' => "coût parti",
                    'coutTotal' => "coût total",
                    'estimation' => "estimation du coût de l’opération",
                    'remarques' => "remarques et informations financières",
                ],
			],
		);
    }
}
