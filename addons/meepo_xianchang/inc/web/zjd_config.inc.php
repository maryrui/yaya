<?php
/**
 * MEEPO 米波现场
 *
 * 官网 http://meepo.com.cn 赞木 作者QQ 284099857
 */
global $_W,$_GPC;
$weid = $_W['uniacid'];
$id = $rid = $_GPC['id'];
$zjd_config = pdo_fetch("SELECT * FROM ".tablename($this->zjd_config_table)." WHERE weid = :weid AND rid=:rid",array(':weid'=>$weid,':rid'=>$rid));
if(empty($zjd_config)){
	$zjd_config['lottory_type']  = 1;
	$zjd_config['send_mess']  = 0;
	$zjd_config['title']  = '抽奖';
	$zjd_config['def_mess']  = "亲爱的@你已经中了#、奖品为:*、请按照主持人的提示，到指定地点领取您的奖品！\n您的获奖验证码是:%";
}
if(checksubmit('submit')){
	$data = array();
	$data['send_mess'] = intval($_GPC['send_mess']);
	$data['def_mess'] = $_GPC['def_mess'];
	$data['lottory_type'] = intval($_GPC['lottory_type']);
	$data['title'] = $_GPC['title'];
	$data['weid'] = $weid;
	$data['rid'] = $rid;
	$zjd_config_id = intval($_GPC['zjd_config_id']);
	if(empty($lottory_config_id)){
		pdo_insert($this->zjd_config_table,$data);
		message('保存成功',$this->createWebUrl('zjd_config',array('id'=>$id)),"success");
	}else{
		pdo_update($this->zjd_config_table,$data,array('id'=>$lottory_config_id,'weid'=>$weid));
		message('更新成功',$this->createWebUrl('zjd_config',array('id'=>$id)),"success");
	}
	
}
include $this->template('zjd_config');
 
      
