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

namespace PhpOffice\PhpPresentation\Tests\Writer;

use PhpOffice\PhpPresentation\AbstractShape;
use PhpOffice\PhpPresentation\Writer;

/**
 * Mock class for AbstractWriter.
 */
class AbstractWriter extends Writer\AbstractWriter
{
    /**
     * public wrapper for protected method.
     *
     * @return AbstractShape[] All drawings in PhpPresentation
     */
    public function allDrawings(): array
    {
        return parent::allDrawings();
    }
}
