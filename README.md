# OEM项目（PHP）

## 说明

基于laravel5.3进行项目的开发。

- RBAC
- laravel-debugbar
- log-viewer

拉取后执行
 composer update 安装相应插件
 php artisan key:generate
 php artisan migrate 牵引文件 创建数据表
 php artisan db:seed --class=AdminInitSeeder  牵入数据 导入sql数据
