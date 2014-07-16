<?php $this->render('common/header'); ?>
<div class='docbody'>
	<?php foreach($list as $r):?>
	<div class="subscribe">
		<div class="info clearfix">
			<img class="ico" src="/img/avatar<?php if($r['gender'] == 2):?>girl<?php endif;?>.gif" >
			<p class="pl">
				<who><?=$r['username']?></who><br/>
				<time><?=date('m-d H:i',$r['createtime'])?></time>
			</p>
			<a href="tel:<?=$r['mobile']?>"  class="subbutton green call">
				Call
			</a> 
		</div>
	</div>
	<?php endforeach;?>
</div>
<?php $this->render('common/footer'); ?>