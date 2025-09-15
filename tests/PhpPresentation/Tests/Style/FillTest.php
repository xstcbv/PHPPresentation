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

use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;
use PHPUnit\Framework\TestCase;

/**
 * Test class for PhpPresentation.
 *
 * @coversDefaultClass \PhpOffice\PhpPresentation\PhpPresentation
 */
class FillTest extends TestCase
{
    /**
     * Test create new instance.
     */
    public function testConstruct(): void
    {
        $object = new Fill();
        self::assertEquals(Fill::FILL_NONE, $object->getFillType());
        self::assertEquals(0, $object->getRotation());
        self::assertInstanceOf(Color::class, $object->getStartColor());
        self::assertEquals(Color::COLOR_WHITE, $object->getEndColor()->getARGB());
        self::assertInstanceOf(Color::class, $object->getEndColor());
        self::assertEquals(Color::COLOR_BLACK, $object->getStartColor()->getARGB());
    }

    /**
     * Test get/set end color.
     */
    public function testSetGetEndColor(): void
    {
        $object = new Fill();
        self::assertInstanceOf(Fill::class, $object->setEndColor(new Color(Color::COLOR_BLUE)));
        self::assertInstanceOf(Color::class, $object->getEndColor());
        self::assertEquals(Color::COLOR_BLUE, $object->getEndColor()->getARGB());
    }

    /**
     * Test get/set fill type.
     */
    public function testSetGetFillType(): void
    {
        $object = new Fill();
        self::assertInstanceOf(Fill::class, $object->setFillType());
        self::assertEquals(Fill::FILL_NONE, $object->getFillType());
        self::assertInstanceOf(Fill::class, $object->setFillType(Fill::FILL_GRADIENT_LINEAR));
        self::assertEquals(Fill::FILL_GRADIENT_LINEAR, $object->getFillType());
    }

    /**
     * Test get/set rotation.
     */
    public function testSetGetRotation(): void
    {
        $object = new Fill();
        self::assertInstanceOf(Fill::class, $object->setRotation());
        self::assertEquals(0, $object->getRotation());
        $value = mt_rand(1, 100);
        self::assertInstanceOf(Fill::class, $object->setRotation($value));
        self::assertEquals($value, $object->getRotation());
    }

    /**
     * Test get/set start color.
     */
    public function testSetGetStartColor(): void
    {
        $object = new Fill();
        self::assertInstanceOf(Fill::class, $object->setStartColor(new Color(Color::COLOR_BLUE)));
        self::assertInstanceOf(Color::class, $object->getStartColor());
        self::assertEquals(Color::COLOR_BLUE, $object->getStartColor()->getARGB());
    }

    /**
     * Test get/set hash index.
     */
    public function testSetGetHashIndex(): void
    {
        $object = new Fill();
        $value = mt_rand(1, 100);
        $object->setHashIndex($value);
        self::assertEquals($value, $object->getHashIndex());
    }
}
