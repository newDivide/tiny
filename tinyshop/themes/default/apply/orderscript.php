<script type="text/javascript">
	function order_sign(id) {
		$.post("<?php echo urldecode(Url::urlFormat("/ucenter/order_sign"));?>",{id:id},function(data){
			if(data['status']=='success'){
				location.reload();
			}
		},'json');
	}
</script>