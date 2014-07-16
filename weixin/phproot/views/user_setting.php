<?php $this->render('common/header'); ?>
<div class="docbody" id="user_setting">
    <form action="/user/setting" method="post" name="user_setting">
        <div class="row">
            <label>姓名</label>
            <div class="part">
                <input type="text" name="username" value="<?=$user['username']?>" />
            </div>            
        </div>
        <div class="row gender">
            <label>性别</label>
            <div class="part clearfix">
                <span <?php if($user['gender'] == 1):?>class="green"<?php endif;?>>
                    <input type="radio" name="gender" value="1" <?php if($user['gender'] == 1):?> checked<?php endif;?>/> 男
                </span>
                <span <?php if($user['gender'] == 2):?>class="green"<?php endif;?>>
                    <input type="radio" name="gender" value="2" <?php if($user['gender'] == 2):?> checked<?php endif;?>/> 女
                </span>
            </div>
        </div>
        <div class="row mobile">
            <label>手机号</label>
            <div class="part">
                <input type="phone" id="mobile" name="mobile" value="<?=$user['mobile']?>" />
                <input type="button" id="validcode_btn" value="获取短信验证码" class="button" />
            </div>
        </div>
        <div class="row">
            <label>验证码</label>
            <div class="part">
                <input type="number" name="validcode" value="" />
            </div>
        </div>
        <div class="action">
            <a href="javascript:void(0)" id="submit_btn" class="subbutton green"> 提 交 </a>
            <input type="hidden" name="uuid" value="<?=$this->uuid?>" />
            <input type="hidden" name="referer" value="<?=$referer?>" />
        </div>
    </form>
</div>
<script type="text/javascript">
    $('#submit_btn').bind('click',function(){
        document.forms['user_setting'].submit();
    });
    
    $('#user_setting .row span').bind('click',function(){
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
    
    $('#validcode_btn').bind('click',function(){
        var mobile = $('#mobile').val();
        var btn = $(this);
       
        if (!mobile) {
            alert('请输入手机号');
            return;
        }
        
        $.ajax({   
            type:"post",
            url:"/system/validcode",
            data:{'mobile':mobile,'uuid':wx_uuid},
            dataType:"json",
            success:function(res){
                if(res.error > 0){
                    alert(res.msg);
                    return;
                }
                
                btn.attr('disabled','disabled');
                window.setInterval(validcount, 1000);
            }, 
            error:function(){
            
            }
        });
    });    
    
    var wx_uuid = '<?=$this->uuid?>';
    var seconds = 30;
    
    function validcount(){
        if (seconds <= 0){
            window.clearInterval();
            return;
        }

        seconds --;
        $('#validcode_btn').val('验证码已发送成功 ('+seconds+')');

        if (seconds == 0){
            window.clearInterval();
            $('#validcode_btn').removeAttr('disabled');
            $('#validcode_btn').val('获取短信验证码');
        }
    }

</script>
<?php $this->render('common/footer'); ?>
