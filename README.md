# 介绍
Xiuno BBS 4.0 是一款轻论坛产品。
本版本在消逝的官方git版本基础上，修复了php7.4和php8.0的兼容问题；采用utf8mb4，支持emoji；jQuery更新到 3.5.1；bootstrap更新到4.5.0。移除部分插件，更新默认主题。修复了若干小bug。
Xiuno BBS 4.0 采用 MIT 协议发布，您可以自由修改、派生版本、商用而不用担心任何法律风险。

## 我做了些什么

### 修复
- 修复php7.4兼容问题
- 修复php8.0兼容问题
- 修复php8.2兼容问题
- 修复无法卸载插件bug
- 修复后台插件页面无法打开
### 更新
- 💄默认主题更新
- 💥采用**utf8mb4**，支持emoji
- jQuery更新到 3.5.1
- 💥bootstrap更新到4.5.0
- 部分css、js改用min版，提高页面速度
- 移除IE hock
- 移除插件中心链接
- UMEditor 百度编辑器更新简约主题
### 增加部分插件
- 回复可见/登录可见
- 最新会员
- 帖子收藏
- 帖子点赞
- 简约单栏模板
- 大白·TinyMCE编辑器
- 大白·简约风格
- 消息系统
- 回帖排序
### 移除部分原始插件
* 在线手册（xn_manual）
* 返回顶部（z_top），后续会集成到主题中
* Xiuno BBS 测试插件 (xn_test)
* 屏幕阅读 ( xn_screen_reader)
* 幸运踩楼 (xn_lucky_post)
* 版块三级分类 (xn_forum_level_3)
* 我的第一个 Xiuno BBS 插件 (my_hello)
* 移除官方自带三款主题(xn_theme_red、 xn_theme_paopao、xn_theme_dark)，后续会添加简约风、acg主题、绿色小清新

## 截屏
![image](https://raw.githubusercontent.com/jiix/xiunobbs/master/screenshot.png)

## 使用
使用请下载发布版，集成较少插件。数据库请采用**utf8mb4**（utf8mb4_unicode_ci），安装完成后，请删除install目录。
插件和主题，直接上传到**plugin**目录中，后台插件中心开启。

### 伪静态
后台设置开启伪静态，添加对应的伪静态规则。

<details>
<summary>Apache伪静态:</summary>

```
<IfModule mod_rewrite.c>
RewriteEngine on

# Apache 2.4
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteCond %{REQUEST_FILENAME} !-f 
RewriteRule ^(.*?)([^/]*)$ $1index.php?$2 [QSA,PT,L]

# Apache other
#RewriteRule ^(.*?)([^/]*)\.htm(.*)$ $1/index.php?$2.htm$3 [L]
</IfModule>
```
</details>

<details>
<summary>Nginx伪静态:</summary>

```
location ~* \.(htm)$ {

    rewrite "^(.*)/(.+?).htm(.*?)$" $1/index.php?$2.htm$3 last;

}
```
</details>

<details>
<summary>Caddy伪静态（Caddyfile演示）：</summary>

```
www.yourdomain.com {

# Set this path to your site's directory.
root * /var/www

file_server

# Or serve a PHP site through php-fpm:
php_fastcgi localhost:9000
}

```
</details>


## 插件下载

临时插件仓库：[插件主题中心](https://github.com/jiix/plugins)

## 下一步

- [x] 增加插件仓库，添加常用插件。
- [x] 对php8进行适配。
- [x] 将部分设置选项（比如开启伪静态设置）集成到后台，方便管理员使用。
- [ ] 整理修复部分插件
- [ ] 添加简约风、acg风格、绿色小清新风格主题。
- [ ] 更新bootstrap

## 贡献者
创始人：axiuno

感谢：cnteacher@discuz、Discuz!、Team Artery、剑心@wooyun、右键森林、吴兆焕、杨永全、郑城、大象、燃烧的冰、⭐Star本项目的您。

## Enjoy!
