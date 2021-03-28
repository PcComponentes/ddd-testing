<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Testing\Util\PhpUnit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

trait IterableMockTrait
{
    private function addIterableValuesToMock(
        MockObject $mock,
        array $returnedValues,
        int $expectedIterations = 1
    ): MockObject {
        if (false === $mock instanceof \Iterator) {
            throw new \Exception('Mock object not implements \Iterator');
        }

        if (0 === \count($returnedValues)) {
            throw new \Exception('This utility does not make sense for empty collections');
        }

        $nValues = \count($returnedValues);

        $totalNValues = $nValues * $expectedIterations;
        $totalReturnValues = $returnedValues;
        for ($i = 1; $i < $expectedIterations; $i++) {
            \array_push($totalReturnValues, ...$returnedValues);
        }

        $mock
            ->expects(
                new InvokedCount($totalNValues),
            )
            ->method(self::returnCurrentElementMethod())
            ->willReturn(...$totalReturnValues)
        ;

        $mock
            ->expects(
                new InvokedCount($totalNValues + $expectedIterations),
            )
            ->method(self::currentPositionValidMethod())
            ->willReturn(
                ... $this->valuesThatCheckValidWillReturn($nValues, $expectedIterations),
            )
        ;

        return $mock;
    }

    private function valuesThatCheckValidWillReturn(int $nValues,  int $expectedIterations): array
    {
        $values = [];
        for ($j = 0; $j < $expectedIterations; $j++) {
            for ($i = 0; $i < $nValues; $i++) {
                $values[] = true;
            }
            $values[] = false;
        }

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
