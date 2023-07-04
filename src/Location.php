<?php

namespace Magein\PhpUtils;

/**
 * 仅适用中国地区
 *
 * 中国的经纬度范围大约为：
 * 纬度: 3.86~53.5
 * 经度: 73.66~135.05
 *
 */
class Location
{
    /**
     * 经度
     * @var string
     */
    protected string $longitude = '';

    /**
     * 纬度
     * @var string
     */
    protected string $latitude = '';

    /**
     * Location constructor.
     * @param null|string|array|static $data
     */
    public function __construct($data = null)
    {
        $this->chinese($data);
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        if ($this->longitude && $this->latitude) {
            return $this->longitude . ',' . $this->latitude;
        }

        return '';
    }

    /**
     * @param bool|int $flag
     * @return array
     */
    public function toArray($flag = true): array
    {
        if (empty($this->longitude) || empty($this->latitude)) {
            return [];
        }

        $data = [
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];

        if ($flag) {
            $data = array_values($data);
        }

        return $data;
    }

    /**
     * 自动提取经纬度坐标，仅适用于中国范围的
     * @param $location
     * @return void
     */
    private function chinese($location): void
    {
        if (empty($location)) {
            return;
        }

        if ($location instanceof static) {
            $location = $location->toArray();
        } elseif (is_string($location)) {
            $location = explode(',', $location);
        } elseif (is_object($location)) {
            $location = json_decode($location, true);
        }

        $location = array_filter($location);

        if (count($location) < 2) {
            return;
        }

        $location = array_values($location);
        $first = $location[0] ?? 0;
        $second = $location[1] ?? 0;
        /**
         * 判断条件 纬度 3.86~53.55，经度 73.66~135.05
         */
        if ($first > 70) {
            $this->longitude = $first;
            $this->latitude = $second;
        } else {
            $this->latitude = $second;
            $this->longitude = $first;
        }

    }
}
