<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Config;

/**
 * Class ValidationException
 * @package Gantry\Component\Config
 */
class ValidationException extends \RuntimeException
{
    /** @var array */
    protected $messages = [];

    /**
     * @param array $messages
     * @return $this
     */
    public function setMessages(array $messages = [])
    {
        $this->messages = $messages;

        // TODO: add translation.
        $this->message = sprintf('Form validation failed:') . ' ' . $this->message;

        foreach ($messages as $variable => &$list) {
            $list = array_unique($list);
            foreach ($list as $message) {
                $this->message .= "<br/>$message";
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
