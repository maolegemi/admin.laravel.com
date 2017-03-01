<?php

namespace App\Http\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Curl extends Model
{
    /**
     * Wrapper Curl
     *
     * @param  [type]  $url    [description]
     * @param  boolean $post   [description]
     * @param  string  $data   [description]
     * @param  array   $header [description]
     * @return [type]          [description]
     */
    final public static function _response($url, $post = false, $data = '', $header = [])
    {
        $ch = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
        }

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $rs     = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);

        // 检查并返回
        if (!isset($status['http_code']) || intval($status['http_code']) != 200) {
            throw new \Exception('Http Code:' . $status['http_code'] . "\r\nUrl:" . $status['url']);
        }

        return $rs;
    }

    /**
     * Get Request
     *
     * @param  [type] $url   [description]
     * @param  array  $param [description]
     * @return [type]        [description]
     */
    public static function get($url, $param = [])
    {
        return self::_response($url, false, $param);
    }

    /**
     * Post Request
     *
     * @param  [type] $url   [description]
     * @param   $param [description]
     * @return [type]        [description]
     */
    public static function post($url, $param = [])
    {
        return self::_response($url, true, $param);
    }
}
