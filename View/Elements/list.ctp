<div class="media">
    <a class="pull-left fa fa-user fa-2x fa-border" href="javascript:void(0)" title="<?php echo $comment['User']['first']?>">
        &nbsp;
    </a>
    <div class="media-body">                  
        <h4 class="media-heading">
            <?php echo $comment['User']['first']?>
            <span class='pull-right datetime'><?php echo $this->Time->timeAgoInWords($comment['Comment']['created']); ?></span>
            <?php 
                if($this->Session->read('Auth.User.id') == $comment['Comment']['user_id']){
                    echo $this->Html->link('<i class="fa fa-trash-o"></i>','javascript:void(0);',array('escape'=>false,'title'=>'Delete this comment','class'=>'deletecomment pull-right','data-url'=>$this->Html->url(array('plugin'=>'gtw_comments','controller'=>'comments','action'=>'delete',$comment['Comment']['id']))),'Are you sure? You want to delete your comment');
                }
            ?>
        </h4>
        <p><?php echo $comment['Comment']['comment']?></p>
    </div>
</div> 
