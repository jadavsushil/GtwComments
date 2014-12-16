<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 style='margin-top:0px'>Edit Comment</h3></div>
            <div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-reply',' Back','index');?></div>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->Form->create('Comment', array('inputDefaults' => array('div' => 'col-md-12 form-group','class' => 'form-control'),'class' => 'form-horizontal','id'=>'CommentEditForm')); ?>
        <div class="row">
            <div class="col-md-12">                
                <?php 
                    echo $this->Form->input('id',array('type'=>'hidden')); 
                    echo $this->Form->input('comment',array('type'=>'textarea')); 
                    if($this->Session->read('Auth.User.role')=='admin'){
                        echo $this->Form->input('status',array('options'=>$status,'empty'=>'Select Comment Status')); 
                    }
                ?>
                <?php echo $this->Form->submit('Save', array(
                    'div' => false,
                    'class' => 'btn btn-primary'
                )); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
