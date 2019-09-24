<?php

namespace App\Controller;

use App\Enums\Roles;
use App\Repository\PageRepository;
use App\Service\SearchParams;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/page")
 * @IsGranted(Roles::ROLE_VIEWER)
 */
class PageController extends AbstractController
{
    /**
     * @Route("/list", name="rf_page")
     *
     *
     * @param Request $request
     * @param PageRepository $pageRepository
     * @param PaginatorInterface $paginator
     * @param SearchParams $searchParams
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request, PageRepository $pageRepository, PaginatorInterface $paginator, SearchParams $searchParams)
    {

        $searchParams->setCurrentSector('pagelist');
        $pagination = $paginator->paginate(
            $pageRepository->getWithSearchQueryBuilder($searchParams),
            $request->query->getInt('page', 1),
            1/*limit per page*/
        );


        $pagesPublished = $pageRepository->findBy(['published'=>true]);
        $pagesCreatedThisMonth = $pageRepository->findPagesCreatedByMonth();
        $totalPages = $pageRepository->findAll();
        return $this->render('page/list.html.twig', [
            'totalPages' => $totalPages,
            'pagesCreatedThisMonth' => $pagesCreatedThisMonth,
            'pagesPublished' => $pagesPublished,
            'pagination' => $pagination
        ]);
    }

}
