<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2021/1/11
 * Time: 13:39
 */

namespace Magein\PhpUtils;

class Image
{

    /**
     * 保存图片的路径
     * @var string
     */
    protected $filepath = '';

    /**
     * 是否重新命名
     * @var bool
     */
    protected $rename = false;

    /**
     * 直接渲染图片
     * @var bool
     */
    protected $fetch = false;

    /**
     *  保存路径 文件名称为远程图片名称
     *  ./storage/images
     * @param $filepath
     * @param bool $rename
     */
    public function setSavePath($filepath, bool $rename = false)
    {
        $this->filepath = $filepath;

        if (!is_dir($filepath)) {
            mkdir($filepath, 0777, true);
        }

        $this->rename = (bool)$rename;

        return $this;
    }

    public function setFetch($bool = true)
    {
        $this->fetch = (bool)$bool;

        return $this;
    }

    /**
     * @param $content
     * @param string $extension
     * @return Result|void
     */
    public function base64($content, string $extension = '')
    {
        if (empty($content)) {
            return Result::error('图片内容为空');
        }

        if (empty($extension)) {
            preg_match('/data:image\/(.+);/', $content, $matches);
            $extension = $matches[1] ?? '';
            if ($extension == 'jpeg') {
                $extension = 'jpg';
            }
        }

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $content, $result)) {
            $content = base64_decode(str_replace($result[1], '', $content));
        }

        $filepath = '';
        if ($this->filepath) {
            $filename = md5(uniqid()) . '.' . $extension;
            $filepath = trim($this->filepath, '/') . $filename;
            file_put_contents($filepath, $content);
        }


        if ($this->fetch) {
            header("content-type:image/jpg;");
            echo $content;
            exit();
        }

        return Result::success($filepath);
    }

    public function remote($url, $headers = [])
    {
        if (empty($url)) {
            return Result::error('请输入远程图片地址');
        }

        //获取远程文件所采用的方法
        $ch = curl_init();
        $timeout = 5;

        if (empty($headers)) {
            $headers = [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'
            ];
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if (curl_errno($ch)) {
            return Result::error(curl_error($ch));
        }
        curl_close($ch);
        if (!preg_match('/image/', $mime)) {
            return Result::error('远程地址mime类型不是图片类型');
        }

        if ($this->filepath) {
            if ($this->rename) {
                $ext = trim(str_replace('image', '', $mime), '/');
                $filename = md5(uniqid()) . '.' . $ext;
            } else {
                $filename = pathinfo($url, PATHINFO_BASENAME);
            }
            file_put_contents(trim($this->filepath, '/') . $filename, $data);
        }

        if ($this->fetch) {
            header("content-type:$mime;");
            echo $data;
            exit();
        }

        return Result::success($data);
    }
}