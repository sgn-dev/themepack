<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Element;

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\FrontendTemplate;

abstract class AbstractElement extends ContentElement
{

    protected function addFilePathToTemplate(string $uuid, FrontendTemplate $template, string $parameter)
    {
        /** @var FilesModel $model */
        $model = FilesModel::findByUuid($uuid);

        if(null === $model)
        {
            return null;
        }

        $template->$parameter = $model->path;
    }
}
