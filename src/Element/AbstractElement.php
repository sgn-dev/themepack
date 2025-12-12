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
    protected function setBackendFrontendFlags()
    {
        // Set backend/frontend flag for templates
        $container = \Contao\System::getContainer();
        $scopeMatcher = $container->get('contao.routing.scope_matcher');
        $request = $container->get('request_stack')->getCurrentRequest();

        if ($request && $scopeMatcher->isBackendRequest($request)) {
            $this->Template->isBackend = true;
            $this->Template->isFrontend = false;
        } else {
            $this->Template->isBackend = false;
            $this->Template->isFrontend = true;
        }
    }

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
