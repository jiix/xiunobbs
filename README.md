# 介绍
Xiuno BBS 4.0 是一款高性能轻论坛产品，采用 MIT 协议发布，您可以自由修改、派生版本、商用而不用担心任何法律风险。

## 截屏
![image](https://raw.githubusercontent.com/jiix/xiunobbs/master/screenshot.png)

## 使用
使用请下载发布版，集成较少插件。数据库请采用**utf8mb4**，安装完成后，请删除install目录。
插件和主题，直接上传到**plugin**目录中，后台插件中心开启。

安装插件后若出现问题，请先清理缓存（后台 - 其他 - 清理缓存）。

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

- [ ] 整理修复部分插件
- [ ] 添加简约风、acg风格、绿色小清新风格主题。
- [ ] 更新bootstrap

## 贡献者
创始人：axiuno

感谢：cnteacher@discuz、Discuz!、Team Artery、剑心@wooyun、右键森林、吴兆焕、杨永全、郑城、大象、燃烧的冰、⭐Star本项目的您。

## Enjoy!
