<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Testing\Util\PhpUnit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;

trait SerializableMockTrait
{
    private function addJsonSerializationToMock(
        MockObject $mock,
        InvocationOrder $invocationOrder,
        $returnedValue
    ): MockObject {
        $mock
            ->expects($invocationOrder)
            ->method(self::jsonSerializableMethod())
            ->willReturn($returnedValue)
        ;

        return $mock;
    }

    private static function jsonSerializableMethod(): string
    {
        return 'jsonSerialize';
    }
}
