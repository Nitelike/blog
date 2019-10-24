function add(tag, shift) {
	var cursorPos = $('#post-text').prop('selectionStart');
	setTimeout(function(){ document.getElementById('post-text').focus();
	$('#post-text')[0].setSelectionRange(cursorPos + shift, cursorPos + shift); }, 10);
    var v = $('#post-text').val();
    var textBefore = v.substring(0,  cursorPos);
    var textAfter  = v.substring(cursorPos, v.length);
    $('#post-text').val(textBefore + tag + textAfter);
	
}
