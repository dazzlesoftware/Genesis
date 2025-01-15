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
include __DIR__ . '/style.php';
?>

<div class="g5i">
    <h1>
        <span class="g5-title"><?php echo $name; ?> Updated</span>
        <span class="g5-info">v<?php echo $version; ?> / <?php echo $date; ?></span>
    </h1>

    <div class="g5-actions">
        <a href="<?php echo $edit_url; ?>" class="g5-button">Configure <?php echo $name; ?> <span class="g5-icon icon-chevron-right"></span></a>
    </div>

    <div class="g5-rockettheme">
        <a href="http://rockettheme.com"><span>RocketTheme</span></a>
    </div>
</div>