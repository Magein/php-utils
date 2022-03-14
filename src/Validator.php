<?php

namespace Magein\Common;

/**
 * @method static bool phone($number)
 * @method static bool email($number)
 * @method static bool qq($number)
 * @method static bool idCard($number)
 * @method static bool url($number)
 * @method static bool ip($number)
 * @method static bool image($number)
 */
class Validator
{
    /**
     * 验证手机
     * @param $number
     * @return bool
     */
    private function _phone($number)
    {
        if (!preg_match("/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|16[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|19[0-9]{1}[0-9]{8}$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    private function _email($number)
    {
        if (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    private function _qq($number)
    {
        if (!preg_match("/^[1-9]\d{4,}$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    private function _idCard($number)
    {
        if (!preg_match("/^\d{6}(19|20)\d{2}([0][1-9]|11|12)([0,1,2][1-9]|[3][0,1])\d{3}([0-9]|X|x)$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * url地址
     * @param $number
     * @return bool
     */
    private function _url($number)
    {
        if (!preg_match("/[a-zA-z]+:\/\/[^\s]*/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    private function _ip($number)
    {
        if (!preg_match("/((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * 传递的是一个url 则自动获取格式，如果传递的是格式，则直接验证
     * @param $url
     * @return bool
     */
    private function _image($url)
    {
        if (self::url($url)) {
            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        } else {
            $ext = $url;
        }

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            return true;
        }

        return false;
    }
}