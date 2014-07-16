<?php $this->render('common/header'); ?>
<div class="docbody" id="reserve_confirm">
<form action="/reserve/create" method="post" name="confirm_from">

    <article>
        <div class="photo">
            <img src="<?=$house['photo_list'][0]['url']?>" width="70" />
        </div>
        <div class="intro">
            <h3><?=$house['title']?></h3>
            <p>
             <?php if($house['rent_period']=1){echo "整租";}else{echo "合租";}?> &nbsp;&nbsp;<?=$house['room']?>室<?=$house['wc']?>卫&nbsp;&nbsp;<?=$house['square']?>㎡  <?=$house['floor_on']?>/<?=$house['floor_on']?>层<br/>
            <strong><?=$house['rent_price']?></strong> 元/月 
            </p>
        </div>
    </article>

    <div class="agreement">        
        <label>重要提示</label>
        <div class="part">
            <a href="/system/protocol?uuid=<?=$this->uuid?>">用户使用协议<i></i></a>
        </div>         
    </div>     
    <div class="action">
        <a href="javascript:void(0)" id="submit_btn" class="subbutton green"/> 预 约 </a>
        <input type="hidden" name="uuid" value="<?=$this->uuid?>" />
        <input type="hidden" name="house_guid" value="<?=$house['house_guid']?>" />
    </div>
</form>
</div>
<script>
    $('#submit_btn').bind('click',function(){
        document.forms['confirm_from'].submit();
    });
</script>
<?php $this->render('common/footer'); ?>