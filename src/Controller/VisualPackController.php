<?php

namespace App\Controller;

use App\Entity\Layout;
use App\Entity\VisualPack;
use App\Enums\Roles;
use App\Form\Type\LayoutType;
use App\Form\Type\VisualPackType;
use App\Repository\LayoutRepository;
use App\Repository\VisualPackRepository;
use App\Service\RfMessages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/visual-pack")
 * @IsGranted(Roles::ROLE_VISUAL_PACK_VIEWER)
 */
class VisualPackController extends AbstractController
{
    /**
     * @Route("/list", name="rf_visualpack")
     */
    public function list(VisualPackRepository $visualPackRepository)
    {
        $list = $visualPackRepository->findBy([],['active'=>'DESC']);


        return $this->render('visual_pack/list.html.twig', [
            'list' => $list
        ]);
    }

    /**
     * @Route("/structure/{id}", name="rf_visualpack_structure")
     */
    public function structure(LayoutRepository $layoutRepository, $id = null)
    {
        $layout = null;
        if (!is_null($id)) {
            $layout = $layoutRepository->find($id);
        }


        return $this->render('visual_pack/structure.html.twig', [
            'layout' => $layout
        ]);
    }

    /**
     * @Route("/add", name="rf_visualpack_add")
     * @IsGranted(Roles::ROLE_VISUAL_PACK_EDITOR)
     */
    public function add(Request $request, RfMessages $rfMessages)
    {
        $visualPack = new VisualPack();
        $form = $this->createForm(VisualPackType::class, $visualPack);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $visualPack = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($visualPack);
            $entityManager->flush($visualPack);

            $rfMessages->addSuccess($visualPack->getTitle() . ' has been created successfully');

            return $this->redirectToRoute('rf_visualpack');
        }

        return $this->render('visual_pack/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add-layout/{visualPack}", name="rf_visualpack_add_layout")
     * @IsGranted(Roles::ROLE_VISUAL_PACK_EDITOR)
     */
    public function addLayout(Request $request,VisualPack $visualPack, RfMessages $rfMessages)
    {
        $layout = new Layout();
        $layout->setVisualPack($visualPack);
        $form = $this->createForm(LayoutType::class, $layout);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $layout = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($layout);
            $entityManager->flush($layout);

            $rfMessages->addSuccess($layout->getTitle() . ' has been created successfully');

            return $this->redirectToRoute('rf_visualpack');
        }

        return $this->render('visual_pack/add_layout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activate/{visualPack}", name="rf_visualpack_activate")
     * @IsGranted(Roles::ROLE_VISUAL_PACK_EDITOR)
     */
    public function activate(Request $request,VisualPack $visualPack, VisualPackRepository $visualPackRepository, RfMessages $rfMessages)
    {
        $list = $visualPackRepository->findAll();
        foreach ($list as $vp) {
            $vp->setActive(false);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $visualPack->setActive(true);
        $entityManager->flush();


        $rfMessages->addSuccess($visualPack->getTitle() . ' has been activated successfully');
        return $this->redirectToRoute('rf_visualpack');
    }

}
