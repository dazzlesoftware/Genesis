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

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Component\Menus\Administrator\Model\ItemModel; // Joomla 4
use Joomla\Component\Menus\Administrator\Table\MenuTable; // Joomla 4
use Joomla\Component\Menus\Administrator\Table\MenuTypeTable; // Joomla 4

/**
 * Joomla style helper.
 */
class MenuHelper
{
    /**
     * @param int|array|null $id
     * @return \JTableMenu|MenuTable
     */
    public static function getMenu($id = null)
    {
        $model = static::loadModel();
        $table = $model->getTable();

        if (null !== $id) {
            if (!is_array($id)) {
                $id = ['id' => $id, 'client_id' => 0];
            }

            $table->load($id);
        }

        return $table;
    }

    /**
     * @param int|array|null $id
     * @return \JTableMenuType|MenuTypeTable
     */
    public static function getMenuType($id = null)
    {
        $model = static::loadModel();
        $table = $model->getTable('MenuType');
        if (!$table) {
            // Joomla 3 support.
            $table = Table::getInstance('MenuType');
        }

        if (null !== $id) {
            if (!is_array($id)) {
                $id = ['menutype' => $id];
            }

            $table->load($id);
        }

        return $table;
    }

    /**
     * @param string $name
     * @return ItemModel|\MenusModelItem
     */
    private static function loadModel($name = 'Item')
    {
        static $model = [];

        if (!isset($model[$name])) {
            if (version_compare(JVERSION, '4', '<')) {
                // Joomla 3 support.
                $path = JPATH_ADMINISTRATOR . '/components/com_menus/';
                $filename = strtolower($name);
                $className = "\\MenusModel{$name}";

                Table::addIncludePath(JPATH_LIBRARIES . '/legacy/table/');
                Table::addIncludePath("{$path}/tables");
                require_once "{$path}/models/{$filename}.php";

                /** @var CMSApplication $application */
                $application = Factory::getApplication();

                // Load language strings.
                $language = $application->getLanguage();
                $language->load('com_menus');

                // Load the model.
                $model[$name] = new $className();
            } else {
                // Joomla 4 support.
                $application = Factory::getApplication();
                $model[$name] = $application->bootComponent('com_menus')
                    ->getMVCFactory()
                    ->createModel($name, 'Administrator', ['ignore_request' => true]);
            }
        }

        return $model[$name];
    }
}
