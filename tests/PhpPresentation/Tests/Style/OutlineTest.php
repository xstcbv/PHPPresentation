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

namespace PhpOffice\PhpPresentation\Tests\Style;

use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Style\Outline;
use PHPUnit\Framework\TestCase;

/**
 * Test class for PhpPresentation.
 *
 * @coversDefaultClass \PhpOffice\PhpPresentation\Style\Outline
 */
class OutlineTest extends TestCase
{
    /**
     * Test create new instance.
     */
    public function testConstruct(): void
    {
        $object = new Outline();
        self::assertEquals(1, $object->getWidth());
        self::assertInstanceOf(Fill::class, $object->getFill());
    }

    /**
     * Test get/set fill.
     */
    public function testSetGetFill(): void
    {
        $object = new Outline();
        self::assertInstanceOf(Fill::class, $object->getFill());
        self::assertInstanceOf(Outline::class, $object->setFill(new Fill()));
        self::assertInstanceOf(Fill::class, $object->getFill());
    }

    /**
     * Test get/set width.
     */
    public function testSetGetWidth(): void
    {
        $object = new Outline();
        self::assertEquals(1, $object->getWidth());
        $value = mt_rand(1, 100);
        self::assertInstanceOf(Outline::class, $object->setWidth($value));
        self::assertEquals($value, $object->getWidth());
    }
}
