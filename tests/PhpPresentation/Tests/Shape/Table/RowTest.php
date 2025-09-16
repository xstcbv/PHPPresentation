<?php

/**
 * This file is part of PHPPresentation - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPresentation is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPresentation/contributors.
 *
 * @see        https://github.com/PHPOffice/PHPPresentation
 *
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpPresentation\Tests\Shape\Table;

use PhpOffice\PhpPresentation\Exception\OutOfBoundsException;
use PhpOffice\PhpPresentation\Shape\Table\Cell;
use PhpOffice\PhpPresentation\Shape\Table\Row;
use PhpOffice\PhpPresentation\Style\Fill;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Row element.
 *
 * @coversDefaultClass \PhpOffice\PhpPresentation\Shape\Row
 */
class RowTest extends TestCase
{
    /**
     * Test can read.
     */
    public function testConstruct(): void
    {
        $object = new Row();
        self::assertCount(1, $object->getCells());
        self::assertInstanceOf(Fill::class, $object->getFill());

        $value = mt_rand(1, 100);
        $object = new Row($value);
        self::assertCount($value, $object->getCells());
        self::assertInstanceOf(Fill::class, $object->getFill());
    }

    public function testGetCell(): void
    {
        $object = new Row();

        self::assertInstanceOf(Cell::class, $object->getCell(0));
    }

    public function testGetCellException(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('The expected value (1) is out of bounds (0, 0)');

        $object = new Row();
        $object->getCell(1);
    }

    public function testNextCell(): void
    {
        $object = new Row(2);

        self::assertInstanceOf(Cell::class, $object->nextCell());
    }

    public function testNextCellException(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('The expected value (1) is out of bounds (0, 0)');

        $object = new Row();
        $object->nextCell();
        $object->nextCell();
    }

    /**
     * Test get/set hash index.
     */
    public function testSetGetHashIndex(): void
    {
        $object = new Row();
        $value = mt_rand(1, 100);
        $object->setHashIndex($value);
        self::assertEquals($value, $object->getHashIndex());
    }

    public function testGetSetFill(): void
    {
        $object = new Row();

        self::assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Table\\Row', $object->setFill(new Fill()));
        self::assertInstanceOf(Fill::class, $object->getFill());
    }

    public function testGetSetHeight(): void
    {
        $object = new Row();

        self::assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Table\\Row', $object->setHeight());
        self::assertEquals(0, $object->getHeight());

        $value = mt_rand(1, 100);
        self::assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Table\\Row', $object->setHeight($value));
        self::assertEquals($value, $object->getHeight());
    }
}
