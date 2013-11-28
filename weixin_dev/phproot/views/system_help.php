<?php $this->render('common/header'); ?>
<div class="docbody">
    <?php foreach($helpcontent as $key=>$group): ?>
        <label><?=$group['title']?></label>
        <div class="part">
        <?php foreach($group['parts'] as $part): ?>
            <?php if(isset($part['title']) && $part['title']):?>
            <p><?=$part['title']?></p>
            <?php endif;?>
            <?php if(isset($part['pic_url']) && $part['pic_url']):?>
            <p><img src="<?=$part['pic_url']?>" width="200"/></p>
            <?php elseif(isset($part['content']) && $part['content']):?>
            <p><?=$part['content']?></p>
            <?php endif;?>
        <?php endforeach;?>
        </div>
    <?php endforeach;?>
</div>
<?php $this->render('common/footer'); ?> 