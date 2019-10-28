<?php

namespace App\Controller\Object;

use App\Entity\ObjectMenu;
use App\Enums\Roles;
use App\Form\Type\Objects\MenuType;
use App\Repository\ObjectMenuRepository;
use App\Repository\PageRepository;
use App\Service\RfMessages;
use App\Service\SearchParams;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/menu-{id}", name="rf_object_menu_view")
     */
    public function view(Request $request, ObjectMenu $objectMenu)
    {
        return $this->render('objects/menu/view.html.twig', [
            'object' => $objectMenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param PageRepository $pageRepository
     * @param RfMessages $rfMessages
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     *
     * @IsGranted(Roles::ROLE_OBJECT_MENU_EDITOR)
     * @Route("/add", name="rf_object_menu_add")
     *
     */
    public function add(Request $request, PageRepository $pageRepository, RfMessages $rfMessages, EntityManagerInterface $em)
    {
        $menu = new ObjectMenu();
        $menu->setLastModifiedBy($this->getUser());
        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var ObjectMenu $objectMenu
             */
            $objectMenu = $form->getData();
            $objectMenu->setLastModifiedAt(new \DateTime('now'));
            $em->persist($objectMenu);
            $em->flush();

            $rfMessages->addSuccess("Menu added successfully!");
            return $this->redirectToRoute('rf_object_menu_view', array_merge(['id'=>$objectMenu->getId()],$rfMessages->getMessages()));
        }

        $pages = $pageRepository->findBy(['published'=>true]);
        return $this->render('objects/menu/add.html.twig', [
            'pages' => $pages,
            'form' => $form->createView(),
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