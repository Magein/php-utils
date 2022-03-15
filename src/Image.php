<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2021/1/11
 * Time: 13:39
 */

namespace Magein\Common;

class Image
{
    /**
     *
     * @param string $filepath
     * @param string $ext
     */
    public function __construct(string $filepath, string $ext = '')
    {
        $this->setSavePath($filepath, $ext);
    }

    /**
     * $filepath 可以是路径，可以是文件名称，但是需要传递完整的
     * 有效的值：
     *  ./storage/images
     *  ./storage/images/avatar.jpg
     *  ./storage/images/avatar.png
     * @param $filepath
     * @param string $ext
     * @return void
     */
    protected function setSavePath($filepath, string $ext = '')
    {
        $info = pathinfo($filepath);
        $save_dir = $info['dirname'];
        $filename = $info['filename'];
        $ext = $info['extension'] ?? '';
    }

    /**
     * @param $content
     * @return Finish
     */
    public function base64($content)
    {
        if (empty($content)) {
            return Finish::error('图片内容为空');
        }

        if (empty($save_name)) {
            return Finish::error('请输入保存图片路径');
        }

        $save_name = pathinfo($save_name);
        $save_dir = $save_name['dirname'];
        $filename = $save_name['filename'];
        $file_ext = $save_name['extension'] ?? '';

        if (empty($ext)) {
            $ext = $file_ext ?: 'png';
        }

        // 保存路径
        $path = $save_dir . '/' . $filename . '.' . $ext;

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            return Finish::error('图片保存路径创建失败');
        }

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $content, $result)) {
            file_put_contents($path, base64_decode(str_replace($result[1], '', $content)));
        }

        if (is_file($path)) {
            return Finish::success($path);
        }

        return Finish::error('图片保存失败');
    }

    public function remote($url)
    {
        if (empty($url)) {
            return Finish::error('请输入远程图片地址');
        }

        if (empty($save_name)) {
            return Finish::error('请输入保存图片路径');
        }

        $save_name = pathinfo($save_name);

        $save_dir = $save_name['dirname'];
        $filename = $save_name['filename'];
        $file_ext = $save_name['extension'] ?? '';
        $origin_ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));

        if (empty($ext)) {
            $ext = $file_ext ?: $origin_ext;
        }

        // 保存路径
        $path = $save_dir . '/' . $filename . '.' . ($ext ?: 'png');

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            return Finish::error('图片保存路径创建失败');
        }

        //获取远程文件所采用的方法
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $img = curl_exec($ch);
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        if (!preg_match('/image/', $mime)) {
            return Finish::error('图片远程地址异常');
        }

        $fp2 = @fopen($path, 'a');
        fwrite($fp2, $img);
        fclose($fp2);
        unset($img, $url);

        if (is_file($path)) {
            return Finish::success($path);
        }

        return Finish::error('图片下载失败');
    }
}