<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
$dos = array();
$do = in_array($do, $dos) ? $do : 'index';
$_W['page']['title'] = '店员工作台';

if($do == 'index') {
	load ()->model ('clerk');
	$permission = clerk_permission_list();
	foreach ($permission as $name =>  $perm) {
		$post = array();
		$post['group_name'] = $name;
		$post['title'] = $perm['title'];
		$post['uniacid'] = $_W['uniacid'];
		$post['system'] = 1;
		$system_exist = pdo_get('activity_clerk_menu', array('uniacid' => $_W['uniacid'], 'system' => 1, 'title' => $post['title']));
		if (!empty($system_exist)) {
			continue;
		}
		pdo_insert('activity_clerk_menu', $post);
		$pid = pdo_insertid();
		foreach ($perm['items'] as $key =>  $value) {
			$post = array();
			$post['pid'] = $pid;
			$post['uniacid'] = $_W['uniacid'];
			$post['title'] = $value['title'];
			$post['icon'] = $value['icon'];
			$post['type'] = $value['type'];
			$post['url'] = $value['url'];
			if ($post['type'] == 'modal') {
				$post['url'] = $value['data'];
			}
			$post['permission'] = $value['permission'];
			$post['system'] = 1;
			pdo_insert('activity_clerk_menu', $post);
		}
	}
	$clerk_p = pdo_fetchall("SELECT * FROM ". tablename('activity_clerk_menu'). " WHERE uniacid = :uniacid AND pid = 0", array(':uniacid' =>  $_W['uniacid']));
	$clerk_c = pdo_fetchall("SELECT * FROM ". tablename('activity_clerk_menu'). " WHERE uniacid = :uniacid AND pid <> 0 ORDER BY displayorder ASC", array(':uniacid' =>  $_W['uniacid']));
	$permission = array();
	foreach ($clerk_p as $p) {
		$permission[$p['id']]['id'] = $p['id'];
		$permission[$p['id']]['pid'] = $p['id'];
		$permission[$p['id']]['title'] = $p['title'];
		$permission[$p['id']]['system'] = $p['system'];
	}
	foreach ($clerk_c as $c) {
		$permission[$c['pid']]['items'][] = $c;
	}
	$user_permission = uni_user_permission_exist ();
	if (is_error ($user_permission)) {
		$user_permission = uni_user_permission ('system');
		foreach ($permission as $key => &$row) {
			$has = 0;
			foreach ($row['items'] as $key1 => &$row1) {
				if (!in_array ($row1['id'], $user_permission)) {
					unset($row['items'][$key1]);
				} else {
					if (!$has) {
						$has = 1;
					}
				}
			}
			if (!$has) {
				unset($permission[$key]);
			}
		}
	}
}
template('activity/desk');
