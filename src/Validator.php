<?php

namespace Magein\Common;

/**
 * 一些常用的验证类
 */
class Validator
{
    /**
     * 验证手机
     * @param string $number
     * @return bool
     */
    public static function phone(string $number): bool
    {
        if (!preg_match("/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|16[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|19[0-9]{1}[0-9]{8}$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $number
     * @return bool
     */
    public static function email(string $number): bool
    {
        if (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param string|int $number
     * @return bool
     */
    public static function qq($number): bool
    {
        if (!preg_match("/^[1-9]\d{4,}$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param string|int $number
     * @return bool
     */
    public static function idCard($number): bool
    {
        if (!preg_match("/^\d{6}(19|20)\d{2}([0][1-9]|11|12)([0,1,2][1-9]|[3][0,1])\d{3}([0-9]|X|x)$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * url地址
     * @param string $number
     * @return bool
     */
    public static function url(string $number): bool
    {
        if (!preg_match("/[a-zA-z]+:\/\/[^\s]*/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $number
     * @return bool
     */
    public static function ip(string $number): bool
    {
        if (!preg_match("/((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * 传递的是一个url 则自动获取格式，如果传递的是格式，则直接验证
     * @param string $url
     * @return bool
     */
    public static function image(string $url): bool
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

    /**
     * 匹配汉字
     * @param string $char
     * @param array $length
     * @return bool
     */
    public static function chinese(string $char, array $length = []): bool
    {
        $min = $length[0] ?? 2;
        $max = $length[1] ?? 6;

        if (preg_match("/^[\x{4e00}-\x{9fa5}]{" . $min . "," . $max . "}$/u", $char)) {
            return true;
        }
        return false;
    }
}