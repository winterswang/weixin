<?php $this->render('common/header'); ?>
<div class="search_bar clearfix">
    排序
    <?php if($orderby == 'rent_price_asc'):?>
        <a href="/search/house?uuid=<?=$this->uuid?>&<?=http_build_query($search)?>&orderby=rent_price_desc" class="order on" />租金↑</a>
    <?php elseif($orderby == 'rent_price_desc'):?>
        <a href="/search/house?uuid=<?=$this->uuid?>&<?=http_build_query($search)?>&orderby=rent_price_asc" class="order on" />租金↓</a>
     <?php else:?>
        <a href="/search/house?uuid=<?=$this->uuid?>&<?=http_build_query($search)?>&orderby=rent_price_asc" class="order" />租金</a>
     <?php endif;?>
     <a href="/search/house?uuid=<?=$this->uuid?>&<?=http_build_query($search)?>&orderby=createtime_desc"  class="order <?php if($orderby == 'createtime_desc'):?>on<?php endif;?>"/>发布时间</a>
    <a href="/search/index?uuid=<?=$this->uuid?>&<?=http_build_query($search)?>" class="search_btn"></a>
</div>
<div class="listbody" id="house_list">
<?php if(!$length):?>
    <div class="nohouse">
        没有找到符合当前条件的房源
        <br />
        您可以返回重新查找
    </div>
<?php else:?>
    <?php foreach($list as $house): ?>
    <a href="/house/info?uuid=<?=$uuid?>&house_guid=<?=$house['house_guid']?>">
    <article>
        <div class="photo">
            <img src="<?=$house['photo_list'][0]['url']?>" width="80" height="64" />
        </div>
        <div class="intro">
            <h3><?=$house['title']?></h3>
            <p>
                <?=$house['house_intro']?><br/>
                <?php if($house['rent_type']==1){echo "整租";}else{echo $house['rent_type']==2 ? "单间":"床位";}?>&nbsp;&nbsp;&nbsp;&nbsp;
                <strong><?php if ($house['rent_price']==0) {echo "-";} else{echo $house['rent_price']; }?></strong> 元/月
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?=$house['dateline']?>
            </p>
        </div>
    </article>
    </a>
    <?php endforeach;?>
<?php endif;?>
</div>
<?php if($page*$page_size < $length):?>
<div class="showmore">
    <input type="button" id="search_btn" value=" 载入更多房源 " />
    <p class="filter_bar">
        查询: <?=$filter?>
    </p>
    <p>
        共找到 <span><?=$length?></span> 套符合条件的房源
    </p>
</div>
<?php endif;?>
<script type="text/javascript">
var wx_uuid = '<?=$this->uuid?>';

var article_count = <?=$length?>;
var key_word = '<?=$search['keyword']?>';
var search_by = '<?=$search['searchby']?>';
var orderby = '<?=$orderby?>';
var lat = <?=$search['lat']?>;
var lng = <?=$search['lng']?>;
var room = <?=$search['room']?>;
var min_price = <?=$search['min_price']?>;
var max_price = <?=$search['max_price']?>;
var page_no = <?=$page?>;
var page_size = <?=$page_size?>;
jq(document).ready(function() {
    $('#search_btn').bind('click',function(){
    if(page_no*page_size<article_count){
        page_no++;
    }else{
        return;
    }
    $.ajax({   
            type:"get",
            url:"/misc/searchHouse",
            data:{'keyword':key_word,'uuid':wx_uuid,'searchby':search_by,'lat':lat,'lng':lng,
					'room':room,'max_price':max_price,'min_price':min_price,'page':page_no,'page_size':page_size,'orderby':orderby},
            dataType:"json",
            beforeSend:function(){
                $('#search_btn').val(' 正在加载... ');
                $('#search_btn').attr('disabled',"true");
            },
            success:function(res){   
                if(res.error > 0 || !res.length){
                    //$('#house_list').html('<p>'+res.msg+'</p>');
                    return;
                }
                
                $.each(res.data,function(i, n){
                    var l = '<a href="/house/info?uuid=<?=$uuid?>&house_guid='+n.house_guid+'">\
                        <article>\
                            <div class="photo">\
                                <img src="'+n.photo_list[0].url+'" width="80" height="64" />\
                            </div>\
                            <div class="intro">\
                                <h3>'+n.title+'</h3>\
                                <p>' + n.house_intro + '<br/>'+(n.rent_type == 1? '整租' : n.rent_type == 2?'单间':'床位')+'&nbsp;&nbsp;&nbsp;&nbsp;<strong>' + n.rent_price + '</strong> 元/月&nbsp;&nbsp;&nbsp;&nbsp;'+n.dateline+'</p>\
                            </div>\
                        </article>\
                        </a>';
                    $('#house_list').append(l);
                });
                if(res.length<page_no*page_size){
					$('#search_btn').hide();
                }
            },
            error:function(){
            
            },
            complete:function(data, status){
                $('#search_btn').val(' 载入更多房源 ');
                $('#search_btn').removeAttr('disabled');
            },            
        })
    })
});
</script>
<?php $this->render('common/footer'); ?>