<?php

namespace Magein\Common;

class Finish
{
    /**
     * @var int
     */
    protected int $code = 0;

    /**
     * @var string
     */
    protected string $message = '';

    /**
     * @var mixed
     */
    protected $data = null;

    /**
     * @return bool
     */
    public function fail(): bool
    {
        return $this->code() !== 0;
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return intval($this->code);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return mixed|null
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @param string $message
     * @param int|string $code
     * @param $data
     * @return static
     */
    public static function error(string $message = '', $code = 1, $data = null): Finish
    {
        return new self($message, $code, $data);
    }

    /**
     * @param $data
     * @param int|string $code
     * @param string $message
     * @return static
     */
    public static function success($data = null, $code = 0, string $message = ''): Finish
    {
        return new self($message, $code, $data);
    }
}
