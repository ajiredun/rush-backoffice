<?php

namespace App\Controller\Object;

use App\Entity\ObjectCategory;
use App\Entity\ObjectProduct;
use App\Entity\Page;
use App\Enums\Roles;
use App\Form\Type\Objects\CategoryType;
use App\Form\Type\Objects\ProductType;
use App\Repository\BlockRepository;
use App\Repository\ObjectCategoryRepository;
use App\Service\BlockManager;
use App\Service\CTManager;
use App\Service\RfMessages;
use App\Service\SearchParams;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/object/product")
 * @IsGranted(Roles::ROLE_OBJECT_PRODUCT_VIEWER)
 */
class ProductController extends AbstractController
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param SearchParams $searchParams
     * @param ObjectCategoryRepository $objectCategoryRepository
     * @return mixed
     *
     * @Route("/list", name="rf_object_product_list")
     */
    public function list(Request $request, PaginatorInterface $paginator, SearchParams $searchParams, ObjectCategoryRepository $objectCategoryRepository)
    {

        $searchParams->setCurrentSector('product');

        $pagination = $paginator->paginate(
            $objectCategoryRepository->getWithSearchQueryBuilder($searchParams),
            $request->query->getInt('page', 1),
            20/*limit per page*/
        );

        return $this->render('objects/product/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param Request $request
     * @param RfMessages $rfMessages
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     *
     * @IsGranted(Roles::ROLE_OBJECT_PRODUCT_EDITOR)
     * @Route("/add", name="rf_object_product_add")
     *
     */
    public function add(Request $request, RfMessages $rfMessages, EntityManagerInterface $em)
    {
        $object = new ObjectProduct();
        $object->setLastModifiedBy($this->getUser());

        $form = $this->createForm(ProductType::class, $object);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var ObjectProduct $object
             */
            $object = $form->getData();
            $object->setLastModifiedAt(new \DateTime('now'));

            $em->persist($object);
            $em->flush();

            $rfMessages->addSuccess($object->getName() . " has been created successfully");
            return $this->redirectToRoute('rf_object_product_view', array_merge(['id'=>$object->getId()],$rfMessages->getMessages()));
        }

        return $this->render('objects/product/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/category-{id}", name="rf_object_category_view")
     *
     * @param Request $request
     * @param ObjectCategory $object
     * @param RfMessages $rfMessages
     */
    public function view(Request $request,ObjectCategory $object, RfMessages $rfMessages)
    {
        return $this->render('objects/category/view.html.twig', [
            'object' => $object
        ]);
    }

    /**
     * @Route("/edit/category-{id}", name="rf_object_product_edit")
     * @IsGranted(Roles::ROLE_OBJECT_PRODUCT_EDITOR)
     *
     * @param Request $request
     * @param ObjectCategory $object
     * @param RfMessages $rfMessages
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function edit(Request $request, ObjectCategory $object, RfMessages $rfMessages, EntityManagerInterface $em)
    {
        $object->setLastModifiedBy($this->getUser());

        $form = $this->createForm(CategoryType::class, $object);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var ObjectCategory $object
             */
            $object = $form->getData();
            $object->setLastModifiedAt(new \DateTime('now'));

            $em->flush();

            $rfMessages->addSuccess($object->getName() . " has been updated successfully");
            return $this->redirectToRoute('rf_object_category_view', array_merge(['id'=>$object->getId()],$rfMessages->getMessages()));
        }

        return $this->render('objects/category/add.html.twig', [
            'form' => $form->createView(),
            'editMode' => true
        ]);
    }
}