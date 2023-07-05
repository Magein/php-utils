<?php

namespace Magein\PhpUtils\Traits;

trait Instance
{
    protected static $instance = null;

    /**
     * @return self
     */
    public static function ins()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
