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
}
