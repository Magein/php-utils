<?php

namespace Magein\PhpUtils;

class Result
{
    protected $code = 0;
    protected $msg = '';
    protected $data = null;

    public static function error($message = '', $code = 1, $data = null)
    {
        $result = new self();
        $result->code = $code;
        $result->msg = $message;
        $result->data = $data;

        return $result;
    }

    public static function success($data = null, $message = '', $code = 0)
    {
        $result = new self();
        $result->code = $code;
        $result->msg = $message;
        $result->data = $data;

        return $result;
    }

    public function response()
    {
        throw new \Exception(json_encode($this->toArray()));
    }

    public function toArray()
    {
        return [
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => $this->data
        ];
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }
}