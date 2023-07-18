<?php

namespace Magein\PhpUtils;

use Magein\PhpUtils\Traits\Instance;

class File
{
    use Instance;

    /**
     * 获取深层次的文件
     * @param $directory
     * @param array $ext
     * @param array $files
     * @return Result
     */
    public function getTreeList($directory, array $ext = [], array &$files = []): Result
    {
        if (!is_dir($directory)) {
            return Result::error('不是一个目录');
        }
        $lists = glob($directory . '/*');

        if ($lists) {
            foreach ($lists as $list) {
                if (is_file($list)) {
                    if ($ext && !in_array(pathinfo($list, PATHINFO_EXTENSION), $ext)) {
                        continue;
                    }
                    $files[] = $list;
                } elseif (is_dir($list)) {
                    $this->getTreeList($list, $ext, $files);
                }
            }
        }

        return Result::success($files);
    }
}