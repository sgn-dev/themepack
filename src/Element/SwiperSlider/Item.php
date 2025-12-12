<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Element\SwiperSlider;

use Contao\FilesModel;
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
        $this->setBackendFrontendFlags();

        $container = \Contao\System::getContainer();
        $projectDir = $container->getParameter('kernel.project_dir');

        $objModel = FilesModel::findByUuid($this->tp_singleSRC);

        if (null !== $objModel && is_file($projectDir . '/' . $objModel->path)) {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addThemePackImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }

        if(null !== $this->tp_vidSrcMp4)
        {
            $this->tp_vidSrcMp4 = $this->addFilePathToTemplate($this->tp_vidSrcMp4, $this->Template, 'tp_vidSrcMp4' );
        }

        if(null !== $this->tp_vidSrcWebM)
        {
            $this->tp_vidSrcWebM = $this->addFilePathToTemplate($this->tp_vidSrcWebM, $this->Template, 'tp_vidSrcWebM');
        }
    }
}
