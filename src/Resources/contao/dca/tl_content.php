<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

/*
 * Callbacks.
 */
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = ['Sgn47gradnord\Themepack\Backend\Callback', 'onsubmitCallbackTlContent'];

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_swiperslider_start'] = '{type_legend},type;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_swiperslider_item'] = '{type_legend},type;{image_legend},tp_singleSRC,tp_size;{slidercontent_legend},tp_sliderHeadline,tp_sliderContent;{forward_legend},tp_forward;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_container_start'] = '{type_legend},type;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_section_start'] = '{type_legend},type;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_featurebox'] = '{type_legend},type;{featurebox_legend},tpfeatureboxtype;{column_legend},tp_numberColumns,tp_lastColumn;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_textbox'] = '{type_legend},type, headline;{text_legend},tp_text;{forward_legend},tp_forward;{column_legend},tp_numberColumns,tp_lastColumn;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_imagebox'] = '{type_legend},type;{image_legend},tp_singleSRC,tp_size;{column_legend},tp_numberColumns,tp_lastColumn;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_gallerybox'] = '{type_legend},type,headline;{source_legend},multiSRC,sortBy;{image_legend},tp_size;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_parallaxbox'] = '{type_legend},type,headline,tp_subHeadline;{image_legend},tp_singleSRC,tp_size;{forward_legend},tp_forward;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_dividerbuttonbox'] = '{type_legend},type;{text_legend},tp_dividerButtonText;{forward_legend},tp_forward;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tp_headlinebox'] = '{type_legend},type,headline,tp_subHeadline;{expert_legend:hide},guests,cssID,space;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

/*
 * Sub Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tp_addImage'] = 'tp_singleSRC,tp_size';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tpfeatureboxtype_tpstandard'] = 'headline,tp_subHeadline;{image_legend},tp_singleSRC,tp_size;{text_legend},tp_text;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tpfeatureboxtype_tpicon'] = 'headline,tp_icon;{text_legend},tp_text;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tpfeatureboxtype_tpimage'] = 'headline,tp_subHeadline;{image_legend},tp_singleSRC,tp_size;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tpfeatureboxtype_tptext'] = 'headline,tp_subHeadline;{text_legend},tp_text;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tp_forward'] = 'url,titleText';


/*
 * Selectoren
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'tp_addImage';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'tpfeatureboxtype';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'tp_forward';

/*
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
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'],
    'sql' => 'binary(16) NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_size'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_size'],
    'exclude' => true,
    'inputType' => 'imageSize',
    'reference' => &$GLOBALS['TL_LANG']['MSC'],
    'eval' => ['rgxp' => 'natural', 'includeBlankOption' => true, 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'],
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    },
    'sql' => "varchar(64) NOT NULL default ''",
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
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => ['rte' => 'tinyMCE', 'helpwizard' => true],
    'explanation' => 'insertTags',
    'sql' => 'mediumtext NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tpfeatureboxtype'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tpfeatureboxtype'],
    'default' => 'tpstandard',
    'exclude' => true,
    'filter' => true,
    'inputType' => 'radio',
    'options' => [
        'tpstandard' => 'Standard',
        'tpicon' => 'Icon',
        'tpimage' => 'Bild',
        'tptext' => 'Text'
    ],
    'eval' => ['submitOnChange' => true, 'helpwizard' => true],
    'sql' => "varchar(12) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_icon'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_icon'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_forward'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_forward'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tp_dividerButtonText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tp_dividerButtonText'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];
