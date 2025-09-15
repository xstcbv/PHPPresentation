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

use PhpOffice\PhpPresentation\Shape\Placeholder;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Test class for Table element.
 *
 * @coversDefaultClass \PhpOffice\PhpPresentation\Shape\Table
 */
class PlaceholderTest extends TestCase
{
    public function testConstruct(): void
    {
        $object = new Placeholder(Placeholder::PH_TYPE_BODY);
        self::assertEquals(Placeholder::PH_TYPE_BODY, $object->getType());
        self::assertNull($object->getIdx());
    }

    public function testIdx(): void
    {
        $value = mt_rand(0, 100);

        $object = new Placeholder(Placeholder::PH_TYPE_BODY);
        self::assertNull($object->getIdx());
        self::assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Placeholder', $object->setIdx($value));
        self::assertEquals($value, $object->getIdx());
    }

    public function testType(): void
    {
        $rcPlaceholder = new ReflectionClass('PhpOffice\PhpPresentation\Shape\Placeholder');
        $arrayConstants = $rcPlaceholder->getConstants();
        $value = array_rand($arrayConstants);

        $object = new Placeholder(Placeholder::PH_TYPE_BODY);
        self::assertEquals(Placeholder::PH_TYPE_BODY, $object->getType());
        self::assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Placeholder', $object->setType($value));
        self::assertEquals($value, $object->getType());
    }
}
