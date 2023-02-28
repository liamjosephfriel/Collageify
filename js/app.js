$('document').ready(function () {
	$(window).scrollTop(0);
	
	$('.term-button').click(function () {
		$('#jsTermValue').val($(this).data('term'));
		$('.jsTermForm').submit();
	});

	$('.size-button').click(function () {
		$('#jsSizeValue').val($(this).data('size'));
		$('.jsSizeForm').submit();
	});
});

