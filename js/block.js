function Block(id){
    $.ajax({
        type:'POST',
        url:'../includes/block.php',
        data:'user_id='+id,
        success:function(msg, jsg){
            if(msg == 'err'){
                alert('Some problem occured, please try again.');
            }else{
                $('#ver-'+id).html(msg);
                if (msg == 1) {
                    $('#but-ver-'+id).html('Блокировать');
                }
                else if (msg == -1) {
                    $('#but-ver-'+id).html('Разблокировать');
                }
            }
        }
    });
}