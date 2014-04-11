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
 * @category   Gc_Library
 * @package    Modules
 * @subpackage Blog\Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace Blog\Controller;

use MDS\Module\Controller\AbstractController;

use Blog\Model;

/**
 * IndexController
 *
 * @category   Gc_Library
 * @package    Modules
 * @subpackage Blog\Controller
 */
class IndexController extends AbstractController
{
    /**
     * Fields white list
     *
     * @var array
     */
    protected $whiteList = array(
        'show_email',
        'is_active',
        'username',
        'email',
        'message',
        'document_id',
        'created_at'
    );

    /**
     * Index action, list all documents with comments
     *
     * @return array
     */
    public function indexAction()
    {
        
       // $model        = new Model\Comment();
        //$documentList = $model->getDocumentList();

        return array();
    }

    /**
     * List all comment by document id
     *
     * @return array
     */
    public function documentCommentAction()
    {
        $documentId = $this->params()->fromRoute('id');
        $document   = DocumentModel::fromId($documentId);
        if (empty($document)) {
            return $this->redirect()->toRoute('module/blog');
        }

        $model       = new Model\Comment();
        $commentList = $model->getList($documentId, null);

        if ($this->getRequest()->isPost()) {
            $comments = $this->getRequest()->getPost()->get('comment');

            foreach ($comments as $commentId => $data) {
                if (!empty($data['delete'])) {
                    $model->delete(array('id' => $commentId));
                    continue;
                }

                foreach ($data as $k => $v) {
                    if (!in_array($k, $this->whiteList)) {
                        unset($data[$k]);
                    }
                }

                $data['show_email'] = empty($data['show_email']) ? 0 : 1;
                $data['is_active']  = empty($data['is_active']) ? 0 : 1;
                $model->update($data, array('id' => $commentId));
            }

            return $this->redirect()->toRoute(
                'module/blog/document-comment',
                array(
                    'id' => $documentId,
                )
            );
        }

        return array('comment_list' => $commentList, 'document' => $document);
    }
}
