<?php
/**
 * 便利店模块微站定义
 *
 * @author Gorden
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class We7_storeModuleSite extends WeModuleSite {
	// category 表名
	private $tb_category = 'we7_store_category';
	public function doMobileStore() {
		//这个操作被定义用来呈现 功能封面
	}
	public function doWebGoods() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	public function doMobileOrders() {
		//这个操作被定义用来呈现 微站个人中心导航
		echo 'aaa';
	}
	/**
	 * 获取所有商品分类
	 * @return array(cid=>category, ...)
	 */
	private function getAllCategory(){
		global $_W;
	
		$sql = 'SELECT * FROM '.tablename($this->tb_category).' WHERE uniacid=:uniacid ORDER BY `orderno` asc, id asc';
		$params = array(
				':uniacid' => $_W['uniacid']
		);
		$categories = pdo_fetchall($sql, $params, 'id');
	
		return $categories;
	}
	
	public function doWebCategory() {
		global $_W, $_GPC;
	
		$ops = array('display', 'create', 'delete'); // 只支持此 3 种操作.
		$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'display';
	
		if($op == 'display'){
	
			// 处理 POST 提交
			if (checksubmit()){
				$cats = $_GPC['categories'];
	
				// 表单验证
				if(empty($cats)){
					message('尚未添加任何分类.');
				}
				foreach ($cats as $k => $cat){
					empty($cat['name']) && message('有分类名称未添加,无法保存.');
					$cat['orderno'] = intval($cat['orderno']);
				}
	
				// 数据更新
				foreach ($cats as $k => $cat){
					pdo_update($this->tb_category, $cat, array('id'=>$k));
				}
				message('保存成功.','','success');
			}
	
			// 处理 GET 提交
			$categories = $this->getAllCategory();
	
			load()->func('tpl');
			include $this->template('category');
		}
	
		if ($op == 'create') {
	
			if (checksubmit()) {
				$category = $_GPC['category']; // 获取打包值
				if(empty($category['name'])){
					message('未添加分类名称, 无法保存');
				}
	
				$category['uniacid'] = $_W['uniacid'];
				$category['orderno'] = intval($cat['orderno']);
	
				pdo_insert($this->tb_category, $category);
	
				message('添加分类成功',$this->createWebUrl('category', array('op'=>'display')),'success');
			}
	
			include $this->template('category');
		}
	
		if($op == 'delete') {
			$id = intval($_GPC['id']);
			if(empty($id)){
				message('未找到指定商品分类');
			}
			$result = pdo_delete($this->tb_category, array('id'=>$id, 'uniacid'=>$_W['uniacid']));
			if(intval($result) == 1){
				message('删除商品分类成功.', $this->createWebUrl('category'), 'success');
			} else {
				message('删除商品分类失败.');
			}
		}
	}
}