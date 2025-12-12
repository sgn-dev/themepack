<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Module;

use Contao\FilesModel;
use Sgn47gradnord\Themepack\ContaoHelper;

class Headerbar extends AbstractModule
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_tp_headerbar';

    /**
     * @return string
     */
    public function generate()
    {
        $container = \Contao\System::getContainer();
        $scopeMatcher = $container->get('contao.routing.scope_matcher');
        $request = $container->get('request_stack')->getCurrentRequest();

        if ($request && $scopeMatcher->isBackendRequest($request)) {
            return $this->generateWildcard();
        }

        return parent::generate();
    }

    /**
     * Compile the Module.
     */
    protected function compile()
    {
        $container = \Contao\System::getContainer();
        $projectDir = $container->getParameter('kernel.project_dir');

        $objModel = FilesModel::findByUuid($this->tp_singleSRC);

        if (null !== $objModel && is_file($projectDir . '/' . $objModel->path)) {
            $this->tp_singleSRC = $objModel->path;
            ContaoHelper::addThemePackImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
        }

        $this->Template->rootPage = ContaoHelper::getRootPageUrl();
    }
}
