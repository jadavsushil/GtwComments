<?php 
$this->Helpers->load('GtwRequire.GtwRequire');
echo $this->GtwRequire->req($this->Html->url('/',true).'GtwComments/js/comment.js');
?>
<div class="gtwComments">
    <?php echo $this->Form->create('Comment', array('url'=>array('plugin'=>'gtw_comments','controller'=>'comments','action'=>'add','model'=>$model,'ref_id'=>$refId),'inputDefaults' => array('class' => 'form-control'),'class' => 'form-horizontal gtwPostCommentForm')); ?>
    <div class="row">
        <div class="col-md-12 newcomment">
            <div class="media">
                <a class="pull-left fa fa-user fa-2x fa-border" href="#" title="<?php echo $this->Session->read('Auth.User.first')?>">
                    &nbsp;
                </a>
                <div class="media-body">                  
                    <?php if($this->Session->check('Auth.User.id')){?>
                        <textarea name="data[Comment][comment]" class="textarea" rows="2" id="CommentComment" placeholder="<?php echo __('Add your comment')?>"></textarea>
                        <?php 
                            echo $this->Form->submit('Submit', array(
                                                    'div' => false,
                                                    'class' => 'btn btn-primary postbutton'
                            ));                         
                        ?>
                    <?php }else{?>    
                        <textarea name="data[Comment][comment]" class="textarea" rows="2" id="CommentComment" placeholder="<?php echo __('Please login to post your comment')?>" disabled></textarea>
                        <?php 
                            echo $this->Html->link('Submit','javascript:void(0);', array('class' => 'btn btn-primary postbutton'));                         
                        ?>
                    <?php } ?>
                </div>
            </div>            
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12 commentlist">
            <?php 
                $comments = $this->requestAction('gtw_comments/comments/get_comment',array('named'=>array('model'=>$model,'ref_id'=>$refId)));
                if(!empty($comments['comments'])){
                    foreach($comments['comments'] as $k=>$comment){
                        echo $this->element('GtwComments.list',array('comment'=>$comment));
                        if($k+1 >= $comments['limit']){
                            break;
                        }
                    }
                    if(count($comments['comments']) > $comments['limit']){
                        echo $this->Html->link('View All Comment','javascript:void(0);',array('class'=>'viewallcomment','data-url'=>$this->Html->url(array('plugin'=>'gtw_comments','controller'=>'comments','action'=>'get_comment',-1,'model'=>$model,'ref_id'=>$refId))));
                    }
                }else{
            ?>
                    <div class="befirst">
                        <?php echo __("Be first to comment.");?>
                    </div>
            <?php   
                }
            ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
