<?php


namespace App\ContentType\Base;


use Symfony\Component\Form\Form;

interface ContentTypeInterface
{
    public function getCode();

    public function getLabel();

    public function getCategory();

    public function getForm();

    public function getProperties();

    public function setProperties(Form $form);

    public function getViewList();

    public function getViewDetail();

    public function getDependencies();
}