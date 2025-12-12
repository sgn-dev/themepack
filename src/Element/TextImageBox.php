<?php
/**
 * 47GN THEMEPACK for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Sgn47gradnord\Themepack\Element;


use Contao\FilesModel;
use Contao\StringUtil;
use Sgn47gradnord\Themepack\ContaoHelper;

class TextImageBox extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_textimagebox';

    /**
     * Compile the Element.
     */
    protected function compile()
    {
        $this->setBackendFrontendFlags();

        $this->Template->tp_text = StringUtil::encodeEmail($this->tp_text);

        $container = \Contao\System::getContainer();
        $projectDir = $container->getParameter('kernel.project_dir');

        $objModel = FilesModel::findByUuid($this->tp_singleSRC);

        if (null !== $objModel && is_file($projectDir . '/' . $objModel->path)) {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addThemePackImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }
    }
}