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
        $this->Template->tp_text = StringUtil::encodeEmail($this->tp_text);
        $objModel = FilesModel::findByUuid($this->tp_singleSRC);

        if (null !== $objModel && is_file(TL_ROOT . '/' . $objModel->path)) {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addThemePackImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }

        if($this->tp_jumpTo) {
            $this->Template->tp_jumpTo = PageModel::findOneBy('id', $this->tp_jumpTo)->getFrontendUrl();
        }
    }
}
