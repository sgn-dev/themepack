<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

/*
 * Content Elements
 */
$GLOBALS['TL_CTE']['themepack-elements'] = [
    'tp_container_start' => 'Sgn47gradnord\Themepack\Element\ContainerStart',
    'tp_container_stop' => 'Sgn47gradnord\Themepack\Element\ContainerStop',
    'tp_featurebox' => 'Sgn47gradnord\Themepack\Element\Featurebox',
];

/*
 * Swiper Slider
 */
$GLOBALS['TL_CTE']['themepack-swiperslider'] = [
    'tp_swiperslider_start' => 'Sgn47gradnord\Themepack\Element\SwiperSlider\Start',
    'tp_swiperslider_item' => 'Sgn47gradnord\Themepack\Element\SwiperSlider\Item',
    'tp_swiperslider_stop' => 'Sgn47gradnord\Themepack\Element\SwiperSlider\Stop',
];

/*
 * Wrappers
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'tp_swiperslider_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'tp_swiperslider_stop';

$GLOBALS['TL_WRAPPERS']['start'][] = 'tp_container_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'tp_container_stop';

/*
 * Frontend Modules
 */
$GLOBALS['FE_MOD']['themepack'] = [
    'tp_headerbar' => 'Sgn47gradnord\Themepack\Module\Headerbar',
];

/*
 * Constants Themepack - Number of Columns
 */
$GLOBALS['THEMEPACK']['numberColumns'] = [
    'col_full' => 'Einspaltig',
    'col_half' => '2-spaltig',
    'col_one_third' => '3-spaltig',
    'col_one_fourth' => '4-spaltig',
    'col_one_fifth' => '5-spaltig',
    'col_one_sixth' => '6-spaltig',
];
