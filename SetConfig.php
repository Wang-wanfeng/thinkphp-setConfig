<?php

// +----------------------------------------------------------------------
// | Author: WangWanFeng <wangwanfeng1996@gmail.com>
// +----------------------------------------------------------------------
// | Date: 2019.1.13
// +----------------------------------------------------------------------
// | Time: 12:50
// +----------------------------------------------------------------------
// | Copyright (c) 2018~2019 https://wangwanfeng.com All rights reserved.
// +----------------------------------------------------------------------

namespace setConfig;


class SetConfig
{

	
	public function getConfig()
	{
		$config_file = require(APP_PATH.'/config.php');

		$this->config = $config_file;

	}

	public function setConfig($param = '', $replacement = '')
	{
		$this->getConfig();

		$param = explode(',', $param);
		$replacement = explode(',', $replacement);

		if (count($param) != count($replacement)) {
			return json(['error_code' => 300, 'msg' => '参数不合法。']);
		}

		for ($i = 0; $i < count($param); $i++) { 
			if (preg_match('/\./', $param[$i])) {
				$new_param = explode('.', $param[$i]);

				if (count($new_param) > 2) {
					$res[] = ['pointer' => $i, 'config_name' => $param[$i], 'error_code' => 201, 'msg' => '只能修改二级配置'];
				} elseif (!is_array($this->config[$new_param[0]])) {
					$res[] = ['pointer' => $i, 'config_name' => $param[$i], 'error_code' => 202, 'msg' => '原配置无二级配置'];
				} else {
					if (!array_key_exists($new_param[$i], $this->config)) {
						$this->config[$new_param[$i]] = [];
					}
					$config = $this->config[$new_param[$i]];
					$config[$new_param[$i+1]] = $replacement[$i];
					$new_config[$new_param[$i]] = $config;
					$this->config = array_merge($this->config, $new_config);
					$res[] = ['pointer' => $i, 'config_name' => $param[$i], 'error_code' => 0, 'msg' => '成功'];
				}
			} else {
				$this->config[$param[$i]] = $replacement[$i];
				$res[] = ['pointer' => $i, 'config_name' => $param[$i], 'error_code' => 0, 'msg' => '成功'];
			}
		}

		$config_str = "<?php\r\n\r\nreturn ".var_export($this->config,true).";";
		rename(APP_PATH."/config.php", APP_PATH."/config.php.bak");
		file_put_contents(APP_PATH."/config.php", $config_str);

		return $res;
	}

}