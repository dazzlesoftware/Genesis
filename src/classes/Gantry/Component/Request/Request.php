<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Request;

/**
 * Class Request
 * @package Gantry\Component\Request
 */
class Request
{
    /** @var string */
    protected $method;

    /** @var Input */
    public $get;
    /** @var Input */
    public $post;
    /** @var Input */
    public $cookie;
    /** @var Input */
    public $server;
    /** @var Input */
    public $request;

    public function __construct()
    {
        $this->init();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        if (!$this->method) {
            $method = $this->server['REQUEST_METHOD'] ?: 'GET';
            if ('POST' === $method) {
                $method = $this->server['X-HTTP-METHOD-OVERRIDE'] ?: $method;
                $method = $this->post['METHOD'] ?: $method;
            }
            $this->method = strtoupper($method);
        }

        return $this->method;
    }

    protected function init()
    {
        $this->get = new Input($_GET);
        $this->post = new Input($_POST);
        $this->cookie = new Input($_COOKIE);
        $this->server = new Input($_SERVER);
        $this->request = new Input($_REQUEST);
    }
}
