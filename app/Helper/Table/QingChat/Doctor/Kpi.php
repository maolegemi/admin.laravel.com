<?php

namespace App\Helper\Table\QingChat\Doctor;

use League\Fractal\TransformerAbstract;

class Kpi extends TransformerAbstract
{
    // Load Common Function
    //use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Stat_Time'               => $data['Stat_Time'],
            'Doctor_Num'              => $data['Doctor_Num'] ? $data['Doctor_Num'] : 0,
            'Online_ChatNum'          => $data['Online_ChatNum'] ? $data['Online_ChatNum'] : 0,
            'Online_AnswerNum'        => $data['Online_AnswerNum'] ? $data['Online_AnswerNum'] : 0,
            'TowHourAnswerNum'        => $data['TowHourAnswerNum'] ? $data['TowHourAnswerNum'] : 0,
            'First_AnswerDoctorNum'   => $data['First_AnswerDoctorNum'] ? $data['First_AnswerDoctorNum'] : 0,
            'TwoWeek_AnswerDoctorNum' => $data['TwoWeek_AnswerDoctorNum'] ? $data['TwoWeek_AnswerDoctorNum'] : 0,
            'LeiJi_NewDoctorNum'      => $data['LeiJi_NewDoctorNum'] ? $data['LeiJi_NewDoctorNum'] : 0,
            'ChangeToFans_Num'        => $data['ChangeToFans_Num'] ? $data['ChangeToFans_Num'] : 0,
            'ChatToApp_Num'           => $data['ChatToApp_Num'] ? $data['ChatToApp_Num'] : 0,
            'LeiJi_AppNum'            => $data['LeiJi_AppNum'] ? $data['LeiJi_AppNum'] : 0,
            'LeiJi_DoctorNum'         => $data['LeiJi_DoctorNum'] ? $data['LeiJi_DoctorNum'] : 0,
            'LeiJi_ChatNum'           => $data['LeiJi_ChatNum'] ? $data['LeiJi_ChatNum'] : 0,
            'LeiJi_ToFansNum'         => $data['LeiJi_ToFansNum'] ? $data['LeiJi_ToFansNum'] : 0,
        ];
    }
}
