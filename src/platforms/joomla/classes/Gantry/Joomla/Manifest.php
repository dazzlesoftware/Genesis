<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Joomla;

/**
 * Joomla manifest file modifier.
 */
class Manifest
{
    /** @var string */
    protected $theme;
    /** @var string */
    protected $path;
    /** @var \SimpleXMLElement */
    protected $xml;

    /**
     * @param string $theme
     * @param \SimpleXMLElement $manifest
     * @throws \RuntimeException
     */
    public function __construct($theme, \SimpleXMLElement $manifest = null)
    {
        $this->theme = $theme;
        $this->path = JPATH_SITE . "/templates/{$theme}/templateDetails.xml";

        if (!is_file($this->path)) {
            throw new \RuntimeException(sprintf('Template %s does not exist.', $theme));
        }
        $this->xml = $manifest ?: simplexml_load_string(file_get_contents($this->path));
    }

    /**
     * @param string $variable
     * @return string
     */
    public function get($variable)
    {
        return (string) $this->xml->{$variable};
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @return string
     */
    public function getScriptFile()
    {
        return (string) $this->xml->scriptfile;
    }

    /**
     * @param array $positions
     */
    public function setPositions(array $positions)
    {
        sort($positions);

        // Get the positions.
        $target = current($this->xml->xpath('//positions'));

        $xml = "<positions>\n        <position>" . implode("</position>\n        <position>", $positions) . "</position>\n    </positions>";
        $insert = new \SimpleXMLElement($xml);

        // Replace all positions.
        $targetDom = dom_import_simplexml($target);
        $insertDom = $targetDom->ownerDocument->importNode(dom_import_simplexml($insert), true);
        $targetDom->parentNode->replaceChild($insertDom, $targetDom);
    }

    public function save()
    {
        // Do not save manifest if template has been symbolically linked.
        if (is_link(dirname($this->path))) {
            return;
        }

        if (!$this->xml->asXML($this->path)) {
            throw new \RuntimeException(sprintf('Saving manifest for %s template failed', $this->theme));
        }
    }
}
