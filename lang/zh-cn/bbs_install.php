<?php

return array(
	'installed_tips' => '程序已经安装过了，如需重新安装，请删除 conf/conf.php ！',
	'please_set_conf_file_writable' => '请设置 conf/conf.php 文件为可写！',
	'evn_not_support_php_mysql' => '当前 PHP 环境不支持 mysql 和 pdo_mysql，无法继续安装。',
	'dbhost_is_empty' => '数据库主机不能为空',
	'dbname_is_empty' => '数据库名不能为空',
	'dbuser_is_empty' => '用户名不能为空',
	'adminuser_is_empty' => '管理员用户名不能为空',
	'adminpass_is_empty' => '管理员密码不能为空',
	'conguralation_installed' => '恭喜，安装成功！为了安全请删除 install 目录。',
	
	'step_1_title' => '一、安装环境检测',
	'runtime_env_check' => '网站运行环境检测',
	'required' => '需要',
	'current' => '当前',
	'check_result' => '检测结果',
	'passed' => '通过',
	'not_passed' => '通过',
	'not_the_best' => '不是最理想的环境',
	'dir_writable_check' => '目录 / 文件 权限检测',
	'writable' => '可写',
	'unwritable' => '不可写',
	'check_again' => '重新检测',
	'os' => '操作系统',
	'unix_like' => '类 UNIX',
	'php_version' => 'PHP 版本',
	
	'step_2_title' => '二、数据库设置',
	'db_type' => '数据库类型',
	'db_engine' => '数据库引擎',
	'db_host' => '数据库服务器',
	'db_name' => '数据库名',
	'db_user' => '数据库用户名',
	'db_pass' => '数据库密码',
	'step_3_title' => '三、管理员信息',
	'admin_email' => '管理员邮箱',
	'admin_username' => '管理员用户名',
	'admin_pw' => '管理员密码',
	'installing_about_moment' => '正在安装，大概需要一分钟左右',
	'license_title' => 'Xiuno BBS 4.0 中文版授权协议',
	'license_content' => 'Xiuno BBS 4.0 采用 MIT 协议发布，您可以自由修改、派生版本、商用而不用担心任何法律风险。',
	'license_date' => '发布时间：2018年1月22日',
	'agree_license_to_continue' => '同意协议继续安装',
	'install_title' => 'Xiuno BBS 4.0 安装向导',
	'install_guide' => '安装向导',
	
	'function_check' => '函数依赖检查',
	'supported' => '支持',
	'not_supported' => '不支持',
	'function_glob_not_exists' => '后台插件功能依赖该函数，请配置 php.ini，设置 disabled_functions = ; 去除对该函数的限制',
	'function_gzcompress_not_exists' => '后台插件功能依赖该函数，Linux 主机请添加编译参数 --with-zlib，Windows 主机请配置 php.ini 注释掉 extension=php_zlib.dll',
	'function_mb_substr_not_exists' => '系统依赖该函数，Linux 主机请添加编译参数 --with-mbstring，Windows 主机请配置 php.ini 注释掉 extension=php_mbstring.dll',
	
	// hook lang_zh_cn_bbs_install.php

);

?>
