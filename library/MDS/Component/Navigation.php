<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category   Gc
 * @package    Library
 * @subpackage Component
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace MDS\Component;

use Gc\Document;
use Gc\Registry;

/**
 * Create Xml for \Zend\Navigation
 *
 * @category   Gc
 * @package    Library
 * @subpackage Component
 */
class Navigation
{
    /**
     * List of \Gc\Document\Model
     *
     * @var array
     */
    protected $documents;

    /**
     * Base path for urls
     *
     * @var string
     */
    protected $basePath = '/';

    /**
     * Request uri
     *
     * @var string
     */
     protected $requestUri;

    /**
     * Constructor, initialize documents
     *
     * @param integer $documentId Document id
     *
     * @return void
     */
    public function __construct($documentId = 0)
    {
        $documents = new Document\Collection();
        $documents->load($documentId);
        $this->documents  = $documents->getDocuments();
        $this->requestUri = Registry::get('Application')->getRequest()->getRequestUri();
    }

    /**
     * Set base path for urls
     *
     * @param string $path Path
     *
     * @return \Gc\Component\Navigation
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * Get base Path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Render navigation
     *
     * @param array  $documents Let of \Gc\Document\Model
     * @param string $parentUrl Parent url
     *
     * @return array
     */
    public function render(array $documents = null, $parentUrl = null)
    {
        $navigation = array();
        if ($documents === null && !is_null($this->documents)) {
            $documents = $this->documents;
        }

        foreach ($documents as $document) {
            $children = $document->getChildren();
            if ($document->isPublished()) {
                $data            = array();
                $data['label']   = $document->getName();
                $data['uri']     = $this->getBasePath()
                    . ($parentUrl !== null ? ltrim($parentUrl, '/') . '/' : '')
                    . $document->getUrlKey();
                $data['visible'] = $document->showInNav();
                $data['active']  = $data['uri'] == $this->requestUri;

                if (!empty($children) && is_array($children)) {
                    $data['pages'] = $this->render(
                        $children,
                        (empty($parentUrl) ? null : $parentUrl . '/') . $document->getUrlKey()
                    );
                }

                $navigation['document-' . $document->getId()] = $data;
            }
        }

        return $navigation;
    }
}
