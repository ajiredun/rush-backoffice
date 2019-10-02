<?php


namespace App\ContentType\Base;


use App\Enums\CTCategory;
use App\Enums\CTProperty;
use Symfony\Component\Form\Form;
use Twig\Environment;

abstract class AbstractContentType implements ContentTypeInterface
{
    const CODE = "CT_ABSTRACT_CONTENT_TYPE";

    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public abstract function getLabel();

    public function getCode()
    {
        return static::CODE;
    }

    public function getCategory()
    {
        return CTCategory::DEFAULT;
    }

    public function getForm()
    {
        return null;
    }

    public function getProperties()
    {
        return [];
    }

    public function setProperties(Form $form)
    {
        // TODO: Implement setProperties() method.
    }

    public function getViewList()
    {
        $class = $this->getClassName();
        return $this->twig->render("content_types/$class/list.html.twig", ['ct'=>$this]);
    }

    public function getViewDetail()
    {
        $class = $this->getClassName();
        return $this->twig->render("content_types/$class/detail.html.twig", ['ct'=>$this]);
    }

    public function getViewListImage()
    {
        $class = $this->getClassName();
        return "assets/content_types/$class.jpg";
    }

    public function getDependencies()
    {
        return $this->getProperty(CTProperty::DEPENDENCIES);
    }

    /**
     * @param $property
     * @return mixed|null
     */
    public function getProperty($property)
    {
        if (!empty($this->getProperties()) && isset($this->getProperties()[$property])) {
             return $this->getProperties()[$property];
        }

        return null;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

}