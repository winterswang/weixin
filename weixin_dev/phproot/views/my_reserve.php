<?php $this->render('common/header'); ?>
<div class="mycenter">
    <div class="tab_bar clearfix">
        <a href="/my/collect?uuid=<?=$this->uuid?>" target="_self">我的收藏</a>
        <span>我的预约</span>
    </div>
    <div class="listbody reservelist" id="house_list">
    <?php foreach($list as $house): ?>
        <a href="/reserve/info?uuid=<?=$this->uuid?>&reserve_code=<?=$house['reserve_info']['reserve_code']?>">
        <article>
            <div class="time">
                <i></i> 预约时间 <?=date('m-d H:i',$house['reserve_info']['createtime'])?>
            </div>            
            <div class="photo">
                <img src="<?=$house['photo_list'][0]['url']?>" width="80" height="64"  />
            </div>
            <div class="intro">
                <h3><?=$house['house_intro']?></h3>
                <p>
                    <?php if($house['rent_type']==1){echo "整租";}else{echo $house['rent_type']==2 ? "单间":"床位";}?> <strong><?=$house['rent_price']?></strong> 元/月
                    <br/>
                    房东 <?=($house['reserve_info']['house_username'] ? $house['reserve_info']['house_username'] : '--')?>
                </p>
            </div>
        </article>
        </a>
    <?php endforeach;?>
    </div>
</div>
<?php $this->render('common/footer'); ?>