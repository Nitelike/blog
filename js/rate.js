function Rating(id,type,target){
    $.ajax({
        type:'POST',
        url:'../includes/rating.php',
        data:'mark-id='+id+'&mark-type='+type,
        success:function(msg, jsg){
            if(msg == 'err'){
                alert('Some problem occured, please try again.');
            }else{
                $('#'+target).html(msg);
            }
        }
    });
}