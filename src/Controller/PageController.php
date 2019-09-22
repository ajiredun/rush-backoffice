<?php

namespace App\Controller;

use App\Enums\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function list()
    {


        return $this->render('page/list.html.twig', [
        ]);
    }

}
