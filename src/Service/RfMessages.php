<?php

namespace App\Service;


class RfMessages
{
    protected $messages;

    public function __construct()
    {
        $this->messages = [
            'rfsuccess' => [],
            'rfinfo' => [],
            'rferror' => [],
            'rfwarning' => []
        ];
    }

    public function addSuccess($message)
    {
        $this->messages['rfsuccess'][]= $message;
    }

    public function addInfo($message)
    {
        $this->messages['rfinfo'][]= $message;
    }

    public function addWarning($message)
    {
        $this->messages['rfwarning'][]= $message;
    }

    public function addError($message)
    {
        $this->messages['rferror'][]= $message;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}