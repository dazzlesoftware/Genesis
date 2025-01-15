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

use Gantry\Component\Twig\Node\TwigNodeThrow;
use Twig\Error\SyntaxError;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Handles try/catch in template file.
 *
 * <pre>
 * {% throw 404 'Not Found' %}
 * </pre>
 */
class TokenParserThrow extends AbstractTokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Token $token A Twig Token instance
     * @return Node A Twig Node instance
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $code = $stream->expect(Token::NUMBER_TYPE)->getValue();
        $message = $this->parser->getExpressionParser()->parseExpression();
        $stream->expect(Token::BLOCK_END_TYPE);

        return new TwigNodeThrow((int)$code, $message, $lineno, $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'throw';
    }
}
