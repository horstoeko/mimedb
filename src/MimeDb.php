<?php

/*
* This file is a part of horstoeko/mimedb.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace horstoeko\mimedb;

/**
 * Class representing the mime repository
 *
 * @category MimeDb
 * @package  MimeDb
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/mimedb
 */
class MimeDb
{
    /**
     * The internal mime database
     *
     * @var array
     */
    protected $mimeDatabase = [];

    /**
     * Load mime db
     *
     * @return MimeDb
     */
    protected function initializeDatabase(): MimeDb
    {
        if ($this->loadedDatabase()) {
            return $this;
        }

        $this->loadDatabase();

        return $this;
    }

    /**
     * Returns true if the internal database was already loaded
     *
     * @return boolean
     */
    protected function loadedDatabase(): bool
    {
        return !empty($this->mimeDatabase);
    }

    /**
     * Load database file
     *
     * @return MimeDb
     */
    protected function loadDatabase(): MimeDb
    {
        $this->mimeDatabase = json_decode(file_get_contents($this->getDbFilename()), true);
        $this->mimeDatabase = array_filter(
            $this->mimeDatabase,
            function ($mimetypeDefinition) {
                return isset($mimetypeDefinition['extensions']) && !empty($mimetypeDefinition['extensions']);
            }
        );

        return $this;
    }

    /**
     * Find by file extension
     *
     * @param  string $lookuoFileExtension
     * @return string|null
     */
    public function findType(string $lookuoFileExtension): ?string
    {
        $this->initializeDatabase();

        $foundMimeTypes = array_filter(
            $this->mimeDatabase,
            function ($mimetypeDefinition) use ($lookuoFileExtension) {
                return in_array(ltrim($lookuoFileExtension, "."), $mimetypeDefinition['extensions']);
            }
        );

        if (count($foundMimeTypes) === 0) {
            return null;
        }

        return array_keys($foundMimeTypes)[0];
    }

    /**
     * Find by file extension
     * This is an alias function for findTyoe
     *
     * @param  string $lookuoFileExtension
     * @return string|null
     */
    public function findByExtension(string $lookuoFileExtension): ?string
    {
        return $this->findType($lookuoFileExtension);
    }

    /**
     * Find by mime type
     *
     * @param  string $lookupMimeType
     * @return string|null
     */
    public function findMimeType(string $lookupMimeType): ?string
    {
        $this->initializeDatabase();

        $foundMimeTypes = array_filter(
            $this->mimeDatabase,
            function ($mimetypeDefinition, $mimetype) use ($lookupMimeType) {
                return strcasecmp($mimetype, $lookupMimeType) === 0;
            },
            ARRAY_FILTER_USE_BOTH
        );

        if (reset($foundMimeTypes) === false) {
            return null;
        }

        return current($foundMimeTypes)["extensions"][0];
    }

    /**
     * Returns the full-qualified filename where
     * the database is located
     *
     * @return             string
     * @codeCoverageIgnore
     */
    private function getDbFilename(): string
    {
        return dirname(__FILE__) . "/assets/mimetypes.json";
    }
}
