<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Element;

class ContainerStart extends AbstractElement
{
    /**
     * @var string
     */
    protected $strTemplate = 'ce_tp_container_start';

    /**
     * Compile the Element.
     */
    protected function compile()
    {
        $this->setBackendFrontendFlags();
    }
}
