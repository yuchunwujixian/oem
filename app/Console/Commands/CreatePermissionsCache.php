<?php

namespace App\Console\Commands;

use App\Models\Admin\Permission;
use Illuminate\Console\Command;
use Cache, DB;

class CreatePermissionsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新权限列表，并保存到到本地文件中';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //清除权限表数据
        Permission::truncate();
        //插入新的数据
        $_sql = file_get_contents(database_path('sql').'/hyh_admin_permissions.sql');
        $_arr = explode(';', $_sql);
        foreach ($_arr as $_value) {
            if ($_value){
                DB::insert($_value.';');
            }
        }
        //写入cache file缓存
        $permissions = Permission::where('is_menu', 1)->get();
        Cache::store('file')->forever('menus', $permissions);
    }
}
