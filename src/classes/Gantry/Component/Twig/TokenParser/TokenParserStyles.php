<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Twig\TokenParser;

use Twig\Token;

/**
 * Adds stylesheets to document.
 *
 * {% styles with { priority: 2 } %}
 *   <link rel="stylesheet" href="{{ url('gantry-assets://css/font-awesome.min.css') }}" type="text/css"/>
 * {% endstyles -%}
 */
class TokenParserStyles extends TokenParserAssets
{
    /**
     * @param Token $token
     * @return bool
     */
    public function decideBlockEnd(Token $token)
    {
        return $token->test('endstyles');
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'styles';
    }
}
