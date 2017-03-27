<?php

namespace App\Helper\Table\Operation\Doctor;

use League\Fractal\TransformerAbstract;

class RankWeekSum extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;

    private $index = 0;
    // 格式化明细数据
    public function transform(array $data)
    {
        ++$this->index;
        return [
            'Sum_Date'                  => $data['Sum_Week'],
            'City_Name'                 => $this->cityName($data['City_Id']),
            'Shop_Name'                 => $this->shopName($data['Shop_Id']),
            'Doctor_Name'               => $this->cutStr($data['Doctor_Name'], 4),
            'rank'                      => $this->getStartNum() + $this->index,
            'Doctor_Level'              => $data['Doctor_Level'],
            'OutPatientNum'             => $data['OutPatientNum'],
            'OutPatientNum_Rate'        => $data['OutPatientNum_Rate'] . "%",
            'FirstVisitNum'             => $data['FirstVisitNum'],
            'FirstVisitNum_Rate'        => $data['FirstVisitNum_Rate'] . "%",
            'OrderOnlineNum'            => $data['OrderOnlineNum'],
            'ShopFirstVisitOnline_Rate' => $data['ShopFirstVisitOnline_Rate'] . "%",
            'ShopOrderOnlineNum_Rate'   => $data['ShopOrderOnlineNum_Rate'] . "%",
            'FirstVisitOnline'          => $data['FirstVisitOnline'] . "%",
        ];
    }
    private function getStartNum()
    {
        if (!isset($this->start)) {
            $this->start = isset($_GET['start']) ? intval($_GET['start']) : 0;
        }
        return $this->start;
    }
}
