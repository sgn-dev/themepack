<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Element;

use Contao\FilesModel;
use Contao\PageModel;
use Contao\StringUtil;
use Sgn47gradnord\Themepack\ContaoHelper;

class Featurebox extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_featurebox';

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

        if($this->tp_jumpTo) {
            $objPage = PageModel::findOneBy('id', $this->tp_jumpTo);
            if ($objPage) {
                $this->Template->tp_jumpTo = $objPage->getFrontendUrl();
            }
        }
    }
}
