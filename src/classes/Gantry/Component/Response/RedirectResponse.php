<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Response;

/**
 * Class RedirectResponse
 * @package Gantry\Component\Response
 */
class RedirectResponse extends Response
{
    /**
     * RedirectResponse constructor.
     * @param string $content
     * @param int $status
     */
    public function __construct($content = '', $status = 303)
    {
        parent::__construct('', $status);

        $this->setHeader('Location', $content);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return (string) $this->getHeaders()['Location'];
    }

    /**
     * @param string $content
     * @return Response
     */
    public function setContent($content)
    {
        $this->setHeader('Location', $content);

        return $this;
    }
}
