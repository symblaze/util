# Documentation

<details>
<summary>
 JSON
</summary>

The `Symblaze\Util\Json` class provides a set of static methods to work with JSON data.

### Safe encode

To encode an array to JSON, use the `encode` method. This method will throw a RuntimeException instead of an Exception
in case of an error.

```php
use Symblaze\Util\Json;

Json::encode(['foo', 'bar']); // ["foo","bar"]

Json::encode(['foo' => 'bar']); // {"foo":"bar"}
```

You can also pass the `JSON_*` flags as the second argument.

```php
use Symblaze\Util\Json;

$data = ['foo' => 'bar'];

$json = Json::encode($data, JSON_PRETTY_PRINT);
```

### Encode to Object

To encode an array to a JSON object, use the `encodeToObject` method.

```php
use Symblaze\Util\Json;

$data = ['foo', 'bar'];

$json = Json::encodeToObject($data); // {"0":"foo","1":"bar"}
```

### Encode special Floats

Special floats like `NAN`, `INF` and `-INF` are not valid JSON. To encode them, use the `encodeWithSpecialFloats`
method.

```php
use Symblaze\Util\Json;

$data = ['foo' => NAN];

$json = Json::encodeWithSpecialFloats($data); // {"foo":"NAN"}
```

### Decode

To decode a JSON string, use the `decode()` method. You can also pass the second optional argument to add more flags.

```php
use Symblaze\Util\Json;

$json = '["foo","bar"]';

$data = Json::decode($json); // Array( [0] => foo [1] => bar )
```

### Decode Special Floats

To decode a JSON string with special floats, use the `decodeWithSpecialFloats` method.

```php
use Symblaze\Util\Json;

$json = '{"foo":"NAN"}';

$data = Json::decodeWithSpecialFloats($json); // Array( [foo] => NAN )
```

</details>
