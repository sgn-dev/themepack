<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Element\SwiperSlider;

use Sgn47gradnord\Themepack\ContaoHelper;
use Sgn47gradnord\Themepack\Element\AbstractElement;

class Item extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_swiperslider_item';

    /**
     * Compile the Element.
     */
    protected function compile()
    {
        $objModel = \FilesModel::findByUuid($this->tp_singleSRC);

        if (null !== $objModel && is_file(TL_ROOT . '/' . $objModel->path)) {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }
    }
}
