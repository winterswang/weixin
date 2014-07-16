<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="main_content fi">
    <div class="tpl-top" style="margin-top:10px;margin-left:2px;">
        <span style="font-size:17px;"><?=$data['content']?></span>
    </div>
    
    <div class="tpl-image">
        <div style="margin-left:2px;">
            <?php foreach($data['photoList'] as $photo): ?>
                <a href="http://api.ikuaizu.com/data/attachment/<?=$photo['attachment']?>" class="swipebox">
                    <img src="http://api.ikuaizu.com/data/attachment/<?=$photo['attachment']?>" />
                </a>
            <?php endforeach;?>
        </div>
    </div>
    <div style="clear: both"></div>
</div>
</div>
<script tyep="type/javascript">
    $(document).ready(function() {
        $(".swipebox").swipebox();
    })
</script>
</body>
</html>
