<?php
/**
 * 47GN THEMEPACK for Contao Open Source CMS
 *
 * Copyright (C) 2018 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_swiperslider_start'] = '{type_legend},type;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_swiperslider_item'] = '{type_legend},type;{image_legend},tp_singleSRC,tp_size;{slidercontent_legend},tp_sliderHeadline,tp_sliderContent;{forward_legend},urban_addButtonForward;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['tp_sliderHeadline'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_sliderHeadline'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_sliderContent'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_sliderContent'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_singleSRC'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_singleSRC'],
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr'),
    'sql'                     => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_size'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_size'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    },
    'sql'                     => "varchar(64) NOT NULL default ''"
];