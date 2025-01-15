<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;

/**
 * Gantry 5 Nucleus installer script.
 */
class Gantry5_NucleusInstallerScript
{
    /**
     * @param InstallerAdapter $parent
     * @return bool
     */
    public function uninstall($parent)
    {
        // Remove all Nucleus files manually as file installer only uninstalls files.
        $manifest = $parent->getManifest();

        // Loop through all elements and get list of files and folders
        foreach ($manifest->fileset->files as $eFiles) {
            $target = (string) $eFiles->attributes()->target;
            $targetFolder = empty($target) ? JPATH_ROOT : JPATH_ROOT . '/' . $target;

            // Check if all children exists
            if (count($eFiles->children()) > 0) {
                // Loop through all filenames elements
                foreach ($eFiles->children() as $eFileName) {
                    if ($eFileName->getName() === 'folder')
                    {
                        $folder = $targetFolder . '/' . $eFileName;

                        $files = Folder::files($folder, '.', false, true);
                        foreach ($files as $name) {
                            File::delete($name);
                        }
                        $subFolders = Folder::folders($folder, '.', false, true);
                        foreach ($subFolders as $name) {
                            Folder::delete($name);
                        }
                    }
                }
            }
        }

        return true;
    }
}
