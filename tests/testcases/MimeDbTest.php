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

        $instance->findFirstMimeTypeByExtension('.mp4');

        $this->assertNotEmpty($this->getPrivatePropertyFromObject($instance, 'mimeDatabase')->getValue($instance));

        $instance2 = MimeDb::singleton();

        $this->assertNotEmpty($this->getPrivatePropertyFromObject($instance2, 'mimeDatabase')->getValue($instance2));
    }

    /**
     * Test "findType" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findFirstMimeTypeByExtension
     * @covers \horstoeko\mimeDb\MimeDb::findAllMimeTypesByExtension
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindType(): void
    {
        $this->assertEquals('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $this->mimeDb->findFirstMimeTypeByExtension('.docx'));
        $this->assertEquals('video/mp4', $this->mimeDb->findFirstMimeTypeByExtension('.mp4'));
        $this->assertEquals('audio/midi', $this->mimeDb->findFirstMimeTypeByExtension('.mid'));
        $this->assertEquals('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $this->mimeDb->findFirstMimeTypeByExtension('docx'));
        $this->assertEquals('video/mp4', $this->mimeDb->findFirstMimeTypeByExtension('mp4'));
        $this->assertEquals('audio/midi', $this->mimeDb->findFirstMimeTypeByExtension('mid'));
        $this->assertNull($this->mimeDb->findFirstMimeTypeByExtension('.unknown'));
    }

    /**
     * Test "findAllMimeTypesByExtension" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findAllMimeTypesByExtension
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindAllMimeTypesByExtension(): void
    {
        $this->assertIsArray($this->mimeDb->findAllMimeTypesByExtension('.docx'));
        $this->assertArrayHasKey(0, $this->mimeDb->findAllMimeTypesByExtension('.docx'));
        $this->assertArrayNotHasKey(1, $this->mimeDb->findAllMimeTypesByExtension('.docx'));
        $this->assertEquals("application/vnd.openxmlformats-officedocument.wordprocessingml.document", $this->mimeDb->findAllMimeTypesByExtension('.docx')[0]);

        $this->assertNull($this->mimeDb->findAllMimeTypesByExtension('.unknown'));
    }

    /**
     * Test "findFirstFileExtensionByMimeType" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findFirstFileExtensionByMimeType
     * @covers \horstoeko\mimeDb\MimeDb::findAllFileExtensionsByMimeType
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function testFindFirstFileExtensionByMimeType(): void
    {
        $this->assertEquals("docx", $this->mimeDb->findFirstFileExtensionByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertEquals("mp4", $this->mimeDb->findFirstFileExtensionByMimeType('video/mp4'));
        $this->assertEquals("mid", $this->mimeDb->findFirstFileExtensionByMimeType('audio/midi'));
        $this->assertNull($this->mimeDb->findFirstFileExtensionByMimeType('unknown/unknown'));
    }

    /**
     * Test "findAllFileExtensionsByMimeType" method
     *
     * @covers \horstoeko\mimeDb\MimeDb::findAllFileExtensionsByMimeType
     * @covers \horstoeko\mimeDb\MimeDb::initializeDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadedDatabase
     * @covers \horstoeko\mimeDb\MimeDb::loadDatabase
     * @return void
     */
    public function textFindAllFileExtensionsByMimeType(): void
    {
        $this->assertIsArray($this->mimeDb->findAllFileExtensionsByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertArrayHasKey(0, $this->mimeDb->findAllFileExtensionsByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertArrayNotHasKey(1, $this->mimeDb->findAllFileExtensionsByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document'));
        $this->assertEquals("docx", $this->mimeDb->findAllFileExtensionsByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document')[0]);

        $this->assertIsArray($this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska'));
        $this->assertArrayHasKey(0, $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska'));
        $this->assertArrayHasKey(1, $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska'));
        $this->assertArrayHasKey(2, $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska'));
        $this->assertArrayNotHasKey(3, $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska'));
        $this->assertEquals("mkv", $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska')[0]);
        $this->assertEquals("mk3d", $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska')[1]);
        $this->assertEquals("mks", $this->mimeDb->findAllFileExtensionsByMimeType('video/x-matroska')[2]);

        $this->assertNull($this->mimeDb->findAllFileExtensionsByMimeType('application/pdx'));
        $this->assertNull($this->mimeDb->findAllFileExtensionsByMimeType('unknown/unknown'));
    }
}
