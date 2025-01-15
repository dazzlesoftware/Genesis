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

use Gantry\Component\Twig\Node\TwigNodeMarkdown;
use Twig\Error\SyntaxError;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Adds ability to inline markdown between tags.
 *
 * {% markdown %}
 * This is **bold** and this _underlined_
 *
 * 1. This is a bullet list
 * 2. This is another item in that same list
 * {% endmarkdown %}
 */
class TokenParserMarkdown extends AbstractTokenParser
{
    /**
     * @param Token $token
     * @return TwigNodeMarkdown
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideMarkdownEnd'], true);
        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
        return new TwigNodeMarkdown($body, $lineno, $this->getTag());
    }
    /**
     * Decide if current token marks end of Markdown block.
     *
     * @param Token $token
     * @return bool
     */
    public function decideMarkdownEnd(Token $token)
    {
        return $token->test('endmarkdown');
    }
    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'markdown';
    }
}
