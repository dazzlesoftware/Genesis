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
 * Adds scripts to head/footer/custom location.
 *
 * {% scripts in 'head' with { priority: 2 } %}
 *   <script type="text/javascript" src="{{ url('gantry-theme://js/my.js') }}"></script>
 * {% endscripts -%}
 */
class TokenParserScripts extends TokenParserAssets
{
    /**
     * @param Token $token
     * @return bool
     */
    public function decideBlockEnd(Token $token)
    {
        return $token->test('endscripts');
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'scripts';
    }
}
