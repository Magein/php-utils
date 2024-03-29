<?php

namespace Magein\PhpUtils;

use Magein\PhpUtils\Traits\Instance;

class FormatDate
{
    use Instance;

    /**
     * 转化为时间戳
     * @param $datetime
     * @return bool|false|int
     */
    public function unix($datetime)
    {
        if (empty($datetime)) {
            return '';
        }

        if (preg_match('/^1[0-9]{9}/', $datetime)) {
            return $datetime;
        }

        $result = strtotime($datetime);

        if (false === $result) {
            return '';
        }

        if ($result < 0) {
            return '';
        }

        return $result;
    }

    /**
     * 可传递的值  yyyy-1-5  yyyy-01-05
     * @param string|null $date
     * @return bool|false|string
     */
    private function getDate(string $date = null)
    {
        if (empty($date)) {
            $datetime = time();
        } else {
            $datetime = $this->unix($date) ?: time();
        }

        return $this->date($datetime);
    }

    /**
     * 某天的开始时间点
     * @param string $date
     * @return string
     */
    public function begin(string $date = ''): string
    {
        return $this->unix($this->getDate($date) . ' 00:00:00');
    }

    /**
     * 某天结束时间点
     * @param string $date
     * @return string
     */
    public function end(string $date = ''): string
    {
        return $this->unix($this->getDate($date) . ' 23:59:59');
    }

    /**
     * 今天的时间时间戳
     * @return array
     */
    public function today(): array
    {
        return [$this->begin(), $this->end()];
    }

    /**
     * 日期的时间范围
     * @param string $date
     * @return array
     */
    public function rangeDay(string $date): array
    {
        return [$this->begin($date), $this->end($date)];
    }

    /**
     * 每个月的开始时间戳是固定的 xx月-01开始
     * @param null $month
     * @return false|string
     */
    public function beginMonth($month = null)
    {
        if (empty($month)) {
            $month = date('m');
        }

        if (strlen($month) > 2) {
            $month = date('m', $this->unix($month));
        } else {
            $month = intval($month);
        }

        if ($month < 1 || $month > 12) {
            $month = 1;
        }

        $month = str_pad($month, 2, 0, STR_PAD_LEFT);

        return $this->unix(date('Y-' . $month . '-01'));
    }

    /**
     * 获取每个月的结束时间戳
     * @param null $month
     * @return int
     */
    public function endMonth($month = null): int
    {
        $timestamp = ($this->beginMonth($month));

        return strtotime('+1 month', $timestamp) - 1;
    }

    /**
     * 获取自然月的范围
     * @param string $date
     * @return array
     */
    public function rangeMonth(string $date = ''): array
    {
        return [
            $this->beginMonth($date),
            $this->endMonth($date),
        ];
    }

    /**
     * 获取日期所在的自然周范围
     * @param string $date
     * @param bool $to_string
     * @return array
     */
    public function rangeWeek(string $date = '', bool $to_string = false): array
    {
        $date = $this->unix($this->getDate($date));

        if (empty($date)) {
            return [];
        }

        $week_start_day = strtotime('this week', $date);
        $week_end_day = $week_start_day + 86400 * 7 - 1;

        if ($to_string) {
            $week_start_day = $this->format($week_start_day);
            $week_end_day = $this->format($week_end_day);
        }

        return [
            $week_start_day,
            $week_end_day
        ];
    }

    /**
     * 传递的时间往前推一周，即七天的数据
     * @param string $date 时间戳
     * @param bool $contain_today 是否包含今天
     * @return array
     */
    public function prevWeek(string $date = '', bool $contain_today = false): array
    {
        $end = $this->unix($this->getDate($date));

        // 包含今天
        if ($contain_today) {
            $begin = $end - 86400 * 6;
            $end = $end + 86400 - 1;
        } else {
            $begin = $end - 86400 * 7;
            $end -= 1;
        }

        return [
            $begin,
            $end
        ];
    }

    /**
     * 最后一周
     * @param int $week
     * @return array
     */
    public function lastWeek(int $week = 1): array
    {
        return $this->rangeWeek($this->getDate(strtotime("-$week week")));
    }

    /**
     * 格式化时间
     * @param string $datetime
     * @param string $format
     * @return false|string
     */
    public function format(string $datetime = '', string $format = 'Y-m-d H:i:s')
    {

        if (empty($datetime)) {
            $datetime = time();
        } else {
            $datetime = $this->unix($datetime);
        }

        return date($format, $datetime);
    }

    /**
     * @param string $datetime
     * @return false|string
     */
    public function date(string $datetime = '')
    {
        return $this->format($datetime, 'Y-m-d');
    }

    /**
     * @param string $datetime
     * @return false|string
     */
    public function time(string $datetime = '')
    {
        return $this->format($datetime, 'H:i:s');
    }
}