<?php
/**
 * 47GN THEMEPACK for Contao Open Source CMS
 *
 * Copyright (C) 2018 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Sgn47gradnord\Themepack\Module;


class Pagetitle extends AbstractModule
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_tp_pagetitle';

    /**
     * @return string
     */
    public function generate()
    {
        if ('BE' === TL_MODE) {
            return $this->generateWildcard();
        }

        return parent::generate();
    }

    /**
     * Compile the Module.
     */
    protected function compile()
    {
        $this->Template->pageTitle = $this->getPageTitle();
    }
}