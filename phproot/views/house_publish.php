
<!DOCTYPE html> 
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="MobileOptimized" content="320"/>
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="Expires" content="-1"/>
	<!-- iOS Full Screen -->
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<!-- iOS Status Bar Style (default, white, white-translucent) -->
	<meta name="apple-mobile-web-app-status-bar-style" content="white"/>
	<title><?=$this->meta['title']?></title>
	<link rel="stylesheet" type="text/css" href="/css/common.css" />
	<script src="/js/jquery-1.9.1.min.js"></script>
	<style type="text/css">
	
	.title{
		color:#626262;
		margin: 10px 0 0 25px;
		font:13px/30px 微软雅黑;
		text-align: 2px;
	}
	.txt{		
		margin: 0 16px 0;		
	}
	.txt textarea{
		background: #fff;
		width: 100%;
		border:none;
		padding: 6px 0;
		text-indent: 6px;
		height: 101px;
		display: block;
		border-radius: 1px;
		color:#8e8e8e;
		font:12px/20px 微软雅黑;
	}
	ul.imgs li{	
		float: left;
		margin: 0 0 15px 15px;
		position: relative;
	}
	ul.imgs li img{
		border: 2px solid #fff;
		box-shadow: 1px 0px 2px rgba(6,0,1,0.38)
	}
	ul.imgs li em{
		width: 20px;
		height: 20px;
		position: absolute;
		display: block;
		right: -8px;
		top:-8px;
		background: url("../img/manage/icon_pic_del.png");
		background-size: 100% 100%;
	}
	ul.imgs li.add {
		height: 87px;
		width: 87px;
		background: url("../img/manage/icon_pic_add.png");
		background-size: 100% 100%;
	}
	ul.imgs li.add input{
		opacity: 0;
		height: 87px;
		width: 87px;
	}
	
	.btnPublish{		
		width: 116px;
		height: 34px;		
		font:14px/34px 微软雅黑;
		margin:10px auto 28px;
	}
</style>
</head>

<body>
<form action="/upload/savePic" method="" class="form" id="form1" enctype="multipart/form-data">
<div class="title">内容</div>

<div class="txt"><textarea id="txt" id="txt" placeholder="请输入房源的整体描述"></textarea></div>
<div class="title">照片</div>
<ul class="imgs clearfix">
	<li class="add">
	<input type="file" name="upfile" accept="image/*" capture="camera" id="imageAdd" />

	</li>
</ul>
<a href="javascript:void(0);" id="btnPublish" class="btnPublish btn_pink" >发布</a>
</form>
<script type="text/javascript">
function q(a, e, c) 
	{
		if(a&&"string"===typeof a)
		{
			"object"!==typeof e&&(e={});
			var d=(P++).toString();
			"function"===typeof c&&(F[d]=c);
			a={func:a,params:e};
			a[I]="call";
			a[E]=d;
			d=y.stringify(a);
			J.push(d);document.location=Q
		}
	}

	/**
	 * 检测微信JsAPI
	 * @param callback
	 */
	// function detectWeixinApi(callback){
	//     if(typeof window.WeixinJSBridge == 'undefined' || typeof window.WeixinJSBridge.invoke == 'undefined'){
	//         setTimeout(function(){
	//             detectWeixinApi(callback);
	//         },200);
	//     }else{
	//         callback();
	//     }
	// }
	    
	// detectWeixinApi(function(){
	// 	$.ajax({
	//         url: "/upload/test?share=1",
	//         type:"get",
	//         dataType:"json",
	//         success: function (res) {
	//             //将上传成功后的提示打印到页面
	//             console.log('hha');
	//         },
	//         error:function(){
	//             console.log('失败');
	//         }
	//     });	
	// });
</script>
<script type="text/javascript">
	$(document).ready(function(){

		function detectWeixinApi(callback){
		    if(typeof window.WeixinJSBridge == 'undefined' || typeof window.WeixinJSBridge.invoke == 'undefined'){
		        setTimeout(function(){
		            detectWeixinApi(callback);
		        },200);
		    }else{
		        callback();
		    }
		}
	
		detectWeixinApi(function(){
			// document.write(window.WeixinJSBridge.call);
			WeixinJSBridge.on('menu:share:appmessage', function(argv){ 
				document.write('test');
			}); 
		});			

		//the del icon for remove the image	
		$('.imgs em').on("click", function() {
			if (confirm('确定要删除此照片吗？')) {
				$(this).parent().remove();
			}
		})
		//image added	
		function PreviewImage() {
	        var oFReader = new FileReader();
	        oFReader.readAsDataURL(document.getElementById("imageAdd").files[0]);

	        oFReader.onload = function (oFREvent) {
	            //document.getElementById("uploadPreview").src = oFREvent.target.result;
	            $("#imageAdd").parent().before('<li><img style="width: 83px; height:83px" src="' + oFREvent.target.result+ '" /><em></em></li>');
	        };
	    };
		document.getElementById('imageAdd').addEventListener('change', PreviewImage, false);

		//submit the form;
		$("#btnPublish").click(function(){
			$.ajax({
		        url: "/upload/savePic",
		        type: "POST",
		        data:document.getElementById("imageAdd").files[0],
		        processData: false,
		        contentType: false,
		        success: function (res) {
		            //将上传成功后的提示打印到页面
		            document.getElementById("response").innerHTML = res;
		        }
		    });
			// $(".form")[0].submit();
		})	
	});

</script>
</body>
</html>

