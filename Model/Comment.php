<?php

/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class Comment extends AppModel
{
    public $belongsTo = 'User';
    public $status = array(
        0 => 'Pending',
        1 => 'Approved',
        2 => 'Disapprove',
        3 => 'Spam'
    );
    
    public function getData($type)
    {
        $conditions = array();
        if ($type != NULL) {
            $conditions['Comment.status'] = $type;
        }
        return $this->paginate = array(
            'Comment' => array(
                'fields' => array(
                    'Comment.*',
                    'User.id',
                    'User.first',
                    'User.email',
                ),
                'conditions' => $conditions,
                'contain' => array(
                    'UserModel'
                ),
                'order' => 'Comment.created DESC'
            )
        );
    }
    
    public function getCommentData($conditions,$fields,$order,$limit)
    {
        return $this->paginate = array(
            'fields' => $fields,
            'conditions' => $conditions,
            'order' => $order,
            'limit' => $limit
        );
    }
    
    public function findComments($id)
    {
        return $this->find('first', array(
                'conditions' => array(
                    'Comment.id' => $id
                ),
                'fields' => array(
                    'Comment.id',
                    'Comment.user_id',
                    'Comment.comment',
                    'Comment.created',
                    'User.id',
                    'User.first',
                    'User.email',
                ),
            ));
    }
}
