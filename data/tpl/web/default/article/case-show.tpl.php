<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/header-cms', TEMPLATE_INCLUDEPATH));?>
<link href="./resource/weidongli/css/cms.css" rel="stylesheet" type="text/css" />

<?php  if($do == 'list') { ?>
<div class="breadcrumbs margin-bottom-40 cl">
<div class="xiaoyu_container cl">
        <h1 class="color-green z"><a href="<?php  echo url('article/case-show/list');?>">案例动态</a></h1>
        <ul class="y breadcrumb">
        <li><a href="./" title="首页">首页</a> <span class="divider">/</span></li>
		<li><a href="<?php  echo url('article/case-show/list');?>">案例列表</a><span class="divider">/</span></li>
		<li class="active"><?php  if(!$cateid) { ?>所有案例<?php  } else { ?><?php  echo $catecases[$cateid]['title'];?><?php  } ?></li>
        </ul>
</div>
</div>
<div class="xiaoyu_container cl">
	<div class="fishue_unnew_left"> 
    <div class="col-md-9 md-margin-bottom-40 cl">
		<ul class="m_Grid0">  
	<?php  if(is_array($data)) { foreach($data as $da) { ?>		
            <li class="box1">                   
                 <a href="<?php  echo url('article/case-show/detail', array('id' => $da['id']));?>" target="_blank"><img src="<?php  echo tomedia($da['thumb']);?>" height="182" width="220"></a>
                 <p class="p1"><a href="<?php  echo url('article/case-show/detail', array('id' => $da['id']));?>" target="_blank"><?php  echo $da['title'];?></a>
                 </p>                
            </li>
	<?php  } } ?>
		</ul>
		<div class="xiaoyu_bottom_border"></div>
    </div>
		<?php  echo $pager;?>
 </div>
 	<!--右栏-->
 <div class="y pph xiaoyu_view_sd"> 
   <div class="col-md-3"> 
    <div class="headline headline-md">
     <h2>相关分类</h2>
    </div> 
    <div class="tab-v2 margin-bottom-40"> 
	<ul id="myTab1" class="tabHover nav-tabs cl"> 
            <li class="active"><a href="javascript:void(0);">相关分类</a></li>
     </ul>
     <div class="tab-content" id="myTab1_con">       
      <div class="tab-pane J-tab active" style="display: block;"> 
       <div class="row"> 
        <ul class="list-unstyled xiaoyu_tab_other cl">
<?php  if(is_array($catecases)) { foreach($catecases as $catecase) { ?>		
         <li><a href="<?php  echo url('article/case-show/list', array('cateid' => $catecase['id']));?>"><?php  echo $catecase['title'];?></a></li>           
<?php  } } ?>    
        </ul> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>
</div>
	<?php  } ?>
	<?php  if($do == 'detail') { ?>
<div class="breadcrumbs margin-bottom-40 cl">
<div class="xiaoyu_container cl">
        <h1 class="color-green z"><a href="<?php  echo url('article/case-show/list');?>">案例动态</a></h1>
        <ul class="y breadcrumb">
        <li><a href="./" title="首页">首页</a> <span class="divider">/</span></li>
		<li><a href="<?php  echo url('article/case-show/list');?>">案例列表</a><span class="divider">/</span></li>
		<li class="active"><?php  echo $case['title'];?></li>
        </ul>
</div>
</div>
<div class="xiaoyu_container cl">
<div class="fishue_unnew_left"> 
	<div class="ghinfo clearfix">
            <div class="ghavatar">
                <img src="<?php  echo tomedia($case['thumb']);?>"style=" width: 120px; height: 120px;">
                <span>浏览量：<font color="red"><?php  echo $case['click'];?></font></span>
            </div>
            <div class="wxinfo">
                <h2>
                    <a href="<?php  echo url('article/case-show/list');?>"><?php  echo $case['title'];?></a><br>
                </h2>
                <div class="wxrow">
                    <label>微信号：</label>
                    <span><?php  echo $case['weixinh'];?></span>
                </div>
                <div class="wxrow">
                    <label>微信标签：</label>
                    <span class="taglis">
                        <em class="tag-0"><?php  echo $case['weixintag'];?></em> </span>
                </div>
                <div class="wxrow">
                    <label>收录时间：</label>
                    <span><?php  echo date('Y-m-d H:i', $case['createtime']);?></span>
                </div>
                <div style="margin:0px auto;">
                    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
					<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                </div>
            </div>
            <div class="qrcode">
                <img src="<?php  echo tomedia($case['thumb']);?>" style=" width: 150px; height: 150px;">
            </div>
        </div>
		<div class="case-box">
            <h3>微信公众号描述：</h3>
            <p><?php  echo $case['content'];?></p>
		</div>
</div>
  <div class="y pph xiaoyu_view_sd"> 
   <div class="col-md-3"> 
    <div class="headline headline-md">
     <h2>相关分类</h2>
    </div> 
    <div class="tab-v2 margin-bottom-40"> 
     <div class="tab-content" id="myTab1_con">       
      <div class="tab-pane J-tab active"> 
       <div class="row"> 
        <ul class="list-unstyled xiaoyu_tab_other cl">
<?php  if(is_array($catecases)) { foreach($catecases as $catecase) { ?>		
         <li><a href="<?php  echo url('article/case-show/list', array('cateid' => $catecase['id']));?>"><?php  echo $catecase['title'];?></a></li>           
<?php  } } ?>    
        </ul> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>
</div>
	<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-cms', TEMPLATE_INCLUDEPATH));?>
