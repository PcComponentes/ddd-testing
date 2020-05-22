<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Testing\Util\PhpUnit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

trait IterableMockTrait
{
    private function addIterableValuesToMock(MockObject $mock, array $returnedValues): MockObject
    {
        if (false === $mock instanceof \Iterator) {
            throw new \Exception('Mock object not implements \Iterator');
        }

        if (0 === \count($returnedValues)) {
            throw new \Exception('This utility does not make sense for empty collections');
        }

        $nValues = \count($returnedValues);

        $mock
            ->expects(
                new InvokedCount($nValues),
                )
            ->method(self::returnCurrentElementMethod())
            ->willReturn(... $returnedValues)
        ;

        $mock
            ->expects(
                new InvokedCount($nValues + 1),
                )
            ->method(self::currentPositionValidMethod())
            ->willReturn(
                ... $this->valuesThatCheckValidWillReturn($nValues),
                )
        ;

        return $mock;
    }

    private function valuesThatCheckValidWillReturn(int $nValues): array
    {
        $values = [];
        for($i = 0; $i < $nValues; $i++) {
            $values[] = true;
        }
        $values[] = false;

        return $values;
    }

    private static function returnCurrentElementMethod(): string
    {
        return 'current';
    }

    private static function currentPositionValidMethod(): string
    {
        return 'valid';
    }
}
