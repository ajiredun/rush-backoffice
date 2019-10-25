<?php

namespace App\Controller\Object;

use App\Entity\ObjectMenu;
use App\Enums\Roles;
use App\Form\Type\Objects\MenuType;
use App\Repository\ObjectMenuRepository;
use App\Repository\PageRepository;
use App\Service\RfMessages;
use App\Service\SearchParams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/object/menu")
 * @IsGranted(Roles::ROLE_OBJECT_MENU_VIEWER)
 */
class MenuController extends AbstractController
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param SearchParams $searchParams
     * @param ObjectMenuRepository $objectMenuRepository
     * @return mixed
     *
     * @Route("/list", name="rf_object_menu_list")
     */
    public function list(Request $request, PaginatorInterface $paginator, SearchParams $searchParams, ObjectMenuRepository $objectMenuRepository)
    {

        $searchParams->setCurrentSector('object_menu_list');

        $pagination = $paginator->paginate(
            $objectMenuRepository->getWithSearchQueryBuilder($searchParams),
            $request->query->getInt('page', 1),
            20/*limit per page*/
        );

        return $this->render('objects/menu/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }


    /**
     * @param Request $request
     * @param ObjectMenu $objectMenu
     *
     * @Route("/menu-{id}", name="rf_object_menu_view")
     */
    public function view(Request $request, ObjectMenu $objectMenu)
    {

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @IsGranted(Roles::ROLE_OBJECT_MENU_EDITOR)
     * @Route("/add", name="rf_object_menu_add")
     */
    public function add(Request $request, PageRepository $pageRepository)
    {
        $menu = new ObjectMenu();
        $form = $this->createForm(MenuType::class, $menu);




        $pages = $pageRepository->findBy(['published'=>true]);
        return $this->render('objects/menu/add.html.twig', [
            'pages' => $pages
        ]);
    }

    /**
     * @param Request $request
     * @param ObjectMenu $objectMenu
     *
     * @Route("/edit/menu-{id}", name="rf_object_menu_edit")
     */
    public function edit(Request $request, ObjectMenu $objectMenu)
    {

    }
}