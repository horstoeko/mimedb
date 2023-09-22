<?php

namespace horstoeko\mimedb\tests\testcases;

use horstoeko\mimedb\MimeDb;
use horstoeko\mimedb\tests\TestCase;

class MimeDbTest extends TestCase
{
    /**
     * Internal mime database
     *
     * @var \horstoeko\mimedb\MimeDb
     */
    protected $mimeDb = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->mimeDb = new MimeDb();
    }

    /**
     * Constructor Test
     *
     * @return void
     */
    public function testConstruction(): void
    {
        $this->assertEmpty($this->getPrivatePropertyFromObject($this->mimeDb, 'mimeDatabase')->getValue($this->mimeDb));
    }

    /**
     * Test "findType" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findType
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindType(): void
    {
        $this->assertEquals('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $this->mimeDb->findType('.docx'));
        $this->assertEquals('video/mp4', $this->mimeDb->findType('.mp4'));
        $this->assertEquals('audio/midi', $this->mimeDb->findType('.mid'));
        $this->assertEquals('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $this->mimeDb->findType('docx'));
        $this->assertEquals('video/mp4', $this->mimeDb->findType('mp4'));
        $this->assertEquals('audio/midi', $this->mimeDb->findType('mid'));
        $this->assertNull($this->mimeDb->findType('.unknown'));
    }

    /**
     * Test "findByExtension" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findByExtension
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindByExtension(): void
    {
        $this->assertEquals('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $this->mimeDb->findByExtension('.docx'));
        $this->assertEquals('video/mp4', $this->mimeDb->findByExtension('.mp4'));
        $this->assertEquals('audio/midi', $this->mimeDb->findByExtension('.mid'));
        $this->assertEquals('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $this->mimeDb->findByExtension('docx'));
        $this->assertEquals('video/mp4', $this->mimeDb->findByExtension('mp4'));
        $this->assertEquals('audio/midi', $this->mimeDb->findByExtension('mid'));
        $this->assertNull($this->mimeDb->findByExtension('.unknown'));
    }

    /**
     * Test "findMimeType" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findMimeType
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindMimeType(): void
    {
        $this->assertEquals("docx", $this->mimeDb->findMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertEquals("mp4", $this->mimeDb->findMimeType('video/mp4'));
        $this->assertEquals("mid", $this->mimeDb->findMimeType('audio/midi'));
        $this->assertNull($this->mimeDb->findMimeType('unknown/unknown'));
    }
}