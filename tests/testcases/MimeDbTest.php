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
     * Test "singleton" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::singleton
     * @return void
     */
    public function testSingleton(): void
    {
        $instance = MimeDb::singleton();

        $this->assertNotNull($instance);
        $this->assertInstanceOf(MimeDb::class, $instance);
        $this->assertEmpty($this->getPrivatePropertyFromObject($instance, 'mimeDatabase')->getValue($instance));

        $instance->findType('.mp4');

        $this->assertNotEmpty($this->getPrivatePropertyFromObject($instance, 'mimeDatabase')->getValue($instance));

        $instance2 = MimeDb::singleton();

        $this->assertNotEmpty($this->getPrivatePropertyFromObject($instance2, 'mimeDatabase')->getValue($instance2));
    }

    /**
     * Test "findType" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findType
     * @covers \horstoeko\mimeDb\MimeDb::findTypeAll
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
     * Test "findTypeAll" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findTypeAll
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindTypeAll(): void
    {
        $this->assertIsArray($this->mimeDb->findTypeAll('.docx'));
        $this->assertArrayHasKey(0, $this->mimeDb->findTypeAll('.docx'));
        $this->assertArrayNotHasKey(1, $this->mimeDb->findTypeAll('.docx'));

        $this->assertNull($this->mimeDb->findTypeAll('.unknown'));
    }

    /**
     * Test "findByExtension" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findType
     * @covers \horstoeko\mimeDb\MimeDb::findTypeAll
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
     * @covers \horstoeko\mimeDb\MimeDb::findMimeTypeAll
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

    /**
     * Test "findMimeTypeAll" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findMimeTypeAll
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindMimeTypeAll(): void
    {
        $this->assertIsArray($this->mimeDb->findMimeTypeAll('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertArrayHasKey(0, $this->mimeDb->findMimeTypeAll('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertArrayNotHasKey(1, $this->mimeDb->findMimeTypeAll('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertEquals("docx", $this->mimeDb->findMimeTypeAll('application/vnd.openxmlformats-officedocument.wordprocessingml.document')[0]);

        $this->assertIsArray($this->mimeDb->findMimeTypeAll('video/x-matroska'));
        $this->assertArrayHasKey(0, $this->mimeDb->findMimeTypeAll('video/x-matroska'));
        $this->assertArrayHasKey(1, $this->mimeDb->findMimeTypeAll('video/x-matroska'));
        $this->assertArrayHasKey(2, $this->mimeDb->findMimeTypeAll('video/x-matroska'));
        $this->assertArrayNotHasKey(3, $this->mimeDb->findMimeTypeAll('video/x-matroska'));
        $this->assertEquals("mkv", $this->mimeDb->findMimeTypeAll('video/x-matroska')[0]);
        $this->assertEquals("mk3d", $this->mimeDb->findMimeTypeAll('video/x-matroska')[1]);
        $this->assertEquals("mks", $this->mimeDb->findMimeTypeAll('video/x-matroska')[2]);

        $this->assertNull($this->mimeDb->findMimeTypeAll('application/pdx'));
        $this->assertNull($this->mimeDb->findMimeTypeAll('unknown/unknown'));
    }
}
