$(document).ready(function () {
	setInterval(function() {
		var text = $('#text').val();
		var previewText = $('#preview').html();
		
		if (text !== previewText) {
			document.getElementById('preview').innerHTML = text;
		}
	}, 300);

});

function add(tag) {
	var index = tag.indexOf('</');
	if (index === -1) {
		index = tag.indexOf('"') + 1;
	}
	
	var $txt = jQuery("#text");
	var caretPos = $txt[0].selectionStart;
	var newCaretPos = caretPos + index;
	var textAreaTxt = $txt.val();
	$txt.val(textAreaTxt.substring(0, caretPos) + tag + textAreaTxt.substring(caretPos) );
	setCaretToPos(document.getElementById("text"), newCaretPos);
}

function setSelectionRange(input, selectionStart, selectionEnd) {
  if (input.setSelectionRange) {
    input.focus();
    input.setSelectionRange(selectionStart, selectionEnd);
  }
  else if (input.createTextRange) {
    var range = input.createTextRange();
    range.collapse(true);
    range.moveEnd('character', selectionEnd);
    range.moveStart('character', selectionStart);
    range.select();
  }
}

function setCaretToPos (input, pos) {
  setSelectionRange(input, pos, pos);
}