# DDD Testing
Tools for helping in test development.

## PcComponentes\Ddd\Testing\Util\PhpUnit\IterableMockTrait
Allows you to introduce mocks in tested method through an iterable mock object in an easy way.

### Use
Example:

```php
use PcComponentes\Ddd\Testing\Util\PhpUnit\IterableMockTrait;
use PHPUnit\Framework\TestCase;

final class Testing extends TestCase
{
    use IterableMockTrait;

    public function testMethod()
    {
        $mockedItem1 = $this->createMock(\stdClass::class);
        // Assertions in mock
        $mockedItem2 = $this->createMock(\stdClass::class);
        // Assertions in mock

        $mockedIterator = $this->addIterableValuesToMock(
            $this->createMock(\Iterator::class), // Your iterable mock
            [
                $mockedItem1,
                $mockedItem2,
            ],
        );
        // ...
    }
}
```

## PcComponentes\Ddd\Testing\Util\PhpUnit\SerializableMockTrait
Allows you to simplify the serializable parametrization of a \JsonSerializable mock, making the code more semantic and easy to read.

### Use
Example:

```php
use PcComponentes\Ddd\Testing\Util\PhpUnit\SerializableMockTrait;
use PHPUnit\Framework\TestCase;

final class Testing extends TestCase
{
    use SerializableMockTrait;

    public function testMethod()
    {
        $valueToReturnOnSerialize = 'some compatible with serialization method declared';

        $serializableMock = $this->addJsonSerializationToMock( 
            $this->createMock(\JsonSerializable::class), // Your mock which implements jsonSerialize method 
            $this->once(), // Or other InvocationOrder
            $valueToReturnOnSerialize,
        );
        // ...
    }
}
```
