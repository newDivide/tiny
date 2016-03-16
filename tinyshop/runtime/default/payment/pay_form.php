<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
    <p>Please Wait...</p>
    <form id="paysubmit" name="paysubmit" action="<?php echo $paymentPlugin->submitUrl();?>" method="<?php echo isset($paymentPlugin->method)?$paymentPlugin->method:"";?>">
        <?php foreach($sendData as $key => $item){?>
        <input type='hidden' name='<?php echo isset($key)?$key:"";?>' value='<?php echo isset($item)?$item:"";?>' />
        <?php }?>
    </form>
    <script type='text/javascript'>
    document.forms['paysubmit'].submit();
    </script>
</body>
</html>

<!--Powered by TinyRise-->