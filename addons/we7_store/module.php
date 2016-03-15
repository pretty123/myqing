<?php
/**
 * 便利店模块定义
 *
 * @author Gorden
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
 
class We7_storeModule extends WeModule {
 
	public function settingsDisplay($settings) {
 
		// 声明为全局才可以访问到.
		global $_W, $_GPC;
 
		// 验证表单来源安全
		if(checksubmit()) {
 
			// $_GPC 可以用来获取 Cookies,表单中以及地址栏参数
			$dat = $_GPC['data'];
 
			// 验证表单, 通过 message() 方法提示用户操作错误信息
			empty($dat['name']) && message('请填写便利店名称');
			empty($dat['logo']) && message('请填写便利店 LOGO');
			empty($dat['linkman']) && message('请填写便利店联系人');
			empty($dat['phone']) && message('请填写便利店联系电话');
			empty($dat['address']) && message('请填写便利店地址');
			empty($dat['description']) && message('请填写便利店介绍');
 
			//字段验证, 并获得正确的数据$dat
			if (!$this->saveSettings($dat)) {
				message('保存信息失败','','error');   // 保存失败
			} else {
				message('保存信息成功','','success'); // 保存成功
			}
		}
 
		// 模板中需要用到 "tpl" 表单控件函数的话, 记得一定要调用此方法.
		load()->func('tpl');
 
		// 调用模板, 展示参数设置表单
		include $this->template('setting');
	}
 
}