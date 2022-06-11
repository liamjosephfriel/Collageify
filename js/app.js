$('document').ready(function () {
	$(window).scrollTop(0);
	html2canvas(document.querySelector('#albumGrid'), { 'proxy': 'lib/proxy.php', 'logging': true, onclone: function () { } }).then(function (canvas) {
		document.querySelector('#albumGrid').innerHTML = "";
		document.querySelector('#albumGrid').appendChild(canvas);

		$('#downloadButton').click(function () {
			var download_button = document.getElementById('downloadButton');
			download_button.href = canvas.toDataURL('image/jpeg').replace('image/jpeg', 'image/octet-stream');
			download_button.download = "collage.png";
		});
	});

	$('.term-button').click(function () {
		$('#jsTermValue').val($(this).data('term'));
		$('.jsTermForm').submit();
	});

	$('.size-button').click(function () {
		$('#jsSizeValue').val($(this).data('size'));
		$('.jsSizeForm').submit();
	});
});

