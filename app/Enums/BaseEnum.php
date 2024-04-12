<?php

namespace App\Enums;

trait BaseEnum
{
    public static function badge($type): string
    {
        foreach (self::cases() as $case) {
            if ($type == $case->value) {
                return "<span class='badge badge-sm " . self::badgesArray()[$case->value]['class'] . "'>" . self::badgesArray()[$case->value]['name'] . "</span>";
            }
        }

        return '';
    }

    public static function mapForSelect()
    {
        return collect(self::cases())->map(function ($status) {
            return [
                'value' => $status->value,
                'label' => __('main.' . strtolower($status->name))
            ];
        });
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function keys(): array
    {
        return array_column(self::cases(), 'name');
    }
    public static function value($key)
    {
        $key = strtoupper($key);

        if (!in_array($key, self::keys()))
            throw new \Exception('Invalid key');

        foreach (self::cases() as $case) {
            if ($case->name == $key) {
                return $case->value;
            }
        }
    }

    public static function key($type)
    {
        if (!in_array($type, self::values()))
            throw new \Exception('Invalid type');

        foreach (self::cases() as $case) {
            if ($case->value == $type) {
                return strtolower($case->name);
            }
        }
    }

    public function label()
    {
        return __('main.' . strtolower($this->name));
    }

    public static function random(): self
    {
        return self::cases()[rand(0, count(self::cases()) - 1)];
    }
}
