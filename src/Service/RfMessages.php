<?php

namespace App\Service;


class RfMessages
{
    protected $messages;

    public function __construct()
    {
        $this->messages = [
            'success' => [],
            'info' => [],
            'error' => [],
            'warning' => []
        ];
    }

    public function addSuccess($message)
    {
        $this->messages['success'][]= $message;
    }

    public function addInfo($message)
    {
        $this->messages['info'][]= $message;
    }

    public function addWarning($message)
    {
        $this->messages['warning'][]= $message;
    }

    public function addError($message)
    {
        $this->messages['error'][]= $message;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}