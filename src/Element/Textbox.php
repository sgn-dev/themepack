<?php
/**
 * 47GN THEMEPACK for Contao Open Source CMS
 *
 * Copyright (C) 2018 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Sgn47gradnord\Themepack\Element;


use Contao\StringUtil;

class Textbox extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_textbox';

    /**
     * Compile the Element.
     */
    protected function compile()
    {
        $this->setBackendFrontendFlags();

        $this->Template->tp_text = StringUtil::encodeEmail($this->tp_text);
    }
}