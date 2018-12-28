<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Module;

use Contao\BackendTemplate;
use Contao\Module;

abstract class AbstractModule extends Module
{
    /**
     * Generate wildcard template for backend output.
     *
     * @return string
     */
    protected function generateWildcard()
    {
        $objTemplate = new BackendTemplate('be_wildcard');

        $objTemplate->wildcard = '### ' . strtoupper($GLOBALS['TL_LANG']['FMD'][$this->type][0]) . ' ###';
        $objTemplate->title = $this->headline;
        $objTemplate->id = $this->id;
        $objTemplate->link = $this->name;
        $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

        return $objTemplate->parse();
    }
}
