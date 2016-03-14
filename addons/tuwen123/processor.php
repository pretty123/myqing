<?php
/**
 * 图文回复-pretty模块处理程序
 *
 * @author pretty
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tuwen123ModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		$array[0]['title']="pretty";
		$array[1]['title']="pretty123";
		return $this->respNews($array);
	}
}