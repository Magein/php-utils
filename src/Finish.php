<?php

namespace Magein\Common;

class Finish
{
    /**
     * @var int
     */
    protected $code = 0;

    /**
     * @var string
     */
    protected string $message = '';

    /**
     * @var mixed
     */
    protected $data = null;

    /**
     * @param string $message
     * @param int|string $code
     * @param $data
     */
    public function __construct(string $message = '', $code = 1, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

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
    public static function error(string $message = '', $code = 1, $data = null): finish
    {
        return new self($message, $code, $data);
    }

    /**
     * @param $data
     * @param int|string $code
     * @param string $message
     * @return static
     */
    public static function success($data = null, $code = 0, string $message = ''): finish
    {
        return new self($message, $code, $data);
    }
}
