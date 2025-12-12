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


class Dividerbuttonbox extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_dividerbuttonbox';

    /**
     * Compile the Element.
     */
    protected function compile()
    {
        $this->setBackendFrontendFlags();
    }
}