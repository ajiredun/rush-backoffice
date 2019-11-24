<?php

namespace App\Controller\Object;

use App\Entity\ObjectMenu;
use App\Enums\Roles;
use App\Form\Type\Objects\MenuType;
use App\Repository\ObjectMenuRepository;
use App\Repository\PageRepository;
use App\Service\ObjectRelationManager;
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

        $searchParams->setCurrentSector('menu');

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
     * @param ObjectRelationManager $objectRelationManager
     * @return mixed
     *
     * @Route("/menu-{id}", name="rf_object_menu_view")
     */
    public function view(Request $request, ObjectMenu $objectMenu, ObjectRelationManager $objectRelationManager)
    {
        $rfObjectRelations = null;

        if ($request->get('rfObjectRelations', false)) {
            $rfObjectRelations = $objectRelationManager->transformFromUrl($request->get('rfObjectRelations'));
        }
        //dd($rfObjectRelations);
        return $this->render('objects/menu/view.html.twig', [
            'object' => $objectMenu,
            'rfObjectRelations' => $rfObjectRelations
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

        //dd($request->request);

        if (
            $request->isMethod('POST') &&
            $request->request->get('my_menu_name', false) &&
            $request->request->get('my_menu_properties', false) &&
            $request->request->get('my_menu_html', false)
        ) {

            /**
             * @var ObjectMenu $menu
             */
            $menu->setProperties(json_decode($request->request->get('my_menu_properties')));
            $menu->setName($request->request->get('my_menu_name'));
            $menu->setMenuHTML($request->request->get('my_menu_html'));
            $menu->setLastModifiedAt(new \DateTime('now'));
            $em->persist($menu);
            $em->flush();

            $rfMessages->addSuccess("Menu added successfully!");
            return $this->redirectToRoute('rf_object_menu_view', array_merge(['id'=>$menu->getId()],$rfMessages->getMessages()));
        }

        $pages = $pageRepository->findBy(['published'=>true]);
        return $this->render('objects/menu/add.html.twig', [
            'pages' => $pages,
        ]);
    }

    /**
     * @param Request $request
     * @param ObjectMenu $menu
     * @param PageRepository $pageRepository
     * @param RfMessages $rfMessages
     * @param EntityManagerInterface $em
     *
     *
     * @Route("/edit/menu-{id}", name="rf_object_menu_edit")
     * @return mixed
     */
    public function edit(Request $request, ObjectMenu $menu, PageRepository $pageRepository, RfMessages $rfMessages, EntityManagerInterface $em)
    {

        $menu->setLastModifiedBy($this->getUser());


        if (
            $request->isMethod('POST') &&
            $request->request->get('my_menu_name', false) &&
            $request->request->get('my_menu_properties', false) &&
            $request->request->get('my_menu_html', false)
        ) {

            /**
             * @var ObjectMenu $menu
             */
            $menu->setProperties(json_decode($request->request->get('my_menu_properties')));
            $menu->setName($request->request->get('my_menu_name'));
            $menu->setMenuHTML($request->request->get('my_menu_html'));
            $menu->setLastModifiedAt(new \DateTime('now'));
            $em->flush();

            $rfMessages->addSuccess("Menu edit successfully!");
            return $this->redirectToRoute('rf_object_menu_view', array_merge(['id'=>$menu->getId()],$rfMessages->getMessages()));
        }


        $pages = $pageRepository->findBy(['published'=>true]);
        return $this->render('objects/menu/add.html.twig', [
            'editMode' => true,
            'object' => $menu,
            'pages' => $pages,
        ]);
    }


    /**
     * @param Request $request
     * @param ObjectMenu $objectMenu
     * @param RfMessages $rfMessages
     * @param EntityManagerInterface $em
     * @param ObjectRelationManager $objectRelationManager
     * @return mixed
     *
     * @Route("/delete/{id}", name="rf_object_menu_delete")
     *
     */
    public function delete(Request $request, ObjectMenu $objectMenu, RfMessages $rfMessages, EntityManagerInterface $em, ObjectRelationManager $objectRelationManager)
    {

        $relations = $objectRelationManager->objectHasRelation(ObjectMenu::class, $objectMenu->getId());

        if ($relations === false) {
            $em->remove($objectMenu);
            $em->flush();

            $rfMessages->addSuccess("Menu deleted successfully.");
            return $this->redirectToRoute('rf_object_menu_list', array_merge([],$rfMessages->getMessages()));
        }

        return $this->redirectToRoute('rf_object_menu_view', ['id'=>$objectMenu->getId(), 'rfObjectRelations'=>$objectRelationManager->transformForUrl($relations)]);
    }
}