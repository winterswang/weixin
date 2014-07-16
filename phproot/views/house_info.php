<?php $this->render('common/header'); ?>
<div class="docbody" id="house_info">
    <div class="title">
        <h3>
            <?php if(empty($title)){echo trim($house_intro,",");}else{echo trim($title,",");}?>
        </h3>
    </div>
    <div class="time">
       <i></i>发布时间  <?=date('Y-m-d H:i',$updatetime)?>
    </div>     
    <div class="info">
        <h3><strong class="price">
            <?php 
            if ($rent_price==0) {
            echo "-";} 
            else{
              echo $rent_price;  
            }
            ?></strong> 元/月</span> <?php if($rent_type==1){echo "整租";}else{echo $rent_type==2 ?"单间":"床位";}?></h3>
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
    <ul class="handle">
        <li class="subbutton">
            <a href="javascript:void(0)" id="collect_btn" fav_id="<?=$fav_id?>" ><?php if($fav_id > 0):?>已收藏<?php else:?>加入收藏<?php endif;?></a>
        </li>
        <li class="subbutton green">
            <?php if($reserve_id > 0):?>
            <a href="/reserve/info?uuid=<?=$this->uuid?>&reserve_code=<?=$reserve_code?>" >查看预约</a>
            <?php else:?>
            <a href="/reserve/create?uuid=<?=$this->uuid?>&house_guid=<?=$house_guid?>">立即预约</a>
            <?php endif;?>
        </li>
    </ul>
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
<script type="text/javascript">
var wx_uuid = '<?=$this->uuid?>';
var house_guid = '<?=$house_guid?>';
var fav_id = '<?=$fav_id?>';

jq(document).ready(function() {
    $('#collect_btn').bind('click',function(){
        var btn = $(this);
        if (btn.attr('fav_id') > 0) {
            return;
        }
        
        $.ajax({   
            type:"post",
            url:"/favorite/create",
            data:{'house_guid':house_guid,'uuid':wx_uuid},
            dataType:"json",
            success:function(res){   
                if(res.error > 0){
                    alert(res.msg);
                    return;
                }

                btn.parent().html('已收藏');
            }, 
            error:function(){
            
            }
        })
    });
});


function showTips( tips, height, time ){
    var windowWidth = document.documentElement.clientWidth;
    var tipsDiv = '<div class="tipsClass">' + tips + '</div>';
    
    $( 'body' ).append( tipsDiv );
    $( 'div.tipsClass' ).css({
    'top' : height + 'px',
    'left' : ( windowWidth / 2 ) - ( tips.length * 13 / 2 ) + 'px',
    'position' : 'absolute',
    'padding' : '3px 5px',
    'background': '#8FBC8F',
    'font-size' : 12 + 'px',
    'margin' : '0 auto',
    'text-align': 'center',
    'width' : 'auto',
    'color' : '#fff',
    'opacity' : '0.8'
    }).show();
    setTimeout( function(){$( 'div.tipsClass' ).fadeOut();}, ( time * 1000 ) );
}
</script>
<?php $this->render('common/footer'); ?>