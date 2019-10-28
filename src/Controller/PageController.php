<?php

namespace App\Controller;

use App\Entity\Block;
use App\Entity\Page;
use App\Enums\Roles;
use App\Form\Type\ContentType\BaseContentType;
use App\Form\Type\PageType;
use App\Repository\BlockRepository;
use App\Repository\LayoutRepository;
use App\Repository\PageRepository;
use App\Service\BlockManager;
use App\Service\CTManager;
use App\Service\LayoutManager;
use App\Service\ObjectRelationManager;
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
 * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_VIEWER)
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
    public function view(Request $request, Page $page, $tab = 'blocks', BlockRepository $blockRepository, RfMessages $rfMessages, CTManager $CTManager, BlockManager $blockManager)
    {

        $twig = 'page/view.html.twig';
        if (!$page->getPublished()) {
            $twig = 'page/view_draft.html.twig';
            if ($tab == 'contents') {
                $twig = 'page/view_draft_contents.html.twig';
            }

        }

        $blocks = $blockManager->getPageBlocksBySlots($page);

        if (
            $request->isMethod('POST') && $request->request->get('page_block_orders', false)
        ) {
            $json = $request->request->get('page_block_orders', false);
            $slots = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $beforeUpdate = $blockManager->getPageBlocks($page);
            $toRemove = [];

            foreach ($beforeUpdate as $block) {
                if (!$this->isPresentInSlots($block->getId(),$slots)) {
                    $toRemove[] = $block;
                }
            }

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

            foreach ($toRemove as $block) {
                $em->remove($block);
            }
            $em->flush();

            $rfMessages->addSuccess("We have successfully modified this page.");

            return $this->redirectToRoute('rf_page_view',array_merge(['id'=>$page->getId(), 'tab'=>'contents'],$rfMessages->getMessages()));
        }

        foreach ($blockManager->getPageBlocks($page) as $block) {
            /**
             * @var Block $block
             */
            if (!is_null($blockManager->getContentType($block)->getRouteParams())) {
                $blockParams = $blockManager->getContentType($block)->getRouteParams();
                $pageRouteParams = $page->getRouteParams();
                if (strpos($pageRouteParams, $blockParams) === false) {
                    //route params not present
                    $rfMessages->addWarning("Please add ".$blockParams." in your Page's Route Parameters");
                }
            }
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
     * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)
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
                return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$page->getId()],$rfMessages->getMessages()));
            }
        }

        return $this->render('page/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="rf_page_edit")
     * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)
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
                return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$page->getId()],$rfMessages->getMessages()));
            }
        }

        return $this->render('page/add.html.twig', [
            'form' => $form->createView(),
            'editPage' => true
        ]);
    }

    /**
     *
     * @Route("/publish/{id}", name="rf_page_publish")
     * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)
     *
     * @param Request $request
     * @param Page $page
     * @param RfMessages $rfMessages
     * @param PageManager $pageManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function publish(Request $request, Page $page, RfMessages $rfMessages,PageManager $pageManager)
    {

        if ($page->getPublished()) {
            $rfMessages->addWarning('"'.$page->getName() . "\" is already PUBLISHED.");

            return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$page->getId()],$rfMessages->getMessages()));
        }

        //check if the page has a published version
        if ($currentlyPublished = $pageManager->getPublishedPageByDraftPage($page)) {
            $pageManager->deletePage($currentlyPublished);
        }

        $duplicatedPage = $pageManager->duplicatePage($page);

        if ($pageManager->publishPage($duplicatedPage)) {
            $rfMessages->addSuccess("This page has been successfully published.");
            $rfMessages->addInfo("Don't forget to add it in the menu, only if you want to ;)");
        }

        return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$duplicatedPage->getId()],$rfMessages->getMessages()));
    }

    /**
     *
     * @Route("/create-draft/{id}", name="rf_page_createdraft")
     * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)
     *
     * @param Request $request
     * @param Page $page
     * @param RfMessages $rfMessages
     * @param PageManager $pageManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function createDraft(Request $request, Page $page, RfMessages $rfMessages,PageManager $pageManager)
    {

        if ($duplicatedPage = $pageManager->duplicatePage($page)) {
            $rfMessages->addSuccess("Draft version generated successfully.");
        }

        return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$duplicatedPage->getId()],$rfMessages->getMessages()));
    }


    /**
     * @Route("/delete/{id}", name="rf_page_delete")
     * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)
     * @param Request $request
     * @param RfMessages $rfMessages
     * @param PageManager $pageManager
     * @return mixed
     */
    public function delete(Request $request, Page $page, RfMessages $rfMessages,PageManager $pageManager)
    {
        $route = $page->getRoute();

        if ($pageManager->deletePage($page)) {
            $rfMessages->addSuccess($page->getName() . " has been deleted successfully.");
            if ($pageManager->isRouteExist($route)) {
                if ($redirectedPage = $pageManager->getDraftPageByRoute($route)) {
                    $rfMessages->addInfo("We have redirected you to the draft version of the page.");
                } else {
                    if ($redirectedPage = $pageManager->getPublishedPageByRoute($route)) {
                        $rfMessages->addInfo("We have redirected you to the published version of the page.");
                    }
                }

                return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$redirectedPage->getId()],$rfMessages->getMessages()));
            }

        }

        return $this->redirectToRoute('rf_page', $rfMessages->getMessages());
    }

    /**
     * @Route("/duplicate/{id}", name="rf_page_duplicate")
     * @IsGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)
     * @param Request $request
     * @param RfMessages $rfMessages
     * @param PageManager $pageManager
     * @param LayoutManager $layoutManager
     * @return mixed
     */
    public function duplicate(Request $request, Page $page, RfMessages $rfMessages,PageManager $pageManager, LayoutManager $layoutManager)
    {

        $exName = $page->getName();
        $exRoute = $page->getRoute();

        $page->setName('');
        $page->setRoute('');

        $form = $this->createForm(PageType::class, $page, ['clone_mode' => true]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Page $page
             */
            $page = $form->getData();
            if ("/" !== substr($page->getRoute(), 0, 1)) {
                $page->setRoute("/".$page->getRoute());
            }


            if (!$pageManager->isRouteExist($page->getRoute())) {
                $duplicatedPage = $pageManager->duplicatePage($page);

                $page->setName($exName);
                $page->setRoute($exRoute);
                $this->getDoctrine()->getManager()->flush();

                $rfMessages->addSuccess("Here you are! We have put the new page in draft version by default.");

                return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$duplicatedPage->getId()],$rfMessages->getMessages()));
            } else {
                $rfMessages->addError("The URL already exists");
            }
        }

        return $this->render('page/add.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
            'clonePage' => true
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
     * @Route("/view_list/{id}", name="rf_page_viewlist")
     *
     */
    public function blockViewList(Request $request, Block $block, CTManager $CTManager)
    {

        $code = $block->getContentType();

        $checked = "KO";
        $ct = $CTManager->getContentTypeByCode($code);
        if ($ct != null) {
            $checked = $ct->getViewList(['allow_buttons'=> true,'block'=>$block, 'ct'=>$ct]);
        }

        return new Response($checked);
    }

    /**
     * @Route("/view_detail/{id}", name="rf_page_viewdetail")
     *
     * @param Block $block
     * @param CTManager $CTManager
     * @return Response
     */
    public function blockViewDetail(Block $block, CTManager $CTManager)
    {
        $code = $block->getContentType();

        $checked = "KO";
        $ct = $CTManager->getContentTypeByCode($code);
        if ($ct != null) {
            $checked = $ct->getViewDetail(['block'=>$block, 'ct'=>$ct]);
        }

        return new Response($checked);
    }


    /**
     * @Route("/view_properties/{page}/{block}", name="rf_page_viewproperties")
     *
     *
     * @param Request $request
     * @param Page $page
     * @param Block $block
     * @param BlockManager $blockManager
     * @return mixed
     */
    public function blockViewProperties(Request $request,Page $page, Block $block, BlockManager $blockManager, RfMessages $rfMessages, ObjectRelationManager $objectRelationManager)
    {
        $defaultData = array_merge(['roles'=>$block->getRoles()], $block->getProperties());
        $objectRelationManager->tansformRelationsBeforePost($block, $defaultData);

        $form = $blockManager->getContentType($block)->getForm($defaultData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $objectRelationManager->tansformRelationsAfterPost($block, $data);
            $params = ['roles'=>$data['roles']];
            unset($data['roles']);
            $params['properties'] = $data;

            $blockManager->updateBlock($block, $params);

            $objectRelationManager->handleRelations($block, $params['properties']);

            $rfMessages->addSuccess("The block has been modified successfully.");
            return $this->redirectToRoute('rf_page_view', array_merge(['id'=>$page->getId(), 'tab'=>'contents'],$rfMessages->getMessages()));
        }

        return $this->render('page/view_properties.html.twig', [
            'form' => $form->createView(),
            'page'=>$page,
            'block' => $block
        ]);

    }



    protected function isPresentInSlots($presence, $slots)
    {
        foreach ($slots as $slot) {
            if (in_array($presence, $slot)) {
                return true;
            }
        }

        return false;
    }

}
