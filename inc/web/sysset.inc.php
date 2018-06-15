<?php
/**
 * Created by PhpStorm.
 * User: shizhongying
 * QQ : 214983937
 * Date: 7/21/15
 * Time: 09:47
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op']) ? 'shopset' : trim($_GPC['op']);
load()->func('tpl');
$set = pdo_fetch("select * from " . tablename('amouse_wxapp_sysset') . ' where `uniacid`=:uniacid limit 1', array(':uniacid' => $weid));
if (checksubmit('submit')) {
    $data2['mobile_verify_status'] = trim($_GPC['mobile_verify_status']);
    $data2['logo'] = trim($_GPC['logo']);
    $data2['copyright'] = trim($_GPC['copyright']);
    $data2['systel'] = trim($_GPC['systel']);
    $data2['sms_user'] = trim($_GPC['sms_user']);
    $data2['sms_secret'] = trim($_GPC['sms_secret']);
    $data2['sms_type'] = trim($_GPC['sms_type']);
    $data2['sms_template_code'] = trim($_GPC['sms_template_code']);
    $data2['sms_free_sign_name'] = trim($_GPC['sms_free_sign_name']);
    $data2['reg_sms_code'] = trim($_GPC['reg_sms_code']);
    $data2['enable'] = intval($_GPC['enable']) ;
    $data2['isshare'] = intval($_GPC['isshare']) ;
    $data2['iscreate'] =  intval($_GPC['iscreate']) ;
    $data2['public_status'] =  intval($_GPC['public_status']) ;
    if (empty($set)) {
        $data2['uniacid'] = $weid;
        pdo_insert('amouse_wxapp_sysset', $data2);
    } else {
        pdo_update('amouse_wxapp_sysset', $data2, array('uniacid' => $weid));
    }
    message('更新参数设置成功！', 'refresh');
}

if (checksubmit('confrimprint')) {
    load()->func('logging');
    $rnd = random(6, 1);
    $txt = "【微信验证】您的本次操作的验证码为：" . $rnd . ".十分钟内有效";
    include_once IA_ROOT . '/addons/amouse_orders/AliyunSms.php';
    if (empty($_GPC['sms_phone']) || empty($_GPC['sms_secret']) || empty($_GPC['sms_user'])) {
        message('设置好参数！', 'error');
    }
    $sms = new \AliyunSms();
    if ($set['_type'] == 0 && $set['sms_free_sign_name'] && $set['sms_template_code']) {
        if ($set['sms_type'] == 1) {
            $sms_param2 = "{\"number\":\"$rnd\"}";
            $sms->_sendNewDySms($_GPC['sms_phone'], $set['sms_user'], $set['sms_secret'], $set['sms_free_sign_name'], $set['mail_smtp'], $sms_param2, '1234');
        } else {
            $gname = $_W['account']['name'];
            $sms_param = "{\"number\":\"$rnd\",\"product\":\"$gname\"}";
            $sms->_sendAliDaYuSms($_GPC['sms_phone'], $set['sms_user'], $set['sms_secret'], $set['sms_free_sign_name'], $set['mail_smtp'], $sms_param);
        }
    }
}
include $this->template('web/_set');