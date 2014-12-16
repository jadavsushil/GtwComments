define(['jquery', 'basepath'], function ($, basepath) {
    $('.gtwPostCommentForm').submit(function(e){
        e.preventDefault();
        currForm = this;
        if($(currForm).find('textarea').val() != ''){
            actionUrl = $(this).prop('action');
            $.post(actionUrl,$(currForm).serialize(), function(data){
                var response = jQuery.parseJSON(data);
                alertType= 'alert-danger';
                if(response.status=='success'){
                    alertType= 'alert-success';
                    $(currForm).find('.commentlist').prepend(response.content);
                    $(currForm).find('textarea').val('');
                    bindCommentDelete();
                }    
                $(".alert").alert('close');
                $(currForm).prepend('<div class="alert '+alertType+'"><a class="close" data-dismiss="alert">×</a><span>'+response.message+'</span></div>');
            });
        }
    });
    bindCommentDelete();//Bind for first time
    $('.viewallcomment').on('click',function(e){
        e.preventDefault();
        $(this).html('<i class="fa fa-refresh fa-spin"></i> Please Wait...');
        $(this).parent('.commentlist').load($(this).data('url'),function(){
            bindCommentDelete();
        });        
    });
    function bindCommentDelete(){
        $('.deletecomment').on('click',function(e){
            e.preventDefault();
            $(this).parents('.media').load($(this).data('url')).remove();
        });   
    }    
});
