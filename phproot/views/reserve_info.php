<?php $this->render('common/header'); ?>
<div class="docbody" id="house_info">
    <div class="title">
        <h3>
            <?php if(empty($title)){echo trim($house_intro,",");}else{echo trim($title,",");}?>
        </h3>
    </div>
    <div class="time">
       <i></i>预约时间  <?=date('Y-m-d H:i',$reserve_info['dateline'])?>
    </div>    
    <div class="reserve">
        <p class="clearfix">
            <img class="ico" src="/img/avatar<?php if($reserve_info['gender'] == 2):?>girl<?php endif;?>.gif" >
            <?=$reserve_info["username"]?>
            <a href="tel:<?=$reserve_info["mobile"]?>"  class="subbutton green call"><i></i>联系房东</a>
        </p>
        <hr />
        <p class="status"><?php if($proved) :?>该房源已通过认证<?php else:?>该房源还未通过认证<?php endif;?></p>
    </div>
    <ul class="handle">
        <li class="subbutton red">
            <?php if($report_agent):?>
            已举报
            <?php else:?>
            <a href="javascript:void(0)" id="report_btn" >TA 是中介</a>
            <?php endif;?>
        </li>
        <li class="subbutton">
            <a href="/reserve/cancel?uuid=<?=$this->uuid?>&reserve_code=<?=$reserve_info['reserve_code']?>" >取消预约</a>
        </li>
    </ul>
    <div class="info">
        <h3><strong class="price"><?=$rent_price?></strong> 元/月</span> <?php if($house['rent_type']==1){echo "整租";}else{echo $house['rent_type']==2 ? "单间":"床位";}?></h3>
        <p>
            <?=$room?>室<?=$hall?>厅<?=$wc?>卫  <?=$square?>㎡  <?=$floor_on?>/<?=$floor_on?>层
        </p>
        <hr />
        <p class="provides clearfix">
            <?php
            $house_config = require(ROOT_PRO_PATH."/config/house.properties.php");
            $arrPro = explode(",", $provides);
            
            foreach ($house_config["house_items"] as $k=>$value) {
                echo '<span '.(in_array($k,$arrPro) ? 'class="on"' : '').'>'.$value.'</span>';
            }
            ?>
        </p>
        <hr />
        <p>
            <?=$district_info["district_name"]?> <span><?=$district_info["district_address"]?></span>
            <?php if(!empty($district_info['lng'])):?>
            <a href="http://api.map.baidu.com/marker?location=<?=$district_info['lat'].",".$district_info['lng']?>&title=<?=$district_info["district_name"]?>&content=<?=$district_info["district_name"]?>&output=html&src=快租" target="_blank">
                <img class="location" src="/img/fireeagle_location.png" height="27" />
            </a>
            <?php endif;?>
        </p>
        <!--<img width=100% src="http://api.map.baidu.com/staticimage?center=<?=$district_info['lng'].",".$district_info['lat']?>&width=300&height=100&zoom=15&markers=<?=$district_info['lng'].",".$district_info['lat']?>&markerStyles=m,,0xf00800" />-->
    </div>
    <div class="detail">
        <?=$description?>
    </div>
    <div class="image_area">
        <ul>
        <?php
          foreach ($photo_list as $item){
            if(substr($item["url"], -11) != "default.jpg"){
              echo '<li><img src="'.$item["url"].'" /></li>';
            }
          }
        ?>
        </ul>
    </div>   
</div>
<script>
    var house_guid='<?=$house_guid?>';
    var wx_uuid='<?=$this->uuid?>';
    
    $('#report_btn').bind('click',function(){
        var btn = $(this);
        $.ajax({   
            type:"post",
            url:"/system/report",
            data:{'house_guid':house_guid,'uuid':wx_uuid},
            dataType:"json",
            success:function(res){   
                if(res.error > 0){
                    alert(res.msg);
                    return;
                }

                btn.parent().html('已举报');
            }, 
            error:function(){
            
            }
        })   
    });
</script>
<?php $this->render('common/footer'); ?>