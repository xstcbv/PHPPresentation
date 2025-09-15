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

namespace PhpPresentation\Tests\Writer\PowerPoint2007;

use PhpOffice\Common\Drawing;
use PhpOffice\PhpPresentation\Shape\AutoShape;
use PhpOffice\PhpPresentation\Shape\Comment;
use PhpOffice\PhpPresentation\Shape\Group;
use PhpOffice\PhpPresentation\Shape\Media;
use PhpOffice\PhpPresentation\Shape\Placeholder;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
use PhpOffice\PhpPresentation\Slide\Animation;
use PhpOffice\PhpPresentation\Slide\Transition;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Style\Font;
use PhpOffice\PhpPresentation\Tests\PhpPresentationTestCase;
use ReflectionClass;

class PptSlidesTest extends PhpPresentationTestCase
{
    protected $writerName = 'PowerPoint2007';

    public function testAlignmentRTL(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->createTextRun('AAA');
        $oRichText->getActiveParagraph()->getAlignment()->setIsRTL(false);

        $expectedElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $expectedElement);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $expectedElement, 'rtl', '0');
        $this->assertIsSchemaECMA376Valid();

        $oRichText->getActiveParagraph()->getAlignment()->setIsRTL(true);
        $this->resetPresentationFile();

        $expectedElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $expectedElement);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $expectedElement, 'rtl', '1');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAlignmentShapeAuto(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape()->setWidth(400)->setHeight(400)->setOffsetX(100)->setOffsetY(100);
        $oShape->createTextRun('this text should be vertically aligned');
        $oShape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_AUTO);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'anchor');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAlignmentShapeBase(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape()->setWidth(400)->setHeight(400)->setOffsetX(100)->setOffsetY(100);
        $oShape->createTextRun('this text should be vertically aligned');
        $oShape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_BASE);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'anchor');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAlignmentShapeBottom(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape()->setWidth(400)->setHeight(400)->setOffsetX(100)->setOffsetY(100);
        $oShape->createTextRun('this text should be vertically aligned');
        $oShape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'anchor', Alignment::VERTICAL_BOTTOM);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAlignmentShapeCenter(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape()->setWidth(400)->setHeight(400)->setOffsetX(100)->setOffsetY(100);
        $oShape->createTextRun('this text should be vertically aligned');
        $oShape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'anchor', Alignment::VERTICAL_CENTER);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAlignmentShapeTop(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape()->setWidth(400)->setHeight(400)->setOffsetX(100)->setOffsetY(100);
        $oShape->createTextRun('this text should be vertically aligned');
        $oShape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'anchor', Alignment::VERTICAL_TOP);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAnimation(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape1 = $oSlide->createRichTextShape();
        $oShape2 = $oSlide->createLineShape(10, 10, 10, 10);
        $oAnimation = new Animation();
        $oAnimation->addShape($oShape1);
        $oAnimation->addShape($oShape2);
        $oSlide->addAnimation($oAnimation);

        $element = '/p:sld/p:timing';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:timing/p:tnLst/p:par/p:cTn/p:childTnLst/p:seq/p:cTn/p:childTnLst/p:par';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:timing/p:tnLst/p:par/p:cTn/p:childTnLst/p:seq/p:cTn/p:childTnLst/p:par/p:cTn/p:childTnLst/p:par/p:cTn/p:childTnLst/p:par';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:timing/p:tnLst/p:par/p:cTn/p:childTnLst/p:seq/p:cTn/p:childTnLst/p:par/p:cTn/p:childTnLst/p:par/p:cTn/p:childTnLst/p:par[1]/p:cTn/p:childTnLst/p:set/p:cBhvr/p:tgtEl/p:spTgt';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spid', 2);
        $element = '/p:sld/p:timing/p:tnLst/p:par/p:cTn/p:childTnLst/p:seq/p:cTn/p:childTnLst/p:par/p:cTn/p:childTnLst/p:par/p:cTn/p:childTnLst/p:par[2]/p:cTn/p:childTnLst/p:set/p:cBhvr/p:tgtEl/p:spTgt';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spid', 3);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testAutoShape(): void
    {
        $autoShape = new AutoShape();
        $autoShape->setText('AlphaBeta');
        $this->oPresentation->getActiveSlide()->addShape($autoShape);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:prstGeom';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $element, 'prst');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'prst', AutoShape::TYPE_HEART);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:t';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlElementEquals('ppt/slides/slide1.xml', $element, 'AlphaBeta');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testCommentRelationship(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oSlide->addShape(new Comment());

        $element = '/Relationships/Relationship[@Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/comments"]';
        $this->assertZipXmlElementExists('ppt/slides/_rels/slide1.xml.rels', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testCommentInGroupRelationship(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oGroup = new Group();
        $oGroup->addShape(new Comment());
        $oSlide->addShape($oGroup);

        $element = '/Relationships/Relationship[@Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/comments"]';
        $this->assertZipXmlElementExists('ppt/slides/_rels/slide1.xml.rels', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testDrawingWithHyperlink(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createDrawingShape();
        $oShape->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/PhpPresentationLogo.png');
        $oShape->getHyperlink()->setUrl('https://github.com/PHPOffice/PHPPresentation/');

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:cNvPr/a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'r:id', 'rId3');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testDrawingShapeMimetypePNG(): void
    {
        $shape = $this->oPresentation->getActiveSlide()->createDrawingShape();
        $shape->setHeight(10)->setWidth(10);
        $shape->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/PhpPresentationLogo.png');

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:cNvPr/a:extLst';
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:blipFill/a:blip/a:extLst';
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testDrawingShapeMimetypeSVG(): void
    {
        $shape = $this->oPresentation->getActiveSlide()->createDrawingShape();
        $shape->setHeight(10)->setWidth(10);
        $shape->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/tiger.svg');

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:cNvPr/a:extLst';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:cNvPr/a:extLst/a:ext';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:cNvPr/a:extLst/a:ext[@uri="{FF2B5EF4-FFF2-40B4-BE49-F238E27FC236}"]';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:blipFill/a:blip/a:extLst';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:blipFill/a:blip/a:extLst/a:ext[@uri="{28A0092B-C50C-407E-A947-70E740481C1C}"]';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $this->assertIsSchemaECMA376Valid();
    }

    public function testDrawingShapeBorder(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createDrawingShape();
        $oShape->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/PhpPresentationLogo.png');
        $oShape->getBorder()->setLineStyle(Border::LINE_DOUBLE);

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:spPr/a:ln';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cmpd', Border::LINE_DOUBLE);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testDrawingShapeFill(): void
    {
        $oColor = new Color(Color::COLOR_DARKRED);
        $oColor->setAlpha(mt_rand(0, 100));
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createDrawingShape();
        $oShape->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/PhpPresentationLogo.png');
        $oShape->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor($oColor);

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:spPr/a:solidFill/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $oColor->getRGB());

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:spPr/a:solidFill/a:srgbClr/a:alpha';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', (string) ($oColor->getAlpha() * 1000));
        $this->assertIsSchemaECMA376Valid();
    }

    public function testDrawingShapeShadow(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createDrawingShape();
        $oShape->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/PhpPresentationLogo.png');
        $oShape->getShadow()->setVisible(true)->setDirection(45)->setDistance(10);

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:spPr/a:effectLst/a:outerShdw';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testFillGradientLinearTable(): void
    {
        $expected1 = 'E06B20';
        $expected2 = strrev($expected1);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(1);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('R1C1');
        $oFill = $oCell->getFill();
        $oFill->setFillType(Fill::FILL_GRADIENT_LINEAR)->setStartColor(new Color('FF' . $expected1))->setEndColor(new Color('FF' . $expected2));

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:gradFill/a:gsLst/a:gs[@pos="0"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected1);
        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:gradFill/a:gsLst/a:gs[@pos="100000"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected2);
        $this->assertIsSchemaECMA376Valid();
    }

    /**
     * @see : https://github.com/PHPOffice/PHPPresentation/issues/61
     */
    public function testFillGradientLinearRichText(): void
    {
        $expected1 = 'E06B20';
        $expected2 = strrev($expected1);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape();
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oFill = $oShape->getFill();
        $oFill->setFillType(Fill::FILL_GRADIENT_LINEAR)->setStartColor(new Color('FF' . $expected1))->setEndColor(new Color('FF' . $expected2));

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:gradFill/a:gsLst/a:gs[@pos="0"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected1);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:gradFill/a:gsLst/a:gs[@pos="100000"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected2);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testFillGradientPathTable(): void
    {
        $expected1 = 'E06B20';
        $expected2 = strrev($expected1);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(1);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('R1C1');
        $oFill = $oCell->getFill();
        $oFill->setFillType(Fill::FILL_GRADIENT_PATH)->setStartColor(new Color('FF' . $expected1))->setEndColor(new Color('FF' . $expected2));

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:gradFill/a:gsLst/a:gs[@pos="0"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected1);
        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:gradFill/a:gsLst/a:gs[@pos="100000"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected2);
        $this->assertIsSchemaECMA376Valid();
    }

    /**
     * @see : https://github.com/PHPOffice/PHPPresentation/issues/61
     */
    public function testFillGradientPathText(): void
    {
        $expected1 = 'E06B20';
        $expected2 = strrev($expected1);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape();
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oFill = $oShape->getFill();
        $oFill->setFillType(Fill::FILL_GRADIENT_PATH)->setStartColor(new Color('FF' . $expected1))->setEndColor(new Color('FF' . $expected2));

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:gradFill/a:gsLst/a:gs[@pos="0"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected1);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:gradFill/a:gsLst/a:gs[@pos="100000"]/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected2);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testFillPatternTable(): void
    {
        $expected1 = 'E06B20';
        $expected2 = strrev($expected1);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(1);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('R1C1');
        $oFill = $oCell->getFill();
        $oFill->setFillType(Fill::FILL_PATTERN_LIGHTTRELLIS)->setStartColor(new Color('FF' . $expected1))->setEndColor(new Color('FF' . $expected2));

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:pattFill/a:fgClr/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected1);
        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:pattFill/a:bgClr/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected2);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testFillSolidTable(): void
    {
        $expected = 'E06B20';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(1);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('R1C1');
        $oFill = $oCell->getFill();
        $oFill->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('FF' . $expected));

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr/a:solidFill/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected);
        $this->assertIsSchemaECMA376Valid();
    }

    /**
     * @see : https://github.com/PHPOffice/PHPPresentation/issues/61
     */
    public function testFillSolidText(): void
    {
        $expected = 'E06B20';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createRichTextShape();
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oFill = $oShape->getFill();
        $oFill->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('FF' . $expected));

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:solidFill/a:srgbClr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expected);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testHyperlink(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('Delta');
        $oRun->getHyperlink()->setUrl('http://www.google.fr');

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testHyperlinkInternal(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('Delta');
        $oRun->getHyperlink()->setSlideNumber(1);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'action', 'ppaction://hlinksldjump');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testHyperlinkTextColorUsed(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('Delta');
        $oRun->getHyperlink()->setIsTextColorUsed(true);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick/a:extLst';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick/a:extLst/a:ext';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'uri', '{A12FA001-AC4F-418D-AE19-62706E023703}');

        $this->assertIsSchemaECMA376Valid();

        $this->resetPresentationFile();

        $oRun->getHyperlink()->setIsTextColorUsed(false);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:hlinkClick/a:extLst';
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $element);
    }

    public function testListBullet(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_BULLET);
        $oRichText->getActiveParagraph()->getBulletStyle()->setBulletColor(new Color('76543210'));

        $oExpectedFont = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletFont();
        $oExpectedChar = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletChar();
        $oExpectedColor = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletColor()->getRGB();
        $oExpectedAlpha = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletColor()->getAlpha() * 1000;

        $oRichText->createTextRun('Alpha');
        $oRichText->createParagraph()->createTextRun('Beta');
        $oRichText->createParagraph()->createTextRun('Delta');
        $oRichText->createParagraph()->createTextRun('Epsilon');

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buFont');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buFont', 'typeface', $oExpectedFont);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buChar');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buChar', 'char', $oExpectedChar);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buClr');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buClr/a:srgbClr');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buClr/a:srgbClr', 'val', $oExpectedColor);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buClr/a:srgbClr/a:alpha');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buClr/a:srgbClr/a:alpha', 'val', $oExpectedAlpha);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testListNumeric(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_NUMERIC);
        $oRichText->getActiveParagraph()->getBulletStyle()->setBulletNumericStyle(Bullet::NUMERIC_EA1CHSPERIOD);
        $oRichText->getActiveParagraph()->getBulletStyle()->setBulletNumericStartAt(5);
        $oExpectedFont = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletFont();
        $oExpectedChar = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletNumericStyle();
        $oExpectedStart = $oRichText->getActiveParagraph()->getBulletStyle()->getBulletNumericStartAt();
        $oRichText->createTextRun('Alpha');
        $oRichText->createParagraph()->createTextRun('Beta');
        $oRichText->createParagraph()->createTextRun('Delta');
        $oRichText->createParagraph()->createTextRun('Epsilon');

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buFont');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buFont', 'typeface', $oExpectedFont);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:buAutoNum');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buAutoNum', 'type', $oExpectedChar);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element . '/a:buAutoNum', 'startAt', $oExpectedStart);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testLine(): void
    {
        $valEmu10 = Drawing::pixelsToEmu(10);
        $valEmu90 = Drawing::pixelsToEmu(90);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oSlide->createLineShape(10, 10, 100, 100);
        $oSlide->createLineShape(100, 10, 10, 100);
        $oSlide->createLineShape(10, 100, 100, 10);
        $oSlide->createLineShape(100, 100, 10, 10);

        $element = '/p:sld/p:cSld/p:spTree/p:cxnSp/p:spPr/a:prstGeom';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'prst', 'line');

        $element = '/p:sld/p:cSld/p:spTree/p:cxnSp/p:spPr/a:xfrm/a:ext[@cx="' . $valEmu90 . '"][@cy="' . $valEmu90 . '"]';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $element = '/p:sld/p:cSld/p:spTree/p:cxnSp/p:spPr/a:xfrm/a:off[@x="' . $valEmu10 . '"][@y="' . $valEmu10 . '"]';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $element = '/p:sld/p:cSld/p:spTree/p:cxnSp/p:spPr/a:xfrm[@flipV="1"]/a:off[@x="' . $valEmu10 . '"][@y="' . $valEmu10 . '"]';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);

        $this->assertIsSchemaECMA376Valid();
    }

    public function testMedia(): void
    {
        $expectedName = 'MyName';
        $expectedWidth = mt_rand(1, 100);
        $expectedHeight = mt_rand(1, 100);
        $expectedX = mt_rand(1, 100);
        $expectedY = mt_rand(1, 100);

        $oMedia = new Media();
        $oMedia->setPath(PHPPRESENTATION_TESTS_BASE_DIR . '/resources/videos/sintel_trailer-480p.ogv')
            ->setName($expectedName)
            ->setResizeProportional(false)
            ->setHeight($expectedHeight)
            ->setWidth($expectedWidth)
            ->setOffsetX($expectedX)
            ->setOffsetY($expectedY);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oSlide->addShape($oMedia);

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:cNvPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'name', $expectedName);

        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:nvPr/a:videoFile';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'r:link', 'rId2');
        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:nvPr/p:extLst/p:ext';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'uri', '{DAA4B4D4-6D71-4841-9C94-3DE7FCFB9230}');
        $element = '/p:sld/p:cSld/p:spTree/p:pic/p:nvPicPr/p:nvPr/p:extLst/p:ext/p14:media';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'r:embed', 'rId3');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'xmlns:p14', 'http://schemas.microsoft.com/office/powerpoint/2010/main');

        $this->assertIsSchemaECMA376Valid();
    }

    public function testNote(): void
    {
        $oLayout = $this->oPresentation->getLayout();
        $oSlide = $this->oPresentation->getActiveSlide();
        $oNote = $oSlide->getNote();
        $oRichText = $oNote->createRichTextShape()
            ->setHeight((int) $oLayout->getCY($oLayout::UNIT_PIXEL))
            ->setWidth((int) $oLayout->getCX($oLayout::UNIT_PIXEL))
            ->setOffsetX(170)
            ->setOffsetY(180);
        $oRichText->createTextRun('testNote');

        // Content Types
        // $element = '/Types/Override[@PartName="/ppt/notesSlides/notesSlide1.xml"][@ContentType="application/vnd.openxmlformats-officedocument.presentationml.notesSlide+xml"]';
        // $this->assertTrue($pres->elementExists($element, '[Content_Types].xml'));
        // Rels
        // $element = '/Relationships/Relationship[@Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/notesSlide"][@Target="../notesSlides/notesSlide1.xml"]';
        // $this->assertTrue($pres->elementExists($element, 'ppt/slides/_rels/slide1.xml.rels'));
        // Slide

        $element = '/p:notes';
        $this->assertZipXmlElementExists('ppt/notesSlides/notesSlide1.xml', $element);
        // Slide Image Placeholder 1
        $element = '/p:notes/p:cSld/p:spTree/p:sp/p:nvSpPr/p:cNvPr[@id="2"][@name="Slide Image Placeholder 1"]';
        $this->assertZipXmlElementExists('ppt/notesSlides/notesSlide1.xml', $element);
        $element = '/p:notes/p:cSld/p:spTree/p:sp[1]/p:spPr/a:xfrm/a:off';
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'x', 0);
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'y', 0);
        $element = '/p:notes/p:cSld/p:spTree/p:sp[1]/p:spPr/a:xfrm/a:ext';
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'cx', Drawing::pixelsToEmu(round($oNote->getExtentX() / 2)));
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'cy', Drawing::pixelsToEmu(round($oNote->getExtentY() / 2)));

        // Notes Placeholder
        $element = '/p:notes/p:cSld/p:spTree/p:sp/p:nvSpPr/p:cNvPr[@id="3"][@name="Notes Placeholder"]';
        $this->assertZipXmlElementExists('ppt/notesSlides/notesSlide1.xml', $element);

        // Notes
        $element = '/p:notes/p:cSld/p:spTree/p:sp[2]/p:spPr/a:xfrm/a:off';
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'x', Drawing::pixelsToEmu($oNote->getOffsetX()));
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'y', Drawing::pixelsToEmu(round($oNote->getExtentY() / 2) + $oNote->getOffsetY()));
        $element = '/p:notes/p:cSld/p:spTree/p:sp[2]/p:spPr/a:xfrm/a:ext';
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'cx', 5486400);
        $this->assertZipXmlAttributeEquals('ppt/notesSlides/notesSlide1.xml', $element, 'cy', 3600450);
        $element = '/p:notes/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:t';
        $this->assertZipXmlElementExists('ppt/notesSlides/notesSlide1.xml', $element);

        $this->assertIsSchemaECMA376Valid();
    }

    public function testParagraphColumns(): void
    {
        $richText = $this->oPresentation->getActiveSlide()->createRichTextShape();

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'numCol');
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'spcCol');
        $this->assertIsSchemaECMA376Valid();

        $this->resetPresentationFile();
        $richText
            ->setColumns(2)
            ->setColumnSpacing(123);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $element, 'numCol');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'numCol', '2');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $element, 'spcCol');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spcCol', '1171575');
    }

    public function testParagraphLineSpacing(): void
    {
        $expectedLineSpacing = mt_rand(1, 100);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->getActiveParagraph()
            ->setLineSpacingMode(Paragraph::LINE_SPACING_MODE_PERCENT)
            ->setLineSpacing($expectedLineSpacing);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr/a:lnSpc/a:spcPct';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expectedLineSpacing * 1000);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr/a:lnSpc/a:spcPts';
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();

        $this->resetPresentationFile();
        $oRichText->getActiveParagraph()
            ->setLineSpacingMode(Paragraph::LINE_SPACING_MODE_POINT);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr/a:lnSpc/a:spcPct';
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr/a:lnSpc/a:spcPts';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expectedLineSpacing * 100);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testParagraphSpacingAfter(): void
    {
        $expectedVal = mt_rand(1, 100);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->getActiveParagraph()
            ->setSpacingAfter($expectedVal);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr/a:spcAft/a:spcPts';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expectedVal * 100);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testParagraphSpacingBefore(): void
    {
        $expectedVal = mt_rand(1, 100);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->getActiveParagraph()
            ->setSpacingBefore($expectedVal);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr/a:spcBef/a:spcPts';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'val', $expectedVal * 100);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testPlaceHolder(): void
    {
        $expectedType = Placeholder::PH_TYPE_SLIDENUM;
        $expectedX = mt_rand(1, 100);
        $expectedY = mt_rand(1, 100);
        $expectedW = mt_rand(1, 100);
        $expectedH = mt_rand(1, 100);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText
            ->setPlaceHolder(new Placeholder($expectedType))
            ->setOffsetX($expectedX)
            ->setOffsetY($expectedY)
            ->setWidth($expectedW)
            ->setHeight($expectedH);
        $oRichText->createTextRun('Test');

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:nvSpPr/p:cNvPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'name', 'Placeholder for sldNum');
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:nvSpPr/p:nvPr/p:ph';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'type', $expectedType);
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'idx');
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:xfrm/a:off';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'x', Drawing::pixelsToEmu($expectedX));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'y', Drawing::pixelsToEmu($expectedY));
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:xfrm/a:ext';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cx', Drawing::pixelsToEmu($expectedW));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cy', Drawing::pixelsToEmu($expectedH));
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:fld';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'type', 'slidenum');
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:fld/a:rPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:fld/a:t';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlElementEquals('ppt/slides/slide1.xml', $element, '<nr.>');
    }

    public function testPlaceHolderWithIdx(): void
    {
        $expectedType = Placeholder::PH_TYPE_DATETIME;
        $expectedIdx = 1;
        $expectedX = mt_rand(1, 100);
        $expectedY = mt_rand(1, 100);
        $expectedW = mt_rand(1, 100);
        $expectedH = mt_rand(1, 100);

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText
            ->setPlaceHolder((new Placeholder($expectedType))->setIdx($expectedIdx))
            ->setOffsetX($expectedX)
            ->setOffsetY($expectedY)
            ->setWidth($expectedW)
            ->setHeight($expectedH);
        $oRichText->createTextRun('Test');

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:nvSpPr/p:cNvPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'name', 'Placeholder for dt');
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:nvSpPr/p:nvPr/p:ph';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'type', $expectedType);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'idx', $expectedIdx);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:xfrm/a:off';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'x', Drawing::pixelsToEmu($expectedX));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'y', Drawing::pixelsToEmu($expectedY));
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:xfrm/a:ext';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cx', Drawing::pixelsToEmu($expectedW));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cy', Drawing::pixelsToEmu($expectedH));
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:pPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:fld';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'type', 'datetime');
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:fld/a:rPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:fld/a:t';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlElementEquals('ppt/slides/slide1.xml', $element, '03-04-05');
    }

    public function testRichTextAutoFitNormal(): void
    {
        $expectedFontScale = 47.5;
        $expectedLnSpcReduction = 20;

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->setAutoFit(RichText::AUTOFIT_NORMAL, $expectedFontScale, $expectedLnSpcReduction);
        $oRichText->createTextRun('This is my text for the test.');

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr/a:normAutofit';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'fontScale', $expectedFontScale * 1000);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'lnSpcReduction', $expectedLnSpcReduction * 1000);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextBreak(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->createBreak();

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:br';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextHyperlink(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->getHyperLink()->setUrl('http://www.google.fr');

        $element = '/p:sld/p:cSld/p:spTree/p:sp//a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextRunFontCharset(): void
    {
        $latinElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:latin';
        $eastAsianElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:ea';
        $complexScriptElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:cs';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('MyText');
        $oRun->getFont()->setCharset(18);

        $oRun->getFont()->setFormat(Font::FORMAT_LATIN);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'charset');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'charset', '12');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_EAST_ASIAN);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'charset');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'charset', '12');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_COMPLEX_SCRIPT);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'charset');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'charset', '12');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextRunFontFormat(): void
    {
        $latinElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:latin';
        $eastAsianElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:ea';
        $complexScriptElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:cs';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('MyText');
        $oRun->getFont()->setFormat(Font::FORMAT_LATIN);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'typeface', 'Calibri');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_EAST_ASIAN);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'typeface', 'Calibri');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_COMPLEX_SCRIPT);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'typeface', 'Calibri');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextRunFontPanose(): void
    {
        $latinElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:latin';
        $eastAsianElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:ea';
        $complexScriptElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:cs';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('MyText');
        $oRun->getFont()->setPanose('4494D72242');

        $oRun->getFont()->setFormat(Font::FORMAT_LATIN);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'panose');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'panose', '040409040D0702020402');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_EAST_ASIAN);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'panose');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'panose', '040409040D0702020402');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_COMPLEX_SCRIPT);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'panose');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'panose', '040409040D0702020402');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextRunFontPitchFamily(): void
    {
        $latinElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:latin';
        $eastAsianElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:ea';
        $complexScriptElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr/a:cs';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('MyText');
        $oRun->getFont()->setPitchFamily(42);

        $oRun->getFont()->setFormat(Font::FORMAT_LATIN);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $latinElement, 'pitchFamily');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $latinElement, 'pitchFamily', '42');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_EAST_ASIAN);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $eastAsianElement, 'pitchFamily');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $eastAsianElement, 'pitchFamily', '42');
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setFormat(Font::FORMAT_COMPLEX_SCRIPT);
        $this->resetPresentationFile();

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $latinElement);
        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $eastAsianElement);
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $complexScriptElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'typeface');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'typeface', 'Calibri');
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $complexScriptElement, 'pitchFamily');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $complexScriptElement, 'pitchFamily', '42');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextRunLanguage(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('MyText');

        $expectedElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $expectedElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $expectedElement, 'lang');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $expectedElement, 'lang', 'en-US');
        $this->assertIsSchemaECMA376Valid();

        $oRun->setLanguage('de_DE');
        $this->resetPresentationFile();

        $expectedElement = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $expectedElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $expectedElement, 'lang');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $expectedElement, 'lang', 'de_DE');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextShadow(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->createTextRun('AAA');
        $oRichText->getShadow()->setVisible(true)->setAlpha(75)->setBlurRadius(2)->setDirection(45);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:spPr/a:effectLst/a:outerShdw';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextUpright(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->createTextRun('AAA');
        $oRichText->setUpright(true);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'upright', '1');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testRichTextVertical(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRichText->createTextRun('AAA');
        $oRichText->setVertical(true);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:bodyPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'vert', 'vert');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testSlideLayoutExists(): void
    {
        $this->assertZipFileExists('ppt/slideLayouts/slideLayout1.xml');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testStyleCapitalization(): void
    {
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('pText');
        // Default : $oRun->getFont()->setCapitalization(Font::CAPITALIZATION_NONE);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cap', 'none');
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setCapitalization(Font::CAPITALIZATION_ALL);
        $this->resetPresentationFile();

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'cap', 'all');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testStyleCharacterSpacing(): void
    {
        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr';

        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('pText');
        // Default : $oRun->getFont()->setCharacterSpacing(0);

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spc', '0');
        $this->assertIsSchemaECMA376Valid();

        $oRun->getFont()->setCharacterSpacing(42);
        $this->resetPresentationFile();

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spc', '4200');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testStyleSubScript(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('pText');
        $oRun->getFont()->setSubScript(true);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'baseline', '-250000');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testStyleSuperScript(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oRichText = $oSlide->createRichTextShape();
        $oRun = $oRichText->createTextRun('pText');
        $oRun->getFont()->setSuperScript(true);

        $element = '/p:sld/p:cSld/p:spTree/p:sp/p:txBody/a:p/a:r/a:rPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'baseline', '300000');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testTableWithAlignment(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(4);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('AAA');

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'anchor');
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $element, 'vert');
        $this->assertIsSchemaECMA376Valid();

        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        $oCell->getActiveParagraph()->getAlignment()->setTextDirection(Alignment::TEXT_DIRECTION_STACKED);
        $this->resetPresentationFile();

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'anchor', Alignment::VERTICAL_BOTTOM);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'vert', Alignment::TEXT_DIRECTION_STACKED);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testTableWithBorder(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(4);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell(1);
        $oCell->createTextRun('AAA');
        $oCell->getBorders()->getBottom()->setDashStyle(Border::DASH_DASH);
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_DOUBLE);
        $oCell->getBorders()->getTop()->setDashStyle(Border::DASH_DASHDOT);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_SINGLE);
        $oCell->getBorders()->getRight()->setDashStyle(Border::DASH_DOT);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_THICKTHIN);
        $oCell->getBorders()->getLeft()->setDashStyle(Border::DASH_LARGEDASH);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_THINTHICK);
        $oCell = $oRow->nextCell();
        $oCell->createTextRun('BBB');
        $oCell->getBorders()->getRight()->setDashStyle(Border::DASH_LARGEDASHDOT);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_TRI);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell(1);
        $oCell->createTextRun('CCC');
        $oCell->getBorders()->getBottom()->setDashStyle(Border::DASH_LARGEDASHDOTDOT);
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr';

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnL[@cmpd="' . Border::LINE_THINTHICK . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnL[@cmpd="' . Border::LINE_THINTHICK . '"]/a:prstDash[@val="' . Border::DASH_LARGEDASH . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnR[@cmpd="' . Border::LINE_THICKTHIN . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnR[@cmpd="' . Border::LINE_THICKTHIN . '"]/a:prstDash[@val="' . Border::DASH_DOT . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnT[@cmpd="' . Border::LINE_SINGLE . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnT[@cmpd="' . Border::LINE_SINGLE . '"]/a:prstDash[@val="' . Border::DASH_DASHDOT . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnB[@cmpd="' . Border::LINE_SINGLE . '"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/a:lnB[@cmpd="' . Border::LINE_SINGLE . '"]/a:prstDash[@val="' . Border::DASH_SOLID . '"]');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testTableWithCellMargin(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(4);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('AAA');
        $oCell->getActiveParagraph()->getAlignment()
            ->setMarginBottom(10)
            ->setMarginLeft(20)
            ->setMarginRight(30)
            ->setMarginTop(40);

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:tcPr';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'marB', Drawing::pixelsToEmu(10));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'marL', Drawing::pixelsToEmu(20));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'marR', Drawing::pixelsToEmu(30));
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'marT', Drawing::pixelsToEmu(40));
        $this->assertIsSchemaECMA376Valid();
    }

    public function testTableWithColspan(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(4);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('AAA');
        $oCell->setColSpan(2);

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'gridSpan', 2);
        $this->assertIsSchemaECMA376Valid();
    }

    public function testTableWithRowspan(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(4);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('AAA');
        $oCell->setRowSpan(2);
        $oShape->createRow();
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oCell->createTextRun('BBB');

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '[@rowSpan="2"]');
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '[@vMerge="1"]');
        $this->assertIsSchemaECMA376Valid();
    }

    /**
     * @see : https://github.com/PHPOffice/PHPPresentation/issues/70
     */
    public function testTableWithHyperlink(): void
    {
        $oSlide = $this->oPresentation->getActiveSlide();
        $oShape = $oSlide->createTableShape(4);
        $oShape->setHeight(200)->setWidth(600)->setOffsetX(150)->setOffsetY(300);
        $oRow = $oShape->createRow();
        $oCell = $oRow->getCell();
        $oTextRun = $oCell->createTextRun('AAA');
        $oHyperlink = $oTextRun->getHyperlink();
        $oHyperlink->setUrl('https://github.com/PHPOffice/PHPPresentation/');

        $element = '/p:sld/p:cSld/p:spTree/p:graphicFrame/a:graphic/a:graphicData/a:tbl/a:tr/a:tc/a:txBody/a:p/a:r/a:rPr/a:hlinkClick';
        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'r:id', 'rId2');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testTransition(): void
    {
        $value = mt_rand(1000, 5000);
        $element = '/p:sld/p:transition';

        $this->assertZipXmlElementNotExists('ppt/slides/slide1.xml', $element);

        $oTransition = new Transition();
        $oTransition->setTimeTrigger(true, $value);
        $this->oPresentation->getActiveSlide()->setTransition($oTransition);
        $this->resetPresentationFile();

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $element, 'advTm');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'advTm', $value);
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'advClick', '0');
        $this->assertIsSchemaECMA376Valid();

        $oTransition->setSpeed(Transition::SPEED_FAST);
        $this->resetPresentationFile();
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spd', 'fast');
        $this->assertIsSchemaECMA376Valid();

        $oTransition->setSpeed(Transition::SPEED_MEDIUM);
        $this->resetPresentationFile();
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spd', 'med');
        $this->assertIsSchemaECMA376Valid();

        $oTransition->setSpeed(Transition::SPEED_SLOW);
        $this->resetPresentationFile();
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'spd', 'slow');
        $this->assertIsSchemaECMA376Valid();

        $rcTransition = new ReflectionClass('PhpOffice\PhpPresentation\Slide\Transition');
        $arrayConstants = $rcTransition->getConstants();
        foreach ($arrayConstants as $key => $value) {
            if (0 !== strpos($key, 'TRANSITION_')) {
                continue;
            }

            $oTransition->setTransitionType($rcTransition->getConstant($key));
            $this->oPresentation->getActiveSlide()->setTransition($oTransition);
            $this->resetPresentationFile();
            switch ($key) {
                case 'TRANSITION_BLINDS_HORIZONTAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:blinds[@dir=\'horz\']');

                    break;
                case 'TRANSITION_BLINDS_VERTICAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:blinds[@dir=\'vert\']');

                    break;
                case 'TRANSITION_CHECKER_HORIZONTAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:checker[@dir=\'horz\']');

                    break;
                case 'TRANSITION_CHECKER_VERTICAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:checker[@dir=\'vert\']');

                    break;
                case 'TRANSITION_CIRCLE':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:circle');

                    break;
                case 'TRANSITION_COMB_HORIZONTAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:comb[@dir=\'horz\']');

                    break;
                case 'TRANSITION_COMB_VERTICAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:comb[@dir=\'vert\']');

                    break;
                case 'TRANSITION_COVER_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'d\']');

                    break;
                case 'TRANSITION_COVER_LEFT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'l\']');

                    break;
                case 'TRANSITION_COVER_LEFT_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'ld\']');

                    break;
                case 'TRANSITION_COVER_LEFT_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'lu\']');

                    break;
                case 'TRANSITION_COVER_RIGHT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'r\']');

                    break;
                case 'TRANSITION_COVER_RIGHT_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'rd\']');

                    break;
                case 'TRANSITION_COVER_RIGHT_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'ru\']');

                    break;
                case 'TRANSITION_COVER_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cover[@dir=\'u\']');

                    break;
                case 'TRANSITION_CUT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:cut');

                    break;
                case 'TRANSITION_DIAMOND':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:diamond');

                    break;
                case 'TRANSITION_DISSOLVE':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:dissolve');

                    break;
                case 'TRANSITION_FADE':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:fade');

                    break;
                case 'TRANSITION_NEWSFLASH':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:newsflash');

                    break;
                case 'TRANSITION_PLUS':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:plus');

                    break;
                case 'TRANSITION_PULL_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:pull[@dir=\'d\']');

                    break;
                case 'TRANSITION_PULL_LEFT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:pull[@dir=\'l\']');

                    break;
                case 'TRANSITION_PULL_RIGHT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:pull[@dir=\'r\']');

                    break;
                case 'TRANSITION_PULL_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:pull[@dir=\'u\']');

                    break;
                case 'TRANSITION_PUSH_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:push[@dir=\'d\']');

                    break;
                case 'TRANSITION_PUSH_LEFT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:push[@dir=\'l\']');

                    break;
                case 'TRANSITION_PUSH_RIGHT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:push[@dir=\'r\']');

                    break;
                case 'TRANSITION_PUSH_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:push[@dir=\'u\']');

                    break;
                case 'TRANSITION_RANDOM':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:random');

                    break;
                case 'TRANSITION_RANDOMBAR_HORIZONTAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:randomBar[@dir=\'horz\']');

                    break;
                case 'TRANSITION_RANDOMBAR_VERTICAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:randomBar[@dir=\'vert\']');

                    break;
                case 'TRANSITION_SPLIT_IN_HORIZONTAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:split[@dir=\'in\'][@orient=\'horz\']');

                    break;
                case 'TRANSITION_SPLIT_OUT_HORIZONTAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:split[@dir=\'out\'][@orient=\'horz\']');

                    break;
                case 'TRANSITION_SPLIT_IN_VERTICAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:split[@dir=\'in\'][@orient=\'vert\']');

                    break;
                case 'TRANSITION_SPLIT_OUT_VERTICAL':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:split[@dir=\'out\'][@orient=\'vert\']');

                    break;
                case 'TRANSITION_STRIPS_LEFT_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:strips[@dir=\'ld\']');

                    break;
                case 'TRANSITION_STRIPS_LEFT_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:strips[@dir=\'lu\']');

                    break;
                case 'TRANSITION_STRIPS_RIGHT_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:strips[@dir=\'rd\']');

                    break;
                case 'TRANSITION_STRIPS_RIGHT_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:strips[@dir=\'ru\']');

                    break;
                case 'TRANSITION_WEDGE':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:wedge');

                    break;
                case 'TRANSITION_WIPE_DOWN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:wipe[@dir=\'d\']');

                    break;
                case 'TRANSITION_WIPE_LEFT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:wipe[@dir=\'l\']');

                    break;
                case 'TRANSITION_WIPE_RIGHT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:wipe[@dir=\'r\']');

                    break;
                case 'TRANSITION_WIPE_UP':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:wipe[@dir=\'u\']');

                    break;
                case 'TRANSITION_ZOOM_IN':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:zoom[@dir=\'in\']');

                    break;
                case 'TRANSITION_ZOOM_OUT':
                    $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $element . '/p:zoom[@dir=\'out\']');

                    break;
            }
            $this->assertIsSchemaECMA376Valid();
        }

        $oTransition->setManualTrigger(true);
        $this->resetPresentationFile();

        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $element, 'advClick', '1');
        $this->assertIsSchemaECMA376Valid();
    }

    public function testVisibility(): void
    {
        $expectedElement = '/p:sld';

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $expectedElement);
        $this->assertZipXmlAttributeNotExists('ppt/slides/slide1.xml', $expectedElement, 'show');
        $this->assertIsSchemaECMA376Valid();

        $this->oPresentation->getActiveSlide()->setIsVisible(false);
        $this->resetPresentationFile();

        $this->assertZipXmlElementExists('ppt/slides/slide1.xml', $expectedElement);
        $this->assertZipXmlAttributeExists('ppt/slides/slide1.xml', $expectedElement, 'show');
        $this->assertZipXmlAttributeEquals('ppt/slides/slide1.xml', $expectedElement, 'show', 0);
        $this->assertIsSchemaECMA376Valid();
    }
}
