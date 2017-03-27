<?php

namespace App\DataTables;

trait ExportFile {
	
	public function  buildExcel(array $headers_map) 
    {
        $spli = 1000;
        $this->datatables->getRequest()->merge(['length' => -1]);

        $total = $this->ajax(true);
        $time = $total >= $spli ? ceil($total/$spli)+1 : 1;

        header("Content-Type: application/vnd.ms-excel; charset=utf-8"); 
        header("Pragma: public"); 
        header("Expires: 0"); 
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Content-Type: application/force-download"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header("Content-Disposition: attachment;filename={$this->getFilename()}.xls "); 
        header("Content-Transfer-Encoding: binary ");
        
        // 标题
        $str = '';
        foreach ($headers_map as $v) { $str .= $v."\t";}
        if (!empty($str)) echo $this->convertString($str."\n", 'GBK');

        // 一次查询可以搞定
        if ($time === 1) {
            $data = $this->ajax(true, $spli, 0)->getData(true)['data'];
            $str = '';
            foreach ($data as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $str .= $vv."\t";
                }
                $str .= "\n";
            }
            echo $this->convertString($str, 'GBK');
            die;
        }
        // 多次查询才可以搞定
        $t = 0;
        ob_start();
        while ($t < $time) {
            $data = $this->ajax(true,$spli, $t)->getData(true)['data'];
            $str = '';
            foreach ($data as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $str .= $vv."\t";
                }
                $str .= "\n";
            }
            echo $this->convertString($str, 'GBK');
            $t++;
            ob_flush();
        }
        ob_end_flush();
        die;
    }

    public function convertString($str, $to, $from = 'UTF-8')
    {
        return mb_convert_encoding($str, $to);
    }
}