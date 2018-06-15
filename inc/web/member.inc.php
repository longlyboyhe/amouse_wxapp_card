<?php

global $_W, $_GPC;
$weid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] : "display";
if($op == 'display'){
    $pindex=intval($_GPC['page']) ? intval($_GPC['page']) : 1;
    $psize=10;
    $sql=" where uniacid = :weid   ";
    $params[':weid']=$_W['uniacid'];
    if(isset($_GPC['keywords'])){
        $sql=' AND `username` LIKE :keywords';
        $params[':keywords']="%{$_GPC['keywords']}%";
    }
    if(isset($_GPC['keywords1'])){
        $sql.=' AND `phone` LIKE :keywords1';
        $params[':keywords1']="%{$_GPC['keywords1']}%";
    }
    $list=pdo_fetchall("SELECT * FROM ".tablename('amouse_wxapp_member').$sql." limit ".($pindex-1) * $psize.",".$pindex * $psize, $params);
    $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('amouse_wxapp_member').$sql, $params);
    $pager=pagination($total, $pindex, $psize);
} elseif($op == 'change') {
    $id=intval($_GPC['id']);
    $status=$_GPC['status'];
    if($id){
        pdo_update('amouse_wxapp_member', array('status'=>$status), array('id'=>$id));
    }
    message('设置会员状态数据成功！', $this->createWebUrl('member', array('op'=>'display')), 'success');
} elseif($op == 'del') {
    $id=intval($_GPC['id']);
    if($id){
        pdo_delete('amouse_wxapp_member', array('id' => $id));
    }
    message('删除会员数据成功！', $this->createWebUrl('member', array('op'=>'display')), 'success');
}
include $this->template('web/member');