<?php
/**
 * --------------------------------------------
 * Desc：
 * User: Jiafang.Wang
 * Date: 2017/4/24 13:51
 * File: function.php
 * --------------------------------------------
 */
/**
 * @desc 时间转化
 * @param $the_time
 * @since 2017/4/24 13:54
 * @author Jiafang.Wang
 * @return string
 */
function time_tran($the_time)
{
    $now_time = date("Y-m-d H:i:s", time() + 8 * 60 * 60);
    $now_time = strtotime($now_time);
    $show_time = strtotime($the_time);
    $dur = $now_time - $show_time;
    if ($dur < 0) {
        return $the_time;
    } else {
        if ($dur < 60) {
            return $dur . '秒前';
        } else {
            if ($dur < 3600) {
                return floor($dur / 60) . '分钟前';
            } else {
                if ($dur < 86400) {
                    return floor($dur / 3600) . '小时前';
                } else {
                    if ($dur < 259200) {//3天内
                        return floor($dur / 86400) . '天前';
                    } else {
                        return date("Y-m-d", strtotime($the_time));
                    }
                }
            }
        }
    }
}