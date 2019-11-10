<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Element\SwiperSlider;

use Contao\ContentModel;
use Sgn47gradnord\Themepack\Element\AbstractElement;

class Stop extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_swiperslider_stop';

    private $showNavigation = false;

    /**
     * Compile the Element.
     */
    protected function compile()
    {
        $items = ContentModel::findBy(['type=? AND pid=? AND invisible =?'], ['tp_swiperslider_item', $this->pid, '']);

        if(null !== $items)
        {
            if(count($items) > 1)
            {
                $this->showNavigation = true;
            }

        }
        $this->Template->showNavigation = $this->showNavigation;
    }
}
