<?php

namespace Magein\Common;

/**
 * 驼峰，帕斯卡，下划线命名转化
 * Class Variable
 */
class Variable
{
    /**
     * 下划线命名转化为驼峰命名
     * @param string $variable
     * @return string
     */
    public static function camelCase(string $variable): string
    {
        if (empty($variable)) {
            return $variable;
        }
        $variable = trim($variable, '_');
        $variable = preg_replace_callback('/_([a-z])/', function ($matches) {
            return ucfirst($matches[1] ?? '');
        }, $variable);

        return lcfirst($variable);
    }

    /**
     * 下划线命名(含驼峰)转化为帕斯卡命名法（驼峰命名法的首字母大写）
     * @param string $variable
     * @return string
     */
    public static function pascal(string $variable): string
    {
        if (empty($variable)) {
            return '';
        }
        $variable = trim($variable, '_');
        $variable = preg_replace_callback('/_([a-z])/', function ($matches) {
            return ucfirst($matches[1] ?? '');
        }, $variable);

        return ucfirst($variable);
    }

    /**
     * 驼峰转命名(含帕卡斯)转化为下划线命名
     * @param string $variable
     * @return string
     */
    public static function underline(string $variable): string
    {
        if (empty($variable)) {
            return '';
        }
        $variable = trim($variable, '_');
        $variable = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . lcfirst($matches[1] ?? '');
        }, $variable);

        return trim($variable, '_');
    }
}