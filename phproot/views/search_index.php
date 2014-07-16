<?php $this->render('common/header'); ?>
<div class="docbody">
    <form action="/search/house" name="search_form" method="get" id="search_form">
        <label>搜索</label>
        <div class="part">
           <input type="text" name="keyword" value="<?=$params['keyword']?>" />
        </div>
        <label>选择租金范围</label>
        <div class="part">
            <select name="min_price">
                <?php foreach($min_price as $v): ?>
                <option value="<?=$v?>" <?php if($params['min_price'] == $v):?> selected<?php endif;?>><?=$v?></option>
                <?php endforeach;?>
            </select>
            -
            <select name="max_price">
                <?php foreach($max_price as $v): ?>
                <option value="<?=$v?>" <?php if($params['max_price'] == $v):?> selected<?php endif;?>><?=$v?></option>
                <?php endforeach;?>
            </select>   
        </div>
        <label>选择出租方式</label>
        <div class="part">
            <input type="radio" name="rent_type" value="1"  <?php if($params['rent_type'] == 1):?> checked<?php endif;?>/> 整租
            <input type="radio" name="rent_type" value="2"  <?php if($params['rent_type'] == 2):?> checked<?php endif;?>/> 单间
            <input type="radio" name="rent_type" value="3"  <?php if($params['rent_type'] == 3):?> checked<?php endif;?>/> 床位
        </div>        
        
        <label>选择户型</label>
        <div class="part">
            <input type="radio" name="room" value="1"  <?php if($params['room'] == 1):?> checked<?php endif;?>/> 1 房
            <input type="radio" name="room" value="2"  <?php if($params['room'] == 2):?> checked<?php endif;?>/> 2 房
            <input type="radio" name="room" value="3"  <?php if($params['room'] == 3):?> checked<?php endif;?>/> 3 房
            <input type="radio" name="room" value="4"  <?php if($params['room'] == 4):?> checked<?php endif;?>/> 4 房
        </div>       
        <div class="action">
            <a href="javascript:void(0)" id="search_btn" class="subbutton green"/>  提 交 </a>
            <input type="hidden" name="uuid" value="<?=$this->uuid?>" />
            <input type="hidden" name="lat" value="<?=$params['lat']?>" />
            <input type="hidden" name="lng" value="<?=$params['lng']?>" />
        </div>
    </form>
</div>
<script>
    $('#search_btn').bind('click',function(){
        document.forms['search_form'].submit();
    });
</script>
<?php $this->render('common/footer'); ?>