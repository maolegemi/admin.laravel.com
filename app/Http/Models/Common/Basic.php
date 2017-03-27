<?php

namespace App\Http\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Basic extends Model
{
    //设置数据连接方法
    public function resetConnection($_connection)
    {
        $this->connection = $_connection;
        return $this->setConnection($this->connection);
    }
    //设置数据表格方法
    public function resetTable($_table)
    {
        $this->table = $_table;
        return $this->setTable($this->table);
    }
    //把数据转换为百分比
    public function toGetAPercent($molecule = 0, $denominator = 0)
    {
        $retStr = '';
        $retStr = $denominator ? bcmul(bcdiv($molecule, $denominator, 4), 100, 2) . '%' : 0;
        return $retStr;
    }
    //剪切
    public function cutStr($str, $length)
    {
        return mb_strlen($str) > $length ? mb_substr($str, 0, $length - 2, 'utf-8') . '...' : $str;
    }
}
