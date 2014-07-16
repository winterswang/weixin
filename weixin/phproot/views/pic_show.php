<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="format-detection" content="email=no" />
    <meta name="format-detection" content="address=no;">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <title><?=$this->meta['title']?></title>
    <link rel="stylesheet" href="/css/main.css?<?=time()?>" />
    <link rel="stylesheet" href="/css/idangerous.swiper.css" />
    <style>
      /* Demo Styles */
      html {
        height: 100%;
      }
      body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        line-height: 1.5;
        position: relative;
        height: 100%;
      }
      .swiper-container {
        width: 100%;
        height: 100%;
        color: #fff;
        text-align: center;
        vertical-align: middle;
      }
      .pagination {
        position: absolute;
        z-index: 20;
        left: 10px;
        bottom: 10px;
      }
      .swiper-pagination-switch {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 8px;
        background: #222;
        margin-right: 5px;
        opacity: 0.8;
        border: 1px solid #fff;
        cursor: pointer;
      }
      .swiper-visible-switch {
        background: #aaa;
      }
      .swiper-active-switch {
        background: #fff;
      }
      .swiper-slide .tpl-url {
        height: 100%;
        width: auto;
        margin-top:-10px;
        vertical-align: middle;
        display: -webkit-box;
        -webkit-box-orient: horizontal;
        -webkit-box-pack: center;
        -webkit-box-align: center;
        display: -moz-box;
        -moz-box-orient: horizontal;
        -moz-box-pack: center;
        -moz-box-align: center;
        display: -o-box;
        -o-box-orient: horizontal;
        -o-box-pack: center;
        -o-box-align: center;
        display: -ms-box;
        -ms-box-orient: horizontal;
        -ms-box-pack: center;
        -ms-box-align: center;
        display: box;
        box-orient: horizontal;
        box-pack: center;
        box-align: center;
      }
      .swiper-slide .tpl-url img{
        display: block;
        height: auto;
        margin: 0;
        padding: 0;
        width: 100%;
        vertical-align: middle;
      }
      .mask {
        background-color: #222222;
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: -998;
      }
    </style>
</head>
<body>
  <div class="mask"></div>
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <?php foreach($data as $house): ?> 
      <div class="swiper-slide">
        <div class="tpl-url"><img src="<?=$house['url']?>" /></div>  
      </div>
      <?php endforeach; ?>
    </div>
    <div class="pagination"></div>
  </div>
  <script src="/js/idangerous.swiper-2.1.js"></script>
  <script src="/js/jquery-1.9.1.min.js"></script>
  <script>
  var mySwiper = new Swiper('.swiper-container',{
    slidesPerView: 1,
    centeredSlides:true,
    pagination: '.pagination',
    paginationClickable: true,
    onSlideClick: function(){
      history.back();
    }
  })
  mySwiper.swipeTo( <?=$start_index ?>);
  </script>
</body>
</html>