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
 * Callbacks
 */
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = ['Sgn47gradnord\Themepack\Backend\Callback', 'onsubmitCallbackTlContent'];

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_swiperslider_start'] = '{type_legend},type;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_swiperslider_item'] = '{type_legend},type;{image_legend},tp_singleSRC,tp_size;{slidercontent_legend},tp_sliderHeadline,tp_sliderContent;{forward_legend},urban_addButtonForward;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_container_start'] = '{type_legend},type;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_featurebox'] = '{type_legend},type,headline,tp_subHeadline;{image_legend},tp_addImage;{text_legend},tp_text;{column_legend},tp_numberColumns,tp_lastColumn;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

/*
 * Sub Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tp_addImage'] = 'tp_singleSRC,tp_size';

/*
 * Selectoren
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'tp_addImage';

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

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_addImage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_addImage'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'm12'],
    'sql' => "char(1) NOT NULL default ''",
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

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_subHeadline'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_subHeadline'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_numberColumns'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_numberColumns'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $GLOBALS['THEMEPACK']['numberColumns'],
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => "char(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_lastColumn'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_lastColumn'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_text'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_text'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'textarea',
    'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true),
    'explanation'             => 'insertTags',
    'sql'                     => "mediumtext NULL"
];