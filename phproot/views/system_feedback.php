<?php $this->render('common/header'); ?>
<div class="docbody" id="feedback" >
    <form action="/system/feedback" method="post" name="feedback_form">
        <label>您的电子邮箱</label>
        <div class="part">
            <input name="email" type="email" value="" />
        </div>        
        <label>输入您的建议</label>
        <div class="part">
            <textarea cols="32" rows="6" name="description" ></textarea>
        </div>
        <div class="action">
            <a href="javascript:void(0)" id="submit_btn" class="subbutton green" />确认提交</a>
            <input type="hidden" name="uuid" value="<?=$this->uuid?>" />
        </div>
    </form>
</div>
<script>
    $('#submit_btn').bind('click',function(){
        document.forms['feedback_form'].submit();
    });
</script>
<?php $this->render('common/footer'); ?> 