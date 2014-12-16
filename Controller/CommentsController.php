<?php

/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class CommentsController extends AppController
{
    public $name = 'Comments';
    public $helpers = array('Text', 'Time');
    private $model, $refId;
	
    public function beforeFilter()
    {
        if (CakePlugin::loaded('GtwUsers')) {
            $this->layout = 'GtwUsers.users';
        }
        if (!empty($this->request->named['model'])) {
            $this->model = $this->request->named['model'];
        }
        if (!empty($this->request->named['ref_id'])) {
            $this->refId = $this->request->named['ref_id'];
        }
        $this->Auth->allow('get_comment');
    }

    public function index($type = NULL)
    {
        $this->paginate = $this->Comment->getData($type);
        $this->set('comments', $this->paginate('Comment'));
        $this->set('status', $this->Comment->status);
        $this->set('constStatus', $this->Comment->constStatus);
    }

    public function delete($commentId)
    {
        $arrResponse = array(
            'status' => 'fail',
            'message' => __('Unable to delete comment, Pleae try again'),
        );
        if ($this->Comment->delete($commentId)) {
            $arrResponse = array(
                'status' => 'success',
                'message' => __('Comment has been deleted'),
            );
        }
        if ($this->request->is('ajax')) {
            echo json_encode($arrResponse);
            exit;
        } else {
            $this->Session->setFlash($arrResponse['message'], 'alert', array(
                'plugin' => 'BoostCake',
                'class' => $arrResponse['status'] == 'fail' ? 'alert-danger' : 'alert-success'
            ));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function change_status($status, $commentId)
    {
        $arrStatus = array_flip($this->Comment->status);
        if (in_array($status, $arrStatus)) {
            $this->Comment->id = $commentId;
            $this->Comment->saveField('status', $arrStatus[$status]);
            $this->Session->setFlash(__('Comment status has been successfully changed to ' . $status), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-success'
            ));
        } else {
            $this->Session->setFlash(__('Invalid Type, Pleae try again'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function edit($commentId = 0)
    {
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('Comment has been updated successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(__('Unable to update comment, Pleae try again'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }
        } else {
            $this->Comment->recursive = -1;
            $this->request->data = $this->Comment->read(null, $commentId);
        }
        $this->set('status', $this->Comment->status);
    }

    public function get_comment($limit = 5)
    {
        $limit++;
        $this->layout = 'ajax';
        if (!empty($this->model)) {
            $conditions['Comment.model'] = $this->model;
        }
        if (!empty($this->refId)) {
            $conditions['Comment.ref_id'] = $this->refId;
        }        
        $conditions['Comment.status'] = $this->Comment->constStatus['Approved'];
        $fields = array(
            'Comment.id',
            'Comment.user_id',
            'Comment.comment',
            'Comment.created',
            'User.id',
            'User.first',
            'User.email',
        );
        $order = 'Comment.created DESC';
        $this->paginate = $this->Comment->getCommentData($conditions,$fields,$order,$limit);
        if (!empty($limit)) {
            $comments = $this->paginate('Comment');
        } else {
            $comments = $this->Comment->find('all', array(
                'fields' => $fields,
                'conditions' => $conditions,
                'order' => $order,
            ));
        }
        $limit--;
        if ($this->request->is('requested')) {
            return array(
                'comments' => $comments,
                'limit' => $limit
            );
        }
        $this->set('comments', $comments);
        $this->set('limit', $limit);
    }

    function add()
    {
        $arrResponse = array(
            'status' => 'fail',
            'message' => __('Unable to comment, please try again'),
        );
        if ($this->request->is('post') && !empty($this->request->data)) {
            $this->request->data['Comment']['model'] = $this->model;
            $this->request->data['Comment']['ref_id'] = $this->refId;
            $this->request->data['Comment']['user_id'] = $this->Session->read('Auth.User.id');

            if ($this->Comment->save($this->request->data)) {
                $arrResponse = array(
                    'status' => 'success',
                    'message' => __('Comment successfully'),
                );
            }
        }
        if ($this->request->is('ajax')) {
            $comment = $this->Comment->findComments($this->Comment->id);
            $this->set(compact('comment'));
            $arrResponse['content'] = $this->render('/Elements/list', 'ajax')->body();
            echo json_encode($arrResponse);
            exit;
        } else {
            $this->Session->setFlash($arrResponse['message'], 'alert', array(
                'plugin' => 'BoostCake',
                'class' => $arrResponse['status'] == 'fail' ? 'alert-danger' : 'alert-success'
            ));
            $this->redirect($this->referer());
        }
    }

}
