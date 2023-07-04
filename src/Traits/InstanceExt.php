<?php

namespace Magein\PhpUtils\Traits;

/**
 * 使用static是可以继承的
 */
trait InstanceExt
{
    protected static $instance = null;

    public static function ins()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
