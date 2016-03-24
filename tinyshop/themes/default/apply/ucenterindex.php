<script type="text/javascript">
	$("#upload-link").on("click",function (){
		art.dialog({id:'head-dialog',lock:true,content:document.getElementById('head-dialog')});
	});

	$("#uploadForm").iframePostForm({
		iframeID: 'iframe-post-form',
		json:true,
		post: function(){
			$("#upload-btn").text("上传中...")
		},
		complete: function(data){
			if(data['error']==1){
				alert(data['message']);
			}else{
				var root_url = "<?php echo urldecode(Url::urlFormat("@"));?>"
				$("#head-pic").attr("src",root_url+data['url']+'?i='+Math.random());
				art.dialog({id:'head-dialog'}).close();
			}
			$("#upload-btn").text("上传");
		}
	});
</script>