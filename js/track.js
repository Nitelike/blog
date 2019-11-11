function track(id){
    $.ajax({
        type:'POST',
        url:'../includes/track.php',
        data:'track-id='+id,
        success:function(msg, jsg){
            if(msg == 'err'){
                alert('Some problem occured, please try again.');
            }else{
                $('#track-'+id).html(msg);
            }
        }
    });
}