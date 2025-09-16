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

namespace PhpOffice\PhpPresentation\Tests\Shape;

use PhpOffice\PhpPresentation\Exception\OutOfBoundsException;
use PhpOffice\PhpPresentation\Shape\Table;
use PhpOffice\PhpPresentation\Shape\Table\Row;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Table element.
 *
 * @coversDefaultClass \PhpOffice\PhpPresentation\Shape\Table
 */
class TableTest extends TestCase
{
    public function testConstruct(): void
    {
        $object = new Table();
        self::assertEmpty($object->getRows());
        self::assertFalse($object->isResizeProportional());
    }

    public function testNumColums(): void
    {
        $value = mt_rand(1, 100);
        $object = new Table();

        self::assertEquals(1, $object->getNumColumns());
        self::assertInstanceOf(Table::class, $object->setNumColumns($value));
        self::assertEquals($value, $object->getNumColumns());
    }

    public function testRows(): void
    {
        $object = new Table();

        self::assertInstanceOf(Row::class, $object->createRow());
        self::assertCount(1, $object->getRows());

        self::assertInstanceOf(Row::class, $object->getRow(0));
    }

    public function testGetRowException(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('The expected value (1) is out of bounds (0, 0)');

        $object = new Table();
        $object->getRow(1);
    }

    public function testHashCode(): void
    {
        $object = new Table();
        self::assertEquals(md5(get_class($object)), $object->getHashCode());

        $row = $object->createRow();
        self::assertEquals(md5($row->getHashCode() . get_class($object)), $object->getHashCode());
    }
}
