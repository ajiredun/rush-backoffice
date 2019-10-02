<?php


namespace App\Service;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class CTManager
{
    protected $contentTypes;
    protected $contentTypesCategorised;

    public function __construct(iterable $contentTypes)
    {
        $categorised = CTCategory::getList();
        $array = [];
        foreach ($contentTypes as $ct) {
            /**
             * @var AbstractContentType $ct
             */
            $categorised[$ct->getCategory()]['list'][] = $ct;
            $array[] = $ct;
        }
        $this->contentTypes = $array;
        $this->contentTypesCategorised = $categorised;
    }


    /**
     * @param $code
     * @return AbstractContentType|null
     */
    public function getContentTypeByCode($code)
    {
        foreach ($this->contentTypes as $ct) {
            if ($ct->getCode() == $code) {
                return $ct;
            }
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getContentTypes()
    {
        return $this->contentTypes;
    }

    /**
     * @param mixed $contentTypes
     */
    public function setContentTypes($contentTypes): void
    {
        $this->contentTypes = $contentTypes;
    }

    /**
     * @return array
     */
    public function getContentTypesCategorised(): array
    {
        return $this->contentTypesCategorised;
    }

    /**
     * @param array $contentTypesCategorised
     */
    public function setContentTypesCategorised(array $contentTypesCategorised): void
    {
        $this->contentTypesCategorised = $contentTypesCategorised;
    }
}