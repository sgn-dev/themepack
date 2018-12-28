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


use Sgn47gradnord\Themepack\ContaoHelper;

class Headerbar extends AbstractModule
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_tp_headerbar';

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
     * Compile the Module
     */
    protected function compile()
    {
        $objModel = \FilesModel::findByUuid($this->tp_singleSRC);

        if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
        {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }

        $this->Template->rootPage = ContaoHelper::getRootPageUrl();
    }
}