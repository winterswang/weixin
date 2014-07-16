<?php $this->render('common/header'); ?>
<div class="fi_bar"> 
	发布房源
</div>
<div class="docbody">
<div class="main_content fi">

<span>内容</span>

<label id='qa'><?php $content ?></label>

<span>照片</span>
<div id = "line1"  class="subscribe image_list" style="padding-bottom:3px;padding-top:8px;">
	<div class="image_list1 image_test">
		<?php foreach($photoList as $house): ?>
		<img src = "<?=$house['url']?>" width="60px" height="60px" />
		<?php endforeach;?>
	</div>
</div>
<div id = "line2" class="subscribe image_list" style="padding-bottom:3px;padding-top:8px;">
    <div class="image_list1 image_test">
        <?php foreach($photoList as $house): ?>
        <img src = "<?=$house['url']?>" width="60px" height="60px" />
        <?php endforeach;?>
    </div>
</div>
<div id = "line3" class="subscribe image_list" style="padding-bottom:3px;padding-top:8px;">
    <div class="image_list1 image_test">
        <?php foreach($photoList as $house): ?>
        <img src = "<?=$house['url']?>" width="60px" height="60px" />
        <?php endforeach;?>
    </div>
</div>
</div>
<script type="text/javascript">
</script>
<?php $this->render('common/footer'); ?>