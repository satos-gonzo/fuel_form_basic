<section>

<!--  エラーメッセージがあればループして表示-->
<?php if(!empty($error)){
   foreach($error as $key => $value) { ?>
<div class="errMsg"><?php  echo $value;?></div>
<?php  }
} ?>

<?=$user_form?>

</section>
