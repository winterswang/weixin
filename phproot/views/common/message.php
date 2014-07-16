<?php $this->render('common/header'); ?>
<div class="messageBox">
    <div class="message">
        <?php if ($msg_type == 0):?>
        <header>提示</header>
        <?php elseif ($msg_type == 1):?>
        <header class="error">错误</header>
        <?php else:?>
        <header>确认</header>
        <?php endif;?>
        <div class="part">
            <?=$message?>
        </div>
        <ul class="nav">
            <?php foreach($links as $l): ?>
            <li><a href="<?=$l['href']?>" class="button white"><?=$l['title']?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<?php $this->render('common/footer'); ?>