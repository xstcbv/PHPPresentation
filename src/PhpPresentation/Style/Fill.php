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
 * @copyright   2009-2015 PHPPresentation contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpPresentation\Style;

use PhpOffice\PhpPresentation\ComparableInterface;

/**
 * \PhpOffice\PhpPresentation\Style\Fill.
 */
class Fill implements ComparableInterface
{
    /* Fill types */
    public const FILL_NONE = 'none';
    public const FILL_SOLID = 'solid';
    public const FILL_GRADIENT_LINEAR = 'linear';
    public const FILL_GRADIENT_PATH = 'path';
    public const FILL_PATTERN_DARKDOWN = 'darkDown';
    public const FILL_PATTERN_DARKGRAY = 'darkGray';
    public const FILL_PATTERN_DARKGRID = 'darkGrid';
    public const FILL_PATTERN_DARKHORIZONTAL = 'darkHorizontal';
    public const FILL_PATTERN_DARKTRELLIS = 'darkTrellis';
    public const FILL_PATTERN_DARKUP = 'darkUp';
    public const FILL_PATTERN_DARKVERTICAL = 'darkVertical';
    public const FILL_PATTERN_GRAY0625 = 'gray0625';
    public const FILL_PATTERN_GRAY125 = 'gray125';
    public const FILL_PATTERN_LIGHTDOWN = 'lightDown';
    public const FILL_PATTERN_LIGHTGRAY = 'lightGray';
    public const FILL_PATTERN_LIGHTGRID = 'lightGrid';
    public const FILL_PATTERN_LIGHTHORIZONTAL = 'lightHorizontal';
    public const FILL_PATTERN_LIGHTTRELLIS = 'lightTrellis';
    public const FILL_PATTERN_LIGHTUP = 'lightUp';
    public const FILL_PATTERN_LIGHTVERTICAL = 'lightVertical';
    public const FILL_PATTERN_MEDIUMGRAY = 'mediumGray';

    /**
     * Fill type.
     *
     * @var string
     */
    private $fillType;

    /**
     * Rotation.
     *
     * @var float
     */
    private $rotation;

    /**
     * Start color.
     *
     * @var \PhpOffice\PhpPresentation\Style\Color
     */
    private $startColor;

    /**
     * End color.
     *
     * @var \PhpOffice\PhpPresentation\Style\Color
     */
    private $endColor;

    /**
     * Hash index.
     *
     * @var int
     */
    private $hashIndex;

    /**
     * Create a new \PhpOffice\PhpPresentation\Style\Fill.
     */
    public function __construct()
    {
        // Initialise values
        $this->fillType = self::FILL_NONE;
        $this->rotation = (float) 0;
        $this->startColor = new Color(Color::COLOR_WHITE);
        $this->endColor = new Color(Color::COLOR_BLACK);
    }

    /**
     * Get Fill Type.
     *
     * @return string
     */
    public function getFillType()
    {
        return $this->fillType;
    }

    /**
     * Set Fill Type.
     *
     * @param string $pValue \PhpOffice\PhpPresentation\Style\Fill fill type
     *
     * @return \PhpOffice\PhpPresentation\Style\Fill
     */
    public function setFillType($pValue = self::FILL_NONE)
    {
        $this->fillType = $pValue;

        return $this;
    }

    /**
     * Get Rotation.
     *
     * @return float
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * Set Rotation.
     *
     * @param float|int $pValue
     *
     * @return \PhpOffice\PhpPresentation\Style\Fill
     */
    public function setRotation($pValue = 0)
    {
        $this->rotation = (float) $pValue;

        return $this;
    }

    /**
     * Get Start Color.
     *
     * @return \PhpOffice\PhpPresentation\Style\Color
     */
    public function getStartColor()
    {
        // It's a get but it may lead to a modified color which we won't detect but in which case we must bind.
        // So bind as an assurance.
        return $this->startColor;
    }

    /**
     * Set Start Color.
     *
     * @param \PhpOffice\PhpPresentation\Style\Color $pValue
     *
     * @throws \Exception
     *
     * @return \PhpOffice\PhpPresentation\Style\Fill
     */
    public function setStartColor(Color $pValue = null)
    {
        $this->startColor = $pValue;

        return $this;
    }

    /**
     * Get End Color.
     *
     * @return \PhpOffice\PhpPresentation\Style\Color
     */
    public function getEndColor()
    {
        // It's a get but it may lead to a modified color which we won't detect but in which case we must bind.
        // So bind as an assurance.
        return $this->endColor;
    }

    /**
     * Set End Color.
     *
     * @param \PhpOffice\PhpPresentation\Style\Color $pValue
     *
     * @throws \Exception
     *
     * @return \PhpOffice\PhpPresentation\Style\Fill
     */
    public function setEndColor(Color $pValue = null)
    {
        $this->endColor = $pValue;

        return $this;
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode(): string
    {
        return md5(
            $this->getFillType()
            . $this->getRotation()
            . $this->getStartColor()->getHashCode()
            . $this->getEndColor()->getHashCode()
            . __CLASS__
        );
    }

    /**
     * Get hash index.
     *
     * Note that this index may vary during script execution! Only reliable moment is
     * while doing a write of a workbook and when changes are not allowed.
     *
     * @return int|null Hash index
     */
    public function getHashIndex(): ?int
    {
        return $this->hashIndex;
    }

    /**
     * Set hash index.
     *
     * Note that this index may vary during script execution! Only reliable moment is
     * while doing a write of a workbook and when changes are not allowed.
     *
     * @param int $value Hash index
     *
     * @return $this
     */
    public function setHashIndex(int $value)
    {
        $this->hashIndex = $value;

        return $this;
    }
}
