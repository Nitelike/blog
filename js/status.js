function Status(id){
    $.ajax({
        type:'POST',
        url:'../includes/status.php',
        data:'user_rating_id='+id,
        success:function(msg, jsg){
            if(msg == 'err'){
                alert('Some problem occured, please try again.');
            }else{
                $('#'+id).html(msg);
            }
        }
    });
}