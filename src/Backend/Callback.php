<?php
/**
 * 47GN THEMEPACK for Contao Open Source CMS
 *
 * Copyright (C) 2018 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Sgn47gradnord\Themepack\Backend;


use Contao\Model\Collection;
use Contao\ModuleModel;

class Callback
{
    /**
     * @return array|void
     */
    public function getModule()
    {
        $choises = [];

        /** @var Collection $results */
        $results = ModuleModel::findAll();

        if (null === $results) {
            return;
        }

        /** @var ModuleModel $result */
        foreach ($results as $result) {
            $choises[$result->id] = $result->name;
        }

        return $choises;
    }
}