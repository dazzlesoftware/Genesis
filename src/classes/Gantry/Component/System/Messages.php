<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\System;

/**
 * Class Messages
 * @package Gantry\Component\System
 */
class Messages
{
    protected $messages = [];

    /**
     * @param string $message
     * @param string $type
     * @return $this
     */
    public function add($message, $type = 'warning')
    {
        $this->messages[] = ['type' => $type, 'message' => $message];

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->messages;
    }

    /**
     * @return $this
     */
    public function clean()
    {
        $this->messages = [];

        return $this;
    }
}
