<?php
global $_GPC,$_W;
$weid=intval($_W['uniacid']);
load()->func('tpl');
$operation=!empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($operation == 'display'){
    $slide=pdo_fetchall("SELECT * FROM ".tablename('amouse_wxapp_card_slide')." WHERE uniacid = '{$_W['uniacid']}' ");
} elseif($operation == 'post') {
    $id=intval($_GPC['id']);
    if(!empty($id)){
        $slide=pdo_fetch("SELECT * FROM ".tablename('amouse_wxapp_card_slide')." WHERE id = '$id'");
    }
    if(checksubmit('submit')){
        $data=array('uniacid'=>$_W['uniacid'], 'name'=>$_GPC['catename'], 'url'=>trim($_GPC['url']),'thumb'=>trim($_GPC['thumb']));
        if(!empty($id)){
            pdo_update('amouse_wxapp_card_slide', $data, array('id'=>$id));
        } else {
            pdo_insert('amouse_wxapp_card_slide', $data);
            $id=pdo_insertid();
        }
        message('更新幻灯片成功！', $this->createWebUrl('slide', array('op'=>'display')), 'success');
    }

} elseif($operation == 'delete') {
    $id=intval($_GPC['id']);
    $category=pdo_fetch("SELECT id FROM ".tablename('amouse_wxapp_card_slide')." WHERE id = '$id'");
    if(empty($category)){
        message('抱歉，幻灯片不存在或是已经被删除！', $this->createWebUrl('slide', array('op'=>'display')), 'error');
    }
    pdo_delete('amouse_wxapp_card_slide', array('id'=>$id));
    message('幻灯片删除成功！', $this->createWebUrl('slide', array('op'=>'display')), 'success');
}

include $this->template('web/slide');