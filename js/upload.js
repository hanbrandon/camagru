(function() {
	
	var width = 760;    
	var height = 570; 

	function startup() {
		canvas = document.getElementById('canvas');
		startbutton = document.getElementById('startbutton');
		
		startbutton.addEventListener('click', function(ev){
			var x = document.getElementsByClassName("sticker");
			var count = 0;
			for(var i = 0; i<x.length; i++) {
				if(x[i].checked == true) {
					count++;
				}
			}
			if(count == 1) {
				takepicture();
				ev.preventDefault();
			} else {
				//
			}
		}, false);
		
		clearphoto();
	}
	
	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);
	
		var data = canvas.toDataURL('image/png');
	}
		
	function takepicture() {
		console.log("takepic");
		var context = canvas.getContext('2d');
		var imageObj1 = new Image();
		var imageObj2 = new Image();
		var data = document.getElementById('uploaded_image').src; 
		imageObj1.src = data;
		
		var x = document.getElementsByClassName("sticker");
		var count = 0;
		for(var i = 0; i<x.length; i++) {
			if(x[i].checked == true) {
				srcfile = x[i].value;
			}
		}
		// Merge start 
		console.log("merge start");

		imageObj1.onload = function() {
			var width = imageObj1.width;
			var height = imageObj1.height;
			canvas.width = width;
			canvas.height = height;
			context.drawImage(imageObj1, 0, 0, width, height);
			imageObj2.src = "../emoji/" + srcfile + ".png";   
			imageObj2.onload = function() {      
				context.drawImage(imageObj2, (width/2)-125, (height/2)-125, 250, 250);      
				var img = canvas.toDataURL('image/png');
				// Merge end 
				// var data = canvas.toDataURL('image/png');
				var pic_list = document.getElementById('photo');
				var img_src = document.createElement('label');
				var final_value = data + "&" + srcfile;
				img_src.innerHTML = `<input type="radio"  name="image" value="` + final_value + `" checked><img src="` + img + `">`;
				pic_list.appendChild(img_src);	
			}}}
			// Set up our event listener to run the startup process once loading is complete.
			window.addEventListener('load', startup, false);
})();
