<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack\Backend;

use Contao\DataContainer;
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

    /**
     * @param DataContainer $dc
     */
    public function onsubmitCallbackTlContent(DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;
        if (!$activeRecord || 'auto' === \Input::post('SUBMIT_TYPE')) {
            return;
        }

        // Element Container
        if ('tp_container_start' === $activeRecord->type) {
            // Find the next columns or column element
            $nextElement = \Database::getInstance()
                ->prepare('
					SELECT type
					FROM tl_content
					WHERE pid = ?
						AND (ptable = ? OR ptable = ?)
						AND type IN (\'tp_container_stop\')
						AND sorting > ?
					ORDER BY sorting ASC
					LIMIT 1
				')
                ->execute(
                    $activeRecord->pid,
                    $activeRecord->ptable ?: 'tl_article',
                    'tl_article' === $activeRecord->ptable ? '' : $activeRecord->ptable,
                    $activeRecord->sorting
                );

            // Check if a stop element should be created
            if (!$nextElement->type) {
                \Database::getInstance()
                    ->prepare('INSERT INTO tl_content %s')
                    ->set([
                        'pid' => $activeRecord->pid,
                        'ptable' => $activeRecord->ptable ?: 'tl_article',
                        'type' => 'tp_container_stop',
                        'sorting' => $activeRecord->sorting + 1,
                        'tstamp' => time(),
                    ])
                    ->execute();
            }
        }

        // Element Section
        if ('tp_section_start' === $activeRecord->type) {
            // Find the next columns or column element
            $nextElement = \Database::getInstance()
                ->prepare('
					SELECT type
					FROM tl_content
					WHERE pid = ?
						AND (ptable = ? OR ptable = ?)
						AND type IN (\'tp_section_stop\')
						AND sorting > ?
					ORDER BY sorting ASC
					LIMIT 1
				')
                ->execute(
                    $activeRecord->pid,
                    $activeRecord->ptable ?: 'tl_article',
                    'tl_article' === $activeRecord->ptable ? '' : $activeRecord->ptable,
                    $activeRecord->sorting
                );

            // Check if a stop element should be created
            if (!$nextElement->type) {
                \Database::getInstance()
                    ->prepare('INSERT INTO tl_content %s')
                    ->set([
                        'pid' => $activeRecord->pid,
                        'ptable' => $activeRecord->ptable ?: 'tl_article',
                        'type' => 'tp_section_stop',
                        'sorting' => $activeRecord->sorting + 1,
                        'tstamp' => time(),
                    ])
                    ->execute();
            }
        }
    }
}
