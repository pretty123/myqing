<?php
/**
 * 血型与运势-pretty模块处理程序
 *
 * @author pretty
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class BloodprettyModuleProcessor extends WeModuleProcessor {
// 	public function respond() {
// 		$content = $this->message['content'];
// 		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
// 	}
	public function respond() {
		if(!$this->inContext) {
			$reply = '请输入你的血型(A, B, O, AB), 来分析你今年的运程. ';
			$this->beginContext();
			// 如果是按照规则触发到本模块, 那么先输出提示问题语句, 并启动上下文来锁定会话, 以保证下次回复依然执行到本模块
		} else {
			$btypes = array('a', 'b', 'o', 'ab');
			$b = strtolower($this->message['content']);
			// 如果当前会话在上下文中, 那么表示当前回复是用户回答提示问题的答案.
			if(in_array($b, $btypes)) {
				switch($b) {
					case 'a':
						$reply = 'A型血今年.....';
						break;
					case 'b':
						$reply = 'B型血今年.....';
						break;
					case 'o':
						$reply = 'O型血今年.....';
						break;
					case 'ab':
						$reply = 'AB型血今年.....';
						break;
				}
				$this->endContext();
				// 如果当前回答符合答案格式, 那么进行保存并进行下一个问题. (可以保存至 SESSION 中)
				// 直到最后一个问题回答完成, 输出测试结果给用户, 并结束对话锁定. 以保证用户其他对话能正常路由.
				// 本示例只有一个问题, 因此不保存答案, 直接输出测试结果.
				// 如果对话默认的超时不够, 那么可以在每次提出下一个问题的时候重新调用 beginContext 来顺延超时.
			} else {
				$reply = '请输入正确的血型(A, B, O, AB). ';
				// 回答不符合答案格式, 那么重新显示当前问题.
			}
		}
	
		return $this->respTexta($reply);
		// 返回至系统
	}
	private function respTexta($content) {
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'text';
		$response['Content'] = htmlspecialchars_decode($content);
		return $response;
	}
}