<?php

namespace Magein\PhpUtils\Traits;

trait Instance
{
    protected static $instance = null;

    public static function ins()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
