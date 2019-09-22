<?php

namespace App\Controller;

use App\Enums\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/{type}", name="rf_media")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function index($type)
    {
        $instanceFiles = 'files_viewer';
        $instanceGallery = 'gallery_viewer';

        if ($this->isGranted(Roles::ROLE_MEDIA_MANAGEMENT_EDITOR)) {
            $instanceFiles = 'files';
            $instanceGallery = 'gallery';
        }

        if ($type=="files") {
            return $this->redirectToRoute('elfinder', ['instance' => $instanceFiles]);
        }

        if ($type=="gallery") {
            return $this->redirectToRoute('elfinder', ['instance' => $instanceGallery]);
        }

        return $this->redirectToRoute('rf_dashboard', [ 'rfwarning' => 'Invalid instance of Finder']);
    }

}
