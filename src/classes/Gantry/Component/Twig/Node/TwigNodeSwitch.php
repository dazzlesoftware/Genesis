<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Twig\Node;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Class TwigNodeSwitch
 * @package Gantry\Component\Twig\Node
 */
class TwigNodeSwitch extends Node
{
    /**
     * TwigNodeSwitch constructor.
     * @param Node $value
     * @param Node $cases
     * @param Node|null $default
     * @param int $lineno
     * @param string|null $tag
     */
    public function __construct(
        Node $value,
        Node $cases,
        Node $default = null,
        $lineno = 0,
        $tag = null
    ) {
        $nodes = ['value' => $value, 'cases' => $cases, 'default' => $default];
        $nodes = array_filter($nodes);

        parent::__construct($nodes, [], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Compiler $compiler A Twig Compiler instance
     */
    public function compile(Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('switch (')
            ->subcompile($this->getNode('value'))
            ->raw(") {\n")
            ->indent();

        /** @var Node $case */
        foreach ($this->getNode('cases') as $case) {
            if (!$case->hasNode('body')) {
                continue;
            }

            foreach ($case->getNode('values') as $value) {
                $compiler
                    ->write('case ')
                    ->subcompile($value)
                    ->raw(":\n");
            }

            $compiler
                ->write("{\n")
                ->indent()
                ->subcompile($case->getNode('body'))
                ->write("break;\n")
                ->outdent()
                ->write("}\n");
        }

        if ($this->hasNode('default')) {
            $compiler
                ->write("default:\n")
                ->write("{\n")
                ->indent()
                ->subcompile($this->getNode('default'))
                ->outdent()
                ->write("}\n");
        }

        $compiler
            ->outdent()
            ->write("}\n");
    }
}
