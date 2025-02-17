<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

/**
 * Palettes.
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['tp_headerbar'] = '
{title_legend},name,type;
{logo_legend},tp_singleSRC,tp_size;
{include_legend},tp_includeModule;
{protected_legend:hide},protected;
{template_legend:hide},customTpl;
{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['tp_footerbar'] = '
{title_legend},name,type;
{include_legend},tp_includeModule;
{config_legend},tp_showSocialMedia;
{protected_legend:hide},protected;
{template_legend:hide},customTpl;
{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['tp_pagetitle'] = '
{title_legend},name,type;
{include_legend},tp_includeModule;
{protected_legend:hide},protected;
{template_legend:hide},customTpl;
{expert_legend:hide},guests,cssID,space';
/*
 * Fields
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['tp_singleSRC'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['tp_singleSRC'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'],
    'sql' => 'binary(16) NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['tp_size'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['tp_size'],
    'exclude' => true,
    'inputType' => 'imageSize',
    'reference' => &$GLOBALS['TL_LANG']['MSC'],
    'eval' => ['rgxp' => 'natural', 'includeBlankOption' => true, 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'],
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    },
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['tp_includeModule'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['tp_includeModule'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['Sgn47gradnord\Themepack\Backend\Callback', 'getModule'],
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['tp_showSocialMedia'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['tp_showSocialMedia'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
];
