<?php

declare(strict_types=1);

/*
 * Themepack - to produce Websites using Theme, 47GradNord - Agentur für Internetlösungen  ThemepackBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Themepack;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FilesModel;
use Contao\Frontend;
use Contao\Image\PictureConfigurationInterface;
use Contao\PageModel;
use League\Uri\Http;

class ContaoHelper extends Frontend
{
    /**
     * @param object          $objTemplate
     * @param array           $arrItem
     * @param null            $intMaxWidth
     * @param null            $strLightboxId
     * @param FilesModel|null $objModel
     */
    public static function addImageToTemplate($objTemplate, $arrItem, $intMaxWidth = null, $strLightboxId = null, FilesModel $objModel = null)
    {
        try {
            $objFile = new \File($arrItem['tp_singleSRC']);
        } catch (\Exception $e) {
            $objFile = null;
        }

        $imgSize = $objFile ? $objFile->imageSize : false;
        $size = \StringUtil::deserialize($arrItem['tp_size']);

        if (is_numeric($size)) {
            $size = [0, 0, (int) $size];
        } elseif (!$size instanceof PictureConfigurationInterface) {
            if (!\is_array($size)) {
                $size = [];
            }

            $size += [0, 0, 'crop'];
        }

        if (null === $intMaxWidth) {
            $intMaxWidth = \Config::get('maxImageWidth');
        }

        $arrMargin = (TL_MODE === 'BE') ? [] : \StringUtil::deserialize($arrItem['imagemargin']);

        // Store the original dimensions
        $objTemplate->width = $imgSize[0];
        $objTemplate->height = $imgSize[1];

        // Adjust the image size
        if ($intMaxWidth > 0) {
            @trigger_error('Using a maximum front end width has been deprecated and will no longer work in Contao 5.0. Remove the "maxImageWidth" configuration and use responsive images instead.', E_USER_DEPRECATED);

            // Subtract the margins before deciding whether to resize (see #6018)
            if (\is_array($arrMargin) && 'px' === $arrMargin['unit']) {
                $intMargin = (int) $arrMargin['left'] + (int) $arrMargin['right'];

                // Reset the margin if it exceeds the maximum width (see #7245)
                if ($intMaxWidth - $intMargin < 1) {
                    $arrMargin['left'] = '';
                    $arrMargin['right'] = '';
                } else {
                    $intMaxWidth -= $intMargin;
                }
            }

            if (\is_array($size) && ($size[0] > $intMaxWidth || (!$size[0] && !$size[1] && (!$imgSize[0] || $imgSize[0] > $intMaxWidth)))) {
                // See #2268 (thanks to Thyon)
                $ratio = ($size[0] && $size[1]) ? $size[1] / $size[0] : (($imgSize[0] && $imgSize[1]) ? $imgSize[1] / $imgSize[0] : 0);

                $size[0] = $intMaxWidth;
                $size[1] = floor($intMaxWidth * $ratio);
            }
        }

        try {
            $container = \System::getContainer();
            $staticUrl = $container->get('contao.assets.files_context')->getStaticUrl();
            $picture = $container->get('contao.image.picture_factory')->create(TL_ROOT . '/' . $arrItem['tp_singleSRC'], $size);

            $picture = [
                'img' => $picture->getImg(TL_ROOT, $staticUrl),
                'sources' => $picture->getSources(TL_ROOT, $staticUrl),
            ];

            $src = $picture['img']['src'];

            if ($src !== $arrItem['tp_singleSRC']) {
                $objFile = new \File(rawurldecode($src));
            }
        } catch (\Exception $e) {
            \System::log('Image "' . $arrItem['tp_singleSRC'] . '" could not be processed: ' . $e->getMessage(), __METHOD__, TL_ERROR);

            $src = '';
            $picture = ['img' => ['src' => '', 'srcset' => ''], 'sources' => []];
        }

        // Image dimensions
        if ($objFile && $objFile->exists() && false !== ($imgSize = $objFile->imageSize)) {
            $objTemplate->arrSize = $imgSize;
            $objTemplate->imgSize = ' width="' . $imgSize[0] . '" height="' . $imgSize[1] . '"';
        }

        $arrMeta = [];

        // Load the meta data
        if ($objModel instanceof FilesModel) {
            if (TL_MODE === 'FE') {
                global $objPage;

                $arrMeta = \Frontend::getMetaData($objModel->meta, $objPage->language);

                if (empty($arrMeta) && null !== $objPage->rootFallbackLanguage) {
                    $arrMeta = \Frontend::getMetaData($objModel->meta, $objPage->rootFallbackLanguage);
                }
            } else {
                $arrMeta = \Frontend::getMetaData($objModel->meta, $GLOBALS['TL_LANGUAGE']);
            }

            \Controller::loadDataContainer('tl_files');

            // Add any missing fields
            foreach (array_keys($GLOBALS['TL_DCA']['tl_files']['fields']['meta']['eval']['metaFields']) as $k) {
                if (!isset($arrMeta[$k])) {
                    $arrMeta[$k] = '';
                }
            }

            $arrMeta['imageTitle'] = $arrMeta['title'];
            $arrMeta['imageUrl'] = $arrMeta['link'];
            unset($arrMeta['title'], $arrMeta['link']);

            // Add the meta data to the item
            if (!$arrItem['overwriteMeta']) {
                foreach ($arrMeta as $k => $v) {
                    switch ($k) {
                        case 'alt':
                        case 'imageTitle':
                            $arrItem[$k] = \StringUtil::specialchars($v);
                            break;
                        default:
                            $arrItem[$k] = $v;
                            break;
                    }
                }
            }
        }

        $picture['alt'] = \StringUtil::specialchars($arrItem['alt']);

        // Move the title to the link tag so it is shown in the lightbox
        if (($arrItem['fullsize'] || $arrItem['imageUrl']) && $arrItem['imageTitle'] && !$arrItem['linkTitle']) {
            $arrItem['linkTitle'] = $arrItem['imageTitle'];
            unset($arrItem['imageTitle']);
        }

        if (isset($arrItem['imageTitle'])) {
            $picture['title'] = \StringUtil::specialchars($arrItem['imageTitle']);
        }

        $objTemplate->picture = $picture;

        // Provide an ID for single lightbox images in HTML5 (see #3742)
        if (null === $strLightboxId && $arrItem['fullsize']) {
            $strLightboxId = substr(md5($objTemplate->getName() . '_' . $arrItem['id']), 0, 6);
        }

        // Float image
        if ($arrItem['floating']) {
            $objTemplate->floatClass = ' float_' . $arrItem['floating'];
        }

        // Do not override the "href" key (see #6468)
        $strHrefKey = ('' !== $objTemplate->href) ? 'imageHref' : 'href';

        // Image link
        if ($arrItem['imageUrl'] && TL_MODE === 'FE') {
            $objTemplate->$strHrefKey = $arrItem['imageUrl'];
            $objTemplate->attributes = '';

            if ($arrItem['fullsize']) {
                // Open images in the lightbox
                if (preg_match('/\.(jpe?g|gif|png)$/', $arrItem['imageUrl'])) {
                    // Do not add the TL_FILES_URL to external URLs (see #4923)
                    if (0 !== strncmp($arrItem['imageUrl'], 'http://', 7) && 0 !== strncmp($arrItem['imageUrl'], 'https://', 8)) {
                        $objTemplate->$strHrefKey = static::addFilesUrlTo(\System::urlEncode($arrItem['imageUrl']));
                    }

                    $objTemplate->attributes = ' data-lightbox="' . $strLightboxId . '"';
                } else {
                    $objTemplate->attributes = ' target="_blank"';
                }
            }
        }

        // Fullsize view
        elseif ($arrItem['fullsize'] && TL_MODE === 'FE') {
            $objTemplate->$strHrefKey = static::addFilesUrlTo(\System::urlEncode($arrItem['singleSRC']));
            $objTemplate->attributes = ' data-lightbox="' . $strLightboxId . '"';
        }

        // Add the meta data to the template
        foreach (array_keys($arrMeta) as $k) {
            $objTemplate->$k = $arrItem[$k];
        }

        // Do not urlEncode() here because getImage() already does (see #3817)
        $objTemplate->tp_src = static::addFilesUrlTo($src);
        $objTemplate->tp_singleSRC = $arrItem['tp_singleSRC'];
        $objTemplate->linkTitle = \StringUtil::specialchars($arrItem['linkTitle'] ?: $arrItem['title']);
        $objTemplate->fullsize = $arrItem['fullsize'] ? true : false;
        $objTemplate->addBefore = ('below' !== $arrItem['floating']);
        $objTemplate->margin = static::generateMargin($arrMargin);
        $objTemplate->addImage = true;
    }

    /**
     * @param int|null $jumpTo
     * @param string   $params
     * @param string   $queryString
     *
     * @return string
     */
    public static function createUrl(int $jumpTo = null, string $params = '', $queryString = ''): string
    {
        $container = \System::getContainer();

        $request = $container->get('request_stack')->getCurrentRequest();
        $url = $request->getSchemeAndHttpHost() . $request->getBaseUrl() . $request->getPathInfo();

        if (null !== $jumpTo) {
            /** @var ContaoFrameworkInterface $framework */
            $framework = $container->get('contao.framework');

            /** @var PageModel|null $pageModel */
            $pageModel = $framework->getAdapter(PageModel::class)->findByPk($jumpTo);

            if (null === $pageModel) {
                return '';
            }

            $url = $pageModel->getAbsoluteUrl($params);
        } else {
            if ('' !== $params) {
                $url .= '/' . $params;
            }
        }

        if ('' !== $queryString) {
            $uri = Http::createFromString($url);
            $newQuery = $uri->query->merge($queryString);

            return (string) $uri->withQuery((string) $newQuery);
        }

        return $url;
    }

    /**
     * @return string
     */
    public static function getRootPageUrl()
    {
        global $objPage;

        return static::createUrl((int) $objPage->rootId);
    }
}
