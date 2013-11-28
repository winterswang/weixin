<?php $this->render('common/header'); ?>
<div class="docbody" id="house_publish" >
    <form action="/house/publish" method="post" name="house_form">
        <div class="row">
            <label>小区</label>
            <?php if($district_guid > 0):?>
                <?=$district_name?>  <a href="/search/district?uuid=<?=$this->uuid?>"  class="button white">重新选择</a>
                <input type="hidden" name="district_guid" value="<?=$district_guid?>" />
            <?php else:?>
                <a href="/search/district?uuid=<?=$this->uuid?>" class="button white">选择小区</a>
            <?php endif;?>
        </div>
        <div class="row rent_type">
            <label>方式</label>
            <div class="clearfix">
                <?php foreach($rent_type as $k=>$v): ?>
                <span>
                    <input type="radio" name="rent_type" value="<?=$k?>" <?php if($k==1):?>checked<?php endif;?>/> <?=$v?>
                </span>
                <?php endforeach;?>
            </div>
        </div>
        <div class="row"> 
            <label>租金</label>
            <input type="number" max="10000" min="100" name="rent_price" value="" required/> 元/月
        </div>
        <div class="row">
            <label>面积</label>
            <input type="number" max="10000" min="0" name="square" value="" required/> 平米  
        </div>

        <div class ="row">
            <label>楼层</label>
            <table>
                <tr>
                    <td>
                    第<input type="number" max="1000" min="1" name="floor_on" value="" width='20' required/>层
                    </td>
                    <td>
                    共<input type="number" max="1000" min="1" name="floor_all" value="" width='20' required/>层
                    </td>
                </tr>
            </table>
        </div>


        <div>
            <label>户型</label>
                <span>
                    <input type="number" max="100" min="0" name="room" value="" width ='20' required  /> 室
                </span>
                <span>
                    <input type="number" max="100" min="0" name="hall" value="" width ='20' required /> 厅
                </span>
                <span>                    
                    <input type="number" max="100" min="0" name="wc" value="" width ='20' required  /> 卫
                </span>
        </div>

        <div class="row provide clearfix">
           <label>配置</label>
            <?php foreach($house_items as $k=>$v): ?>
            <span>
            <input type="checkbox" name="provide[]" value="<?=$k?>" /> <?=$v?>
            </span>
            <?php endforeach;?>
        </div>

        <div>
            <label>看房时间</label>
                <div class="clearfix">
                    <span>
                        <input type="radio" name="preTime" value="1" /> 预约1小时内
                    </span>
                    <span>
                        <input type="radio" name="preTime" value="2"  /> 预约当天
                    </span>
                    <span>                    
                        <input type="radio" name="preTime" value="3"  checked/> 需电话沟通
                    </span>
                </div>
        </div>
        <div class="row description">
            <label>房屋标题</label>  
           <textarea  name ="title" style="color: #ccc" onmouseover="javascript:   if   (this.value=='一句话表述房源特色来吸引更多人查看您的房源，25个字以内'){   this.value='';this.style.color='black';this.select();}"   wrap=VIRTUAL>一句话表述房源特色来吸引更多人查看您的房源，25个字以内</textarea>
        </div>

        <div class="row description">
            <label>房屋描述</label>
            <textarea  name="description" style="color: #ccc;height:100px" onmouseover="javascript:   if   (this.value=='可以描述房屋详细情况，对租客要求，入住时间等。电话号码请不要在此处填写。'){   this.value='';this.style.color='black';this.select();}"  wrap=VIRTUAL>可以描述房屋详细情况，对租客要求，入住时间等。电话号码请不要在此处填写。</textarea>
        </div>

        <div class="row photos">        
            <label>房屋照片</label>
            <div class="clearfix">
            <?php foreach($photo_cache as $pid=>$url): ?>
                <div class="p">
                    <img src="<?=$url?>" width="85"/><br />
                    <input type="checkbox" name="pids[]" checked value="<?=$pid?>" /> 选用
                </div>
            <?php endforeach;?>
            </div>
        </div>
        <div class="row agreement">        
            <label>重要提示</label>
            <div class="part">
                <a href="/system/protocol?uuid=<?=$this->uuid?>">用户使用协议<i></i></a>
            </div>
            <input type="checkbox" checked="checked" name="agree"/>    
            我已阅读并同意以上信息            
        </div>
        <div class="action">
            <a href="javascript:void(0)" id="submit_btn" class="subbutton green"/>确认提交</a>
            <input type="hidden" name="uuid" value="<?=$this->uuid?>" />
        </div>
    </form>
</div>
<script>
    $('#submit_btn').bind('click',function(){
        document.forms['house_form'].submit();
    });
    
    $('#house_publish .row span').bind('click',function(){
       $(this).removeClass('green'); 
       var t = $(this).find('input')[0];

       if (t.type == 'radio'){
           $(this).parent().find('span').each(function(){
                $(this).removeClass('green');
           });
       }
       
       t.click();
       if (t.checked){
           $(this).addClass('green'); 
       }       
    });
</script>
<?php $this->render('common/footer'); ?>
 