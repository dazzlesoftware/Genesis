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
        <span class="g5-title"><?php echo $name; ?> Installed</span>
        <span class="g5-info">v<?php echo $version; ?> / <?php echo $date; ?></span>
    </h1>

    <p>
        Thank you for choosing Gantry 5 Template Framework!
        <br>
        The next step is to install a Gantry 5 template. For more information, please read the <a href="http://docs.gantry.org/gantry5/basics/installation">documentation</a>.
    </p>

    <div class="g5-rockettheme">
        <a href="http://rockettheme.com"><span>RocketTheme</span></a>
    </div>
</div>
