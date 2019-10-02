<?php

namespace App\Controller;

use App\Entity\Block;
use App\Entity\Page;
use App\Enums\Roles;
use App\Form\Type\PageType;
use App\Repository\BlockRepository;
use App\Repository\LayoutRepository;
use App\Repository\PageRepository;
use App\Service\CTManager;
use App\Service\LayoutManager;
use App\Service\PageManager;
use App\Service\RfMessages;
use App\Service\SearchParams;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/page")
 * @IsGranted(Roles::ROLE_VIEWER)
 */
class PageController extends AbstractController
{

    /**
     *
     * @Route("/page-{id}/{tab}", name="rf_page_view")
     * @param Request $request
     * @param Page $page
     * @param string $tab
     * @param BlockRepository $blockRepository
     * @param RfMessages $rfMessages
     * @param CTManager $CTManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function view(Request $request, Page $page, $tab = 'blocks', BlockRepository $blockRepository, RfMessages $rfMessages, CTManager $CTManager)
    {

        $twig = 'page/view.html.twig';
        if (!$page->getPublished()) {
            $twig = 'page/view_draft.html.twig';
            if ($tab == 'contents') {
                $twig = 'page/view_draft_contents.html.twig';
            }

        }

        $blocks = [];
        $pageBlocks = $blockRepository->findOrderedBlocks($page);
        foreach ($pageBlocks as $block) {
            /**
             * @var Block $block
             */
            if (array_key_exists($block->getSlot(),$blocks)) {
                $blocks[$block->getSlot()][] = $block;
            } else {
                $blocks = array_merge($blocks,[$block->getSlot()=>[$block]]);
            }
        }

        if (
            $request->isMethod('POST') && $request->request->get('page_block_orders', false)
        ) {
            $json = $request->request->get('page_block_orders', false);
            $slots = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            foreach ($slots as $slot=>$blocks)
            {
                foreach ($blocks as $order => $block)
                {
                    if (substr( $block, 0, 3 ) === "CT_") {
                        //new block
                        $b = new Block();
                        $b->setPage($page);
                        $b->setLastModifiedBy($this->getUser());
                        $b->setBlockOrder($order);
                        $b->setContentType($block);
                        $b->setSlot($slot);

                        $em->persist($b);
                        $em->flush();
                    } else {
                        $b = $blockRepository->find(intval($block));
                        if ($b) {
                            $b->setBlockOrder($order);
                            $b->setLastModifiedAt(new \DateTime('now'));
                            $b->setLastModifiedBy($this->getUser());
                            $b->setSlot($slot);
                            $em->flush();
                        } else {
                            $rfMessages->addError("We can't find a block with the following information: ". $block);
                        }
                    }
                }
            }
            $rfMessages->addSuccess("We have successfully modified this page.");

            return $this->redirectToRoute('rf_page_view',array_merge(['id'=>$page->getId(), 'tab'=>'contents'],$rfMessages->getMessages()));
        }


        //get content list
        $contentTypeList = $CTManager->getContentTypesCategorised();

        return $this->render($twig, [
            'page' => $page,
            'contentTypeList' => $contentTypeList,
            'tab' => $tab,
            'blocks' => $blocks
        ]);
    }




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
            30/*limit per page*/
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



    /**
     * @Route("/add", name="rf_page_add")
     *
     * @param Request $request
     * @param RfMessages $rfMessages
     * @param PageManager $pageManager
     * @param LayoutManager $layoutManager
     * @return mixed
     */
    public function create(Request $request, RfMessages $rfMessages,PageManager $pageManager, LayoutManager $layoutManager)
    {

        $page = new Page();
        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Page $page
             */
            $page = $form->getData();
            if ("/" !== substr($page->getRoute(), 0, 1)) {
                $page->setRoute("/".$page->getRoute());
            }

            if ($pageManager->createPage($page)) {
                $rfMessages->addSuccess($page->getName() . " has been created successfully");
                return $this->redirectToRoute('rf_page', $rfMessages->getMessages());
            }
        }

        return $this->render('page/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="rf_page_edit")
     *
     * @param Request $request
     * @param RfMessages $rfMessages
     * @param PageManager $pageManager
     * @param LayoutManager $layoutManager
     * @return mixed
     */
    public function edit(Request $request, Page $page, RfMessages $rfMessages,PageManager $pageManager, LayoutManager $layoutManager)
    {

        if ($page->getPublished()) {
            $rfMessages->addWarning('"'.$page->getName() . "\" is currently PUBLISHED. You cannot change the properties of a published page.");
            $draft = $pageManager->getDraftPageByPublishedPage($page);
            if ($draft) {
                $rfMessages->addInfo("We have redirected you to the DRAFT version of the PUBLISHED page.");

                return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$draft->getId()],$rfMessages->getMessages()));
            }

            return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$page->getId()],$rfMessages->getMessages()));
        }

        $form = $this->createForm(PageType::class, $page, ['edit_mode' => true]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Page $page
             */
            $page = $form->getData();
            if ("/" !== substr($page->getRoute(), 0, 1)) {
                $page->setRoute("/".$page->getRoute());
            }

            if ($pageManager->updatePage($page)) {
                $rfMessages->addSuccess($page->getName() . " has been created modified");
                return $this->redirectToRoute('rf_page', $rfMessages->getMessages());
            }
        }

        return $this->render('page/add.html.twig', [
            'form' => $form->createView(),
            'editPage' => true
        ]);
    }


    /**
     *
     * @Route("/check-route/{route}", name="rf_page_routecheck")
     *
     */
    public function checkRoute(Request $request, $route = null, PageManager $pageManager)
    {
        $checked = "OK";

        if (is_null($route)) {
            $checked = "You should fill in the path.";
        } else {
            $route = "/" . $route;

            if (!is_null($route)) {
                if (!$pageManager->isRouteValid($route)) {
                    $checked = "Invalid Path";
                } else {
                    if ($pageManager->isRouteExist($route)) {
                        $checked = "This path already exists.";
                    }
                }
            }
        }

        return new Response($checked);
    }

    /**
     *
     * @Route("/view_list/{code}", name="rf_page_viewlist")
     *
     */
    public function getBlockViewList(Request $request, $code = null, CTManager $CTManager)
    {
        $checked = "KO";
        $ct = $CTManager->getContentTypeByCode($code);
        if ($ct != null) {
            $checked = $ct->getViewList();
        }

        return new Response($checked);
    }

}
