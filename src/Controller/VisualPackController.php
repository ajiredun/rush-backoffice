<?php

namespace App\Controller;

use App\Entity\VisualPack;
use App\Enums\Roles;
use App\Form\Type\VisualPackType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/visual-pack")
 * @IsGranted(Roles::ROLE_VIEWER)
 */
class VisualPackController extends AbstractController
{
    /**
     * @Route("/list", name="rf_visualpack")
     */
    public function list()
    {


        return $this->render('visual_pack/list.html.twig', [
        ]);
    }

    /**
     * @Route("/structure", name="rf_visualpack_structure")
     */
    public function structure()
    {


        return $this->render('visual_pack/structure.html.twig', [
        ]);
    }

    /**
     * @Route("/add", name="rf_visualpack_add")
     */
    public function add(Request $request)
    {
        $visualPack = new VisualPack();
        $form = $this->createForm(VisualPackType::class, $visualPack);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $visualPack = $form->getData();
            dd($visualPack);
        }

        return $this->render('visual_pack/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
