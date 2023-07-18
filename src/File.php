<?php

namespace Magein\PhpUtils;

class File
{
    public function getFiles($directory, &$files = [])
    {
        if (!is_dir($directory)) {
            return Result::error('不是一个目录');
        }
        $lists = glob($directory . '/*');

        if ($lists) {
            foreach ($lists as $list) {
                if (is_file($list)) {
                    $files[] = $list;
                } elseif (is_dir($list)) {
                    $this->getFiles($list, $files);
                }
            }
        }

        return Result::success($files);
    }
}