<?php 
if(!empty($comments)){
    foreach($comments as $k=>$comment){
        echo $this->element('GtwComments.list',array('comment'=>$comment));
    }
}
?>
