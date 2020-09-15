$('document').ready(function(){
	$(window).scrollTop(0);
	html2canvas(document.querySelector("#albumGrid"), {"proxy": "lib/proxy.php", "logging": true, onclone: function(new_document) {
      new_document.querySelector("#albumGrid").setAttribute("style", "clear: both; float: left; overflow: visible; width: 90%; margin-left: 4.3%;");
    }}).then(canvas => {
	    document.querySelector("#albumGrid").innerHTML = "";
	    document.querySelector("#albumGrid").appendChild(canvas);

		$( "#downloadButton" ).click(function() {
			 var a = document.getElementById('downloadButton');
	         a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
	         a.download = 'collage.png';
     	});

	});
});

		