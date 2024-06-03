<?php

define('DEBUG', 2);
define('APP_PATH', realpath(dirname(__FILE__).'/../').'/');
define('INSTALL_PATH', dirname(__FILE__).'/');

define('MESSAGE_HTM_PATH', INSTALL_PATH.'view/htm/message.htm');

// 切换到上一级目录，操作很方便。

$conf = (include APP_PATH.'conf/conf.default.php');
$lang = include APP_PATH."lang/$conf[lang]/bbs.php";
$lang += include APP_PATH."lang/$conf[lang]/bbs_install.php";
$conf['log_path'] = APP_PATH.$conf['log_path']; 
$conf['tmp_path'] = APP_PATH.$conf['tmp_path']; 

include APP_PATH.'xiunophp/xiunophp.php';
include APP_PATH.'model/misc.func.php';
include APP_PATH.'model/plugin.func.php';
include APP_PATH.'model/user.func.php';
include APP_PATH.'model/group.func.php';
include APP_PATH.'model/form.func.php';
include APP_PATH.'model/forum.func.php';
include INSTALL_PATH.'install.func.php';

$action = param('action');

// 安装初始化检测,放这里
is_file(APP_PATH.'conf/conf.php') AND DEBUG != 2 AND message(0, jump(lang('installed_tips'), '../'));

// 从 cookie 中获取数据，默认为中文
$_lang = param('lang', 'zh-cn');



// 第一步，阅读
if(empty($action)) {
	
	if($method == 'GET') {
		$input = array();
		$input['lang'] = form_select('lang', array('zh-cn'=>'简体中文', 'zh-tw'=>'正體中文', 'en-us'=>'English', 'ru-ru'=>'Русский', 'th-th'=>'ไทย'), $conf['lang']);
		
		// 修改 conf.php
		include INSTALL_PATH."view/htm/index.htm";
	} else {
		$_lang = param('lang');
		!in_array($_lang, array('zh-cn', 'zh-tw', 'en-us', 'ru-ru', 'th-th')) AND $_lang = 'zh-cn';
		setcookie('lang', $_lang);
		
		//$conf['lang'] = $_lang;
		//xn_copy(APP_PATH.'./conf/conf.default.php', APP_PATH.'./conf/conf.backup.php');
		//$r = file_replace_var(APP_PATH.'conf/conf.default.php', array('lang'=>$_lang));
		//$r === FALSE AND message(-1, jump(lang('please_set_conf_file_writable'), ''));
		
		http_location('index.php?action=license');
	}
	
} elseif($action == 'license') {
	
	
	// 设置到 cookie
	
	include INSTALL_PATH."view/htm/license.htm";
	
} elseif($action == 'env') {
	
	if($method == 'GET') {
		$succeed = 1;
		$env = $write = array();
		get_env($env, $write);
		include INSTALL_PATH."view/htm/env.htm";
	} else {
	
	}
	
} elseif($action == 'db') {
	
	if($method == 'GET') {
		
		$succeed = 1;
		$mysql_support = function_exists('mysql_connect');
		$pdo_mysql_support = extension_loaded('pdo_mysql');
		$myisam_support = extension_loaded('pdo_mysql');
		$innodb_support = extension_loaded('pdo_mysql');
		
		(!$mysql_support && !$pdo_mysql_support) AND message(-1, lang('evn_not_support_php_mysql'));

		include INSTALL_PATH."view/htm/db.htm";
		
	} else {
		
		$type = 'pdo_mysql';	
		$engine = 'innodb';	
		$host = param('host');	
		$name = param('name');	
		$user = param('user');
		$password = param('password', '', FALSE);
		$force = param('force');
		
		$adminemail = param('adminemail');
		$adminuser = param('adminuser');
		$adminpass = param('adminpass');
		
		empty($host) AND message('host', lang('dbhost_is_empty'));
		empty($name) AND message('name', lang('dbname_is_empty'));
		empty($user) AND message('user', lang('dbuser_is_empty'));
		empty($adminpass) AND message('adminpass', lang('adminuser_is_empty'));
		empty($adminemail) AND message('adminemail', lang('adminpass_is_empty'));
		
		
		
		// 设置超时尽量短一些
		//set_time_limit(60);
		ini_set('mysql.connect_timeout',  5);
		ini_set('default_socket_timeout', 5); 

		$conf['db']['type'] = $type;	
		$conf['db']['mysql']['master']['host'] = $host;
		$conf['db']['mysql']['master']['name'] = $name;
		$conf['db']['mysql']['master']['user'] = $user;
		$conf['db']['mysql']['master']['password'] = $password;
		$conf['db']['mysql']['master']['engine'] = $engine;
		$conf['db']['pdo_mysql']['master']['host'] = $host;
		$conf['db']['pdo_mysql']['master']['name'] = $name;
		$conf['db']['pdo_mysql']['master']['user'] = $user;
		$conf['db']['pdo_mysql']['master']['password'] = $password;
		$conf['db']['pdo_mysql']['master']['engine'] = $engine;
		
		$_SERVER['db'] = $db = db_new($conf['db']);
		// 此处可能报错
		$r = db_connect($db);
		if($r === FALSE) {
			if($errno == 1049 || $errno == 1045) {
				if($type == 'mysql') {
					mysql_query("CREATE DATABASE $name");
					$r = db_connect($db);
				} elseif($type == 'pdo_mysql') {
					if(strpos(':', $host) !== FALSE) {
						$arr = explode(':', $host);
						$host = $arr[0];
						$port = $arr[1];
					} else {
						//$host = $host;
						$port = 3306;
					}
					try {
						$attr = array(
							PDO::ATTR_TIMEOUT => 5,
							//PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
						);
						$link = new PDO("mysql:host=$host;port=$port", $user, $password, $attr);
						$r = $link->exec("CREATE DATABASE `$name`");
						if($r === FALSE) {
							$error = $link->errorInfo();
							$errno = $error[1];
							$errstr = $error[2];
						}
					} catch (PDOException $e) {
						$errno = $e->getCode();
						$errstr = $e->getMessage();
					}
				}
			}
			if($r === FALSE) {
				message(-1, "$errstr (errno: $errno)");
			}
		}
		
		$conf['cache']['mysql']['db'] = $db; // 这里直接传 $db，复用 $db；如果传配置文件，会产生新链接。
		$_SERVER['cache'] = $cache = !empty($conf['cache']) ? cache_new($conf['cache']) : NULL;
		
		// 设置引擎的类型
		if($engine == 'innodb') {
			$db->innodb_first = TRUE;
		} else {
			$db->innodb_first = FALSE;
		}
		
		// 连接成功以后，开始建表，导数据。
		
		install_sql_file(INSTALL_PATH.'install.sql');
		
		// 初始化
		copy(APP_PATH.'conf/conf.default.php', APP_PATH.'conf/conf.php');
		
		// 管理员密码
		$salt = xn_rand(16);
		$password = md5(md5($adminpass).$salt);
		$update = array('username'=>$adminuser, 'email'=>$adminemail, 'password'=>$password, 'salt'=>$salt, 'create_date'=>$time, 'create_ip'=>$longip);
		db_update('user', array('uid'=>1), $update);
		
		$replace = array();
		$replace['db'] = $conf['db'];
		$replace['auth_key'] = xn_rand(64);
		$replace['installed'] = 1;
		file_replace_var(APP_PATH.'conf/conf.php', $replace);
		
		// 处理语言包
		group_update(0, array('name'=>lang('group_0')));
		group_update(1, array('name'=>lang('group_1')));
		group_update(2, array('name'=>lang('group_2')));
		group_update(4, array('name'=>lang('group_4')));
		group_update(5, array('name'=>lang('group_5')));
		group_update(6, array('name'=>lang('group_6')));
		group_update(7, array('name'=>lang('group_7')));
		group_update(101, array('name'=>lang('group_101')));
		group_update(102, array('name'=>lang('group_102')));
		group_update(103, array('name'=>lang('group_103')));
		group_update(104, array('name'=>lang('group_104')));
		group_update(105, array('name'=>lang('group_105')));
		
		forum_update(1, array('name'=>lang('default_forum_name'), 'brief'=>lang('default_forum_brief')));
				
		xn_mkdir(APP_PATH.'upload/tmp', 0777);
		xn_mkdir(APP_PATH.'upload/attach', 0777);
		xn_mkdir(APP_PATH.'upload/avatar', 0777);
		xn_mkdir(APP_PATH.'upload/forum', 0777);
		
		message(0, jump(lang('conguralation_installed'), '../'));
	}
}


?>
