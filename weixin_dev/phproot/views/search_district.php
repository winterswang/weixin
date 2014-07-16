<?php $this->render('common/header'); ?>
<div class="district_search">
<form onsubmit="return false">
    <label>输入小区名或道路名</label>
    <div class="part">
        <input type="text" name="district_name" id="district_name" value=""/>
        <a href="javascript:void(0)" id="search_btn" class="subbutton green" > 查找 </a>  
    </div>
    <div id="search_tip"></div>
    <div id="search_result">
        
    </div>
    <div class="showmore" id="showmore" style="display: none">
        <input type="button" id="show_more_btn" value=" 载入更多小区 " />
    </div>
</form>
</div>
<script type="text/javascript">

var page_no = 1;
var page_size = 20;
var wx_uuid = '<?=$this->uuid?>';
jq(document).ready(function() {
    $('#search_btn').bind('click',function(){
        var district_name = $('#district_name').val();
        
        if (!district_name || district_name =='') {
            return;
        }
        
        $('#search_result').html('');
        $('#search_tip').html('');
        $.ajax({   
            type:"get",
            url:"/search/district",
            data:{'district_name':district_name,'uuid':wx_uuid,'page_no':page_no,'page_size':page_size},
            dataType:"json",
            success:function(res){   
                if(res.error > 0 || !res.length){
                    $('#search_result').html('<p>'+res.msg+'</p>');
                    return;
                }
                $('#search_tip').html('共找到 '+res.length+' 个小区');

                display_search(res);

            }, 
            error:function(){
            
            }
        })
    });
    
    
    $('#show_more_btn').bind('click',function(){
        var district_name = $('#district_name').val();
        
        if (!district_name || district_name =='') {
            return;
        }
        
        $.ajax({   
            type:"get",
            url:"/search/district",
            data:{'district_name':district_name,'uuid':wx_uuid,'page_no':page_no,'page_size':page_size},
            dataType:"json",
            beforeSend:function(){
                $('#show_more_btn').val(' 正在加载... ');
                $('#show_more_btn').attr('disabled',"true");
            },            
            success:function(res){
                display_search(res);
            }, 
            error:function(){
            
            },
            complete:function(data, status){
                $('#show_more_btn').val(' 载入更多小区 ');
                $('#show_more_btn').removeAttr('disabled');
            }            
        })        
    });
    
    function display_search(res) {
        $.each(res.list,function(i, n){
            var l = '<p guid="'+n.district_guid+'" name="'+n.district_name+'" class="white">'
            l += '<strong>'+n.district_name + '</strong><br />';
            l += '<span>' +n.district_address+'</span>';
            l +='</p>';
            $('#search_result').append(l);
        });
        
        if(res.length<page_no*page_size){
            $('#showmore').hide();
        }else{
            page_no++;
            $('#showmore').show();
        }
        
        $('#search_result p').each(function(){
            $(this).bind('click',function(){
                window.location = '/house/publish?uuid='+wx_uuid+'&district_guid='+$(this).attr('guid')+'&district_name='+$(this).attr('name');
            });
        });
    }

});
</script>
</div>
</body>
</html>
