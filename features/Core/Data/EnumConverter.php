<?php

namespace Features\Core\Data;

trait EnumConverter
{
    public static function toValue(string $key): ?array
    {
        $enum = null;
        foreach (self::toArray() as $arrayKey => $arrayValue) {
            if ($key == $arrayKey) {
                $enum = [
                    'id' => $arrayKey,
                    'name' => $arrayValue
                ];
                break;
            }
        }
        return $enum;
    }

    public static function toEnumArray(): ?array
    {
        $enums = [];
        foreach (self::toValues() as $value) {
            array_push($enums, self::make($value));
        }
        return $enums;
    }
}
