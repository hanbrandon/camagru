<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<script>
	var from = 0;
	var num = 5;
	var run_check = 0;
	function galleryLoad() {
		var request = new XMLHttpRequest();
		var url = "../functions/get_posts_info.php";
		request.open("POST", url, true);
		request.setRequestHeader("Content-Type", "application/json");
		request.onreadystatechange = function () {
			if (request.readyState === 4 && request.status === 200) {
				var jsonData = JSON.parse(request.response);
				var feeds = document.getElementById('feeds');
				feeds.innerHTML = feeds.innerHTML + jsonData;
				//console.log(jsonData); //debug
			}
		};
		var data = JSON.stringify({"from": from});
		request.send(data);
		from = from + num ;
		run_check = 0;

		console.log(document.getElementById("feeds").offsetHeight+ "/" + window.screen.height);
	}

	function myFunction() {
		var scroll = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
		if(scroll > document.body.scrollHeight * 0.3 && run_check == 0) {
			run_check = 1;
			galleryLoad();
		}
	}
</script>
<script src="/js/like_comment_delete.js"></script>
<div class="feeds" id="feeds" >
</div>
