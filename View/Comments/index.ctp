<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 style='margin-top:0px'>Comments</h3></div>
            <div class="col-md-4 text-right"></div>
        </div>
    </div>    
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th width='5%'><?php echo $this->Paginator->sort('id'); ?></th>
                <th width='50%'><?php echo $this->Paginator->sort('Comment'); ?></th>
                <th width='10%'><?php echo $this->Paginator->sort('status'); ?></th>
                <?php if($this->Session->read('Auth.User.role')=='admin'){?>
                    <th width='15%'><?php echo $this->Paginator->sort('User.first','Added By'); ?></th>
                <?php }?>
                <th width='10%'><?php echo $this->Paginator->sort('created', 'Date Added'); ?></th>
                <th width='10%' class='text-center'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($comments)){?>
                <tr>
                    <td colspan='6' class='text-warning'><?php echo __('No record found.')?></td>
                </tr>
            <?php 
                }else{
                    foreach ($comments as $comment){
            ?>
                        <tr>
                            <td><?php echo $comment['Comment']['id']?></td>
                            <td>
                                <?php 
                                    $comment['Comment']['comment']   = strip_tags($comment['Comment']['comment']);
                                    if(strlen($comment['Comment']['comment'])<100){
                                        echo nl2br($comment['Comment']['comment']);
                                    }else{
                                        echo substr($comment['Comment']['comment'], 0,97).'... ';
                                        echo $this->Html->link(' Read More',array('controller'=>'comments','action'=>'view',$comment['Comment']['id']),array('title'=>'Click here to View Detail'));
                                    }
                                ?>
                            </td>
                            <td><?php echo $status[$comment['Comment']['status']]?></td>
                            <?php if($this->Session->read('Auth.User.role')=='admin'){?>
                                <td><?php echo $comment['User']['first'].' <small>('.$comment['User']['email'].')</small>';?></td>
                            <?php }?>
                            <td><?php echo $this->Time->format('Y-m-d H:i:s', $comment['Comment']['created']); ?></td>
                            <td class="text-center actions">
                                <?php 
                                    if($this->Session->read('Auth.User.role')=='admin'){
                                        if($comment['Comment']['status']!=$constStatus['Approved']){
                                            echo $this->Html->link(__('Approve'), array('action' => 'change_status','Approved', $comment['Comment']['id']));
                                            echo '&nbsp|&nbsp';
                                        }
                                        if($comment['Comment']['status']!=$constStatus['Disapprove']){
                                            echo $this->Html->link(__('Disapprove'), array('action' => 'change_status','Disapprove', $comment['Comment']['id']));
                                            echo '&nbsp|&nbsp';
                                        }
                                        if($comment['Comment']['status']!=$constStatus['Spam']){
                                            echo $this->Html->link(__('Mark as spam'), array('action' => 'change_status','Spam', $comment['Comment']['id']));
                                            echo '&nbsp|&nbsp';
                                        }
                                    }
                                    echo $this->Html->actionIcon('fa fa-pencil', 'edit', $comment['Comment']['id']);
                                    echo '&nbsp|&nbsp';
                                    echo $this->Html->link('<i class="fa fa-trash-o"> </i>',array('controller'=>'comments','action'=>'delete',$comment['Comment']['id']),array('role'=>'button','escape'=>false,'title'=>'Delete this comment'),'Are you sure? You want to delete this comment.');
                                ?>
                            </td>
                        </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>    
</div>
<div id="comment-modal-loader"></div>
