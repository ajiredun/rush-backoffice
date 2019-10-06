<?php

namespace App\Controller;

use App\Enums\Roles;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/finder-{type}", name="rf_media")
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

    /**
     * @Route("/tinyMedia", name="rf_media_selector")
     */
    public function tinyMediaForm()
    {
        $form = $this->createFormBuilder()
            ->add('media',
                ElFinderType::class,
                [
                    'instance' => 'gallery_viewer',
                    'label' => 'Media',
                    'enable' => true,
                    'attr' => array(
                        'readOnly' => 'true',
                        'placeholder' => 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    )
                ]
            )
            ->getForm();

        return $this->render('media/tinyImage.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/tinyFile", name="rf_file_selector")
     */
    public function tinyFileForm()
    {
        $form = $this->createFormBuilder()
            ->add('file',
                ElFinderType::class,
                [
                    'instance'=>'files_viewer',
                    'label' => 'File',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-file-form-type',
                        'required' => 'true'
                    )
                ]
            )
            ->getForm();

        return $this->render('media/tinyFile.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
