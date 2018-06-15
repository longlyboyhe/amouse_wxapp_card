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

load()->func('tpl');
$poster = pdo_fetch("select * from " . tablename('wxapp_card_poster') . ' where `uniacid`=:uniacid limit 1', array(':uniacid' => $weid));
if(!empty($poster)) {
    $data = json_decode(str_replace('&quot;', "'", $poster['data']), true);
}
if (checksubmit('submit')) {
    $data3 = array(
        'uniacid' => $_W['uniacid'],
        'bg' => tomedia($_GPC['bg']),
        'data' => htmlspecialchars_decode($_GPC['data']),
        'createtime' => time()
    );
    if (!empty($poster)) {
        pdo_update('wxapp_card_poster', $data3, array('id' => $poster['id'], 'uniacid' => $_W['uniacid']));
    } else {
        pdo_insert('wxapp_card_poster', $data3);
        $id = pdo_insertid();
    }
    message('更新参数设置成功！', 'refresh');
}

include $this->template('web/poster');