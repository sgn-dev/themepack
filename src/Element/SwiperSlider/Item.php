<?php
/**
 * 47GN THEMEPACK for Contao Open Source CMS
 *
 * Copyright (C) 2018 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
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
     * Compile the Element
     */
    protected function compile()
    {
        $objModel = \FilesModel::findByUuid($this->tp_singleSRC);

        if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
        {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }
    }
}