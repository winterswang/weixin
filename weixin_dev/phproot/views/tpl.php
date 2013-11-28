<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="main_content fi">
    <div class="tpl-top">
        <span><?=$data['content']?></span>
    </div>
    <div class="tpl-image">
        <div>
            <?php foreach($data['photoList'] as $photo): ?>
                 <?php if(((int)$data['createtime'] -(int)$photo['dataline']) <= 3600):?>
                    <img class="h1-image" src="http://api.ikuaizu.com/data/attachment/<?=$photo['attachment']?>" />
                 <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
    <div class="tpl-image">
        <div>
            <?php foreach($data['photoList'] as $photo): ?>
                 <?php if(((int)$data['createtime'] -(int)$photo['dataline']) > 3600):?>
                    <img class="h2-image" src="http://api.ikuaizu.com/data/attachment/<?=$photo['attachment']?>" />
                 <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
    <div style="clear: both"></div>
</div>

<script tyep="type/javascript">
    $(document).ready(function() {
        var house_guid = '<?=$data['house_guid']?>';
        function bigImage(id) {
            $('.'+id).each(function(i){
                $(this).bind('click', function(){
                    window.location.href= "/house/pic?uuid=<?=$this->uuid?>&start_index=" + i + "&house_guid=" + house_guid;            
                });
            });
        }

        bigImage("h1-image");
        bigImage('h2-image');
    })
</script>