<?php

namespace App\Console\Commands;

use App\Models\Area;
use App\Models\City;
use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CreateZoneCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:zone_cache {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成区域缓存文件到文件中';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //生成省
        if(in_array($this->argument('type'), ['province', 'all'])) {
            $provinces = Province::get()->toArray();
            $out_provinces = [];
            foreach ($provinces AS $v) {
                $out_provinces[$v['code']] = $v['name'];
                //城市与市区对应
                $out_cities = City::where('provincecode', $v['code'])->pluck('name', 'code');
                Redis::set('province_city'.$v['code'], json_encode($out_cities));
            }
            Redis::set('province_cache', json_encode($out_provinces));
        }

        //生成市
        if(in_array($this->argument('type'), ['city', 'all'])) {
            $cities = City::get()->toArray();
            $out_cities = [];
            foreach ($cities AS $v) {
                $out_cities[$v['code']] = $v['name'];
            }
            Redis::set('city_cache', json_encode($out_cities));

        }

        //生成区县
        if(in_array($this->argument('type'), ['area', 'all'])) {

            $areas = Area::where('id', '<', 1600)->get()->toArray();
            $out_areas = [];
            foreach ($areas AS $v) {
                $out_areas[$v['code']] = $v['name'];
            }
            Redis::set('area_cache_part1', json_encode($out_areas));

            $areas2 = Area::where('id', '>=', 1600)->get()->toArray();
            $out_areas2 = [];
            foreach ($areas2 AS $val) {
                $out_areas2[$val['code']] = $val['name'];
            }
            Redis::set('area_cache_part2', json_encode($out_areas2));
        }
    }
}
