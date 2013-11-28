<?php $this->render('common/header'); ?>
<div class="mycenter">
    <div class="tab_bar clearfix">
        <span>我的收藏</span>
        <a href="/my/reserve?uuid=<?=$this->uuid?>"  target="_self">我的预约</a>
    </div>
    <div class="listbody" id="house_list">    
        <?php foreach($list as $house): ?>
        <article id="<?=$house['house_guid']?>">
            <div class="photo">
                <img src="<?=$house['photo_list'][0]['url']?>" width="80" height="64"  />              
            </div>
            <div class="intro">
                <h3><?=$house['title']?></h3>
                <p>
                    <?=$house['house_intro']?><br/>
                    <?php if($house['rent_type']==1){echo "整租";}else{echo $house['rent_type']==2 ? "单间":"床位";}?> <strong><?=$house['rent_price']?></strong> 元/月
                </p>
            </div>
        </article>
        <div class="handle" id="handle_<?=$house['house_guid']?>" style="display: none">
           <ul>
               <li class="subbutton red">
                   <a href="javascript:removeFavorite(<?=$house['house_guid']?>)">移除</a>
               </li>
               <li class="subbutton green">
                   <a href="/house/info?uuid=<?=$this->uuid?>&house_guid=<?=$house['house_guid']?>">查看</a>
               </li>    
           </ul>
       </div>
        <?php endforeach;?>
    </div>
</div>
<script>
    $('#house_list article').bind('click',function(){
        var id = $(this).attr('id');
        if ($('#handle_'+id).css("display")=="none") {
            $('#handle_'+id).show();
        }else{
            $('#handle_'+id).hide();
        }
    });
    
    var wx_uuid = '<?=$this->uuid?>';
    function removeFavorite(house_guid){
        if (confirm('确定要删除吗？')) {

            $.ajax({   
                type:"post",
                url:"/favorite/remove",
                data:{'house_guid':house_guid,'uuid':wx_uuid},
                dataType:"json",
                success:function(res){   
                    if(res.error > 0){
                        alert(res.msg);
                        return;
                    }
                    
                    $('#handle_'+house_guid).remove();
                    $('#'+house_guid).remove();
                }, 
                error:function(){
                
                }
            });
        }
    }
</script>
<?php $this->render('common/footer'); ?>