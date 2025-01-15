<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Framework;

/**
 * Class Exception
 * @package Gantry\Framework
 */
class Exception extends \RuntimeException
{
    protected $responseCodes = [
        200 => '200 OK',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        410 => '410 Gone',
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        503 => '503 Service Temporarily Unavailable'
    ];

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return isset($this->responseCodes[$this->code]) ? (int) $this->code : 500;
    }

    /**
     * @return string
     */
    public function getResponseStatus()
    {
        return $this->responseCodes[$this->getResponseCode()];
    }
}
