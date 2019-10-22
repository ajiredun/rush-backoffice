<?php


namespace App\ContentType\Base;


use App\Enums\CTCategory;
use App\Form\Type\ContentType\BaseContentType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;

abstract class AbstractContentType implements ContentTypeInterface
{
    const CODE = "CT_ABSTRACT_CONTENT_TYPE";

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    public function __construct(Environment $twig, FormFactoryInterface $formFactory)
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
    }

    public abstract function getLabel();

    public function getCode()
    {
        return static::CODE;
    }

    public function getRouteParams()
    {
        return null;
    }

    public function getCategory()
    {
        return CTCategory::DEFAULT;
    }

    public function getForm(array $data)
    {
        $formName = "App\\Form\\Type\\ContentType\\".$this->getClassName()."Type";

        try {
            $form = $this->createForm($formName, $data);
        } catch(\Exception $e) {
            $form = $this->createForm(BaseContentType::class, $data);
        }

        return $form;
    }

    public function getViewList($params = [])
    {
        $class = $this->getClassName();
        return $this->twig->render("content_types/$class/list.html.twig", array_merge($params, ['ct'=>$this]));
    }

    public function getViewDetail($params = [])
    {
        $class = $this->getClassName();
        return $this->twig->render("content_types/$class/detail.html.twig", array_merge($params, ['ct'=>$this]));
    }

    public function getViewListImage()
    {
        $class = $this->getClassName();
        return "assets/content_types/$class.jpg";
    }

    public function getDependencies()
    {
        /*return [
            'MenuCT',
            'HalfImageHalfTextCT'
        ];*/

        return [];
    }


    /*public function getProperty($property)
    {
        if (!empty($this->getProperties()) && isset($this->getProperties()[$property])) {
             return $this->getProperties()[$property];
        }

        return null;
    }*/

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    protected function createForm($type, $data = null, array $options = array())
    {
        return $this->formFactory->create($type, $data, $options);
    }

}