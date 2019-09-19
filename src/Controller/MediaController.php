<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/{type}", name="rf_media")
     */
    public function index($type)
    {
        if ($type=="files") {
            //$this->redirectToRoute('rf_user_profile', ['id' => $user->getId(), 'rfsuccess' => $user->getName() . ' details has been updated successfully']);
        }
    }

}
