<?php
/**
 * 五金店-pretty模块微站定义
 *
 * @author pretty
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Store_prettyModuleSite extends WeModuleSite {

	public function doMobileStore() {
		//这个操作被定义用来呈现 功能封面
	}
	public function doWebGoods() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	public function doMobileOrders() {
		//这个操作被定义用来呈现 微站个人中心导航
	}

}