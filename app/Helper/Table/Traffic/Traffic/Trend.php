<?php

namespace App\Helper\Table\Traffic\Traffic;

use League\Fractal\TransformerAbstract;

class Trend extends TransformerAbstract
{
    public function transform(array $data)
    {
        return [
            'Insert_Date'         => $data['Insert_Date'],
            'PV_Sum'              => $data['PV_Sum'] ? $data['PV_Sum'] : 0,
            'UV_Sum'              => $data['UV_Sum'] ? $data['UV_Sum'] : 0,
            'Register_User_Sum'   => $data['Register_User_Sum'] ? $data['Register_User_Sum'] : 0,
            'Login_User_Sum'      => $data['Login_User_Sum'] ? $data['Login_User_Sum'] : 0,
            'Reservation_Sum'     => $data['Reservation_Sum'] ? $data['Reservation_Sum'] : 0,
            'Arrive_Sum'          => $data['Arrive_Sum'] ? $data['Arrive_Sum'] : 0,
            'Inc_Reservation_Sum' => $data['Inc_Reservation_Sum'] ? $data['Inc_Reservation_Sum'] : 0,
            'Consulting_Sum'      => $data['Consulting_Sum'] ? $data['Consulting_Sum'] : 0,
            'Inc_Consulting_Sum'  => $data['Inc_Consulting_Sum'] ? $data['Inc_Consulting_Sum'] : 0,
        ];
    }
}
