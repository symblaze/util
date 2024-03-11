<?php

declare(strict_types=1);

namespace Symblaze\Util\Tests;

use Symblaze\Util\Exception\JsonException;
use Symblaze\Util\Json;

class JsonTest extends TestCase
{
    public function test_encode_an_array(): void
    {
        $this->assertSame('[]', Json::encode([]));
    }

    public function test_encode_an_array_with_json_error(): void
    {
        $this->expectException(JsonException::class);

        Json::encode([INF]);
    }

    public function test_encode_to_object(): void
    {
        $this->assertSame('{"foo":"bar"}', Json::encodeToObject(['foo' => 'bar']));
        $this->assertSame('{"0":"foo","1":"bar"}', Json::encodeToObject(['foo', 'bar']));
        $this->assertSame('{}', Json::encodeToObject([]));
    }

    public function test_encode_with_special_floats(): void
    {
        $data = [
            'nan' => NAN,
            'inf' => INF,
            '-inf' => -INF,
        ];

        $actual = Json::encodeWithSpecialFloats($data);

        $this->assertSame('{"nan":"NAN","inf":"INF","-inf":"-INF"}', $actual);
    }

    public function test_decode_an_array(): void
    {
        $this->assertSame([], Json::decode('[]'));
    }

    public function test_decode_an_array_with_json_error(): void
    {
        $this->expectException(JsonException::class);

        Json::decode('{"foo":}');
    }

    public function test_decode_from_an_object(): void
    {
        $this->assertSame(['foo' => 'bar'], Json::decode('{"foo":"bar"}'));
        $this->assertSame(['foo', 'bar'], Json::decode('{"0":"foo","1":"bar"}'));
        $this->assertSame([], Json::decode('{}'));
    }

    public function test_decode_with_special_floats(): void
    {
        $input = '{"nan":"NAN","inf":"INF","-inf":"-INF"}';

        $actual = Json::decodeWithSpecialFloats($input);

        $this->assertTrue(is_nan($actual['nan']));
        $this->assertTrue(is_infinite($actual['inf']));
        $this->assertTrue(is_infinite($actual['-inf']));
        $this->assertNotSame($actual['inf'], $actual['-inf']);
    }
}
