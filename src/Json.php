<?php

declare(strict_types=1);

namespace Symblaze\Util;

use JsonException;

final class Json
{
    /**
     * A safe wrapper around json_encode.
     */
    public static function encode(array $data, int $flags = 0): string
    {
        try {
            return json_encode($data, $flags | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new Exception\JsonException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Force the data to be encoded as an object.
     */
    public static function encodeToObject(array $data): string
    {
        return self::encode($data, JSON_FORCE_OBJECT);
    }

    public static function encodeWithSpecialFloats(array $data): string
    {
        array_walk_recursive($data, static function (mixed &$value): void {
            if (is_float($value) && (is_infinite($value) || is_nan($value))) {
                $value = strtoupper((string)$value);
            }
        });

        return self::encode($data);
    }

    public static function decode(string $string, int $flags = 0): array
    {
        try {
            $result = json_decode($string, true, 512, $flags | JSON_THROW_ON_ERROR);
            assert(is_array($result));

            return $result;
        } catch (JsonException $e) {
            throw new Exception\JsonException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function decodeWithSpecialFloats(string $input): array
    {
        $data = self::decode($input);

        array_walk_recursive($data, static function (mixed &$value): void {
            if (is_string($value)) {
                $upperValue = strtoupper($value);
                if (in_array($upperValue, ['NAN', 'INF', '-INF'], true)) {
                    if ('NAN' === $upperValue) {
                        $value = NAN;
                    } elseif ('INF' === $upperValue) {
                        $value = INF;
                    } else {
                        $value = -INF;
                    }
                }
            }
        });

        return $data;
    }
}
