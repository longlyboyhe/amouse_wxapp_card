<?php
global $_W,$_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
load()->func('tpl');
$weid=intval($_W['uniacid']);
if ($operation == 'display') {
    $condition = '';
    $stat = $_GPC['status'];
    if (checksubmit('submit1') && !empty($_GPC['delete'])) {
        pdo_delete('amouse_wxapp_card', " id  IN  ('" . implode("','", $_GPC['delete']) . "')");
        message('批量处理成功！', $this->createWebUrl('cards', array('page' => $_GPC['page'])));
    }
    if (!empty($_GPC['mobile'])) {
        $condition .= " AND a.mobile LIKE '%{$_GPC['mobile']}%'";
    }
    if (!empty($_GPC['username'])) {
        $condition .= " AND a.username LIKE '%{$_GPC['username']}%'";
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT a.* FROM " . tablename('amouse_wxapp_card') . " as a WHERE a.uniacid = $weid $condition ORDER BY a.id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('amouse_wxapp_card') . " as a WHERE a.uniacid = $weid  $condition");
    $pager = pagination($total, $pindex, $psize);
    if (!empty($list)) {
        foreach ($list as $key => $card) {
            $list[$key]['avater'] = tomedia($card['avater']);
            $imgs = iunserializer($card['imgs']);
            foreach ($imgs as $k => $imgid) {
                $imgs[$k] = tomedia($imgid);
            }
            $list[$key]['imgs'] = $imgs;
        }
    }

} elseif ($operation == 'detail') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT *  FROM " . tablename('amouse_wxapp_card') . " WHERE  id =$id AND uniacid=" . $weid);

} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $order = pdo_fetch("SELECT id  FROM " . tablename('amouse_wxapp_card') . " WHERE id = $id AND uniacid=" . $weid);
    if (empty($order)) {
        message('抱歉，不存在，或者已经删除！', $this->createWebUrl('cards', array('op' => 'display')), 'error');
    }
    pdo_delete('amouse_wxapp_card', array('id' => $id));

    message('删除成功！', $this->createWebUrl('cards', array('op' => 'display')), 'success');
}elseif($operation=='clear'){
    $id = intval($_GPC['id']);
    $sql ="update  ".tablename('amouse_wxapp_card')."  set `qrcode`='' where `id`='$id' ";
    pdo_query($sql);
    message('清除二维码成功！', $this->createWebUrl('cards', array('op' => 'display')), 'success');
}
include $this->template('web/card');