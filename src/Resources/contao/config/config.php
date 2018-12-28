<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

/**
 * Content Elements
 */
$GLOBALS['TL_CTE']['themepack-elements']['test'] = 'ThemepackBundle\Frontend\Element\TextIntroduction';

/**
 * Frontend Modules
 */
$GLOBALS['FE_MOD']['themepack'] = [
    'tp_headerbar'         => 'ThemepackBundle\Module\Headerbar'
];