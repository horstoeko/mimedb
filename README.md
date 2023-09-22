# MimeDB

[![Latest Stable Version](https://poser.pugx.org/horstoeko/mimedb/v/stable.png)](https://packagist.org/packages/horstoeko/mimedb) [![Total Downloads](https://poser.pugx.org/horstoeko/mimedb/downloads.png)](https://packagist.org/packages/horstoeko/mimedb) [![Latest Unstable Version](https://poser.pugx.org/horstoeko/mimedb/v/unstable.png)](https://packagist.org/packages/horstoeko/mimedb) [![License](https://poser.pugx.org/horstoeko/mimedb/license.png)](https://packagist.org/packages/horstoeko/mimedb) [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/horstoeko/mimedb)

[![CI (Ant, PHP 7.3)](https://github.com/horstoeko/mimedb/actions/workflows/build.php73.ant.yml/badge.svg)](https://github.com/horstoeko/mimedb/actions/workflows/build.php73.ant.yml) [![CI (Ant, PHP 7.4)](https://github.com/horstoeko/mimedb/actions/workflows/build.php74.ant.yml/badge.svg)](https://github.com/horstoeko/mimedb/actions/workflows/build.php74.ant.yml) [![CI (PHP 8.0)](https://github.com/horstoeko/mimedb/actions/workflows/build.php80.ant.yml/badge.svg)](https://github.com/horstoeko/mimedb/actions/workflows/build.php80.ant.yml) [![CI (PHP 8.1)](https://github.com/horstoeko/mimedb/actions/workflows/build.php81.ant.yml/badge.svg)](https://github.com/horstoeko/mimedb/actions/workflows/build.php81.ant.yml)

## Table of Contents

- [MimeDB](#mimedb)
  - [Table of Contents](#table-of-contents)
  - [License](#license)
  - [Overview](#overview)
  - [Dependencies](#dependencies)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Get all MimeTypes by file extensions](#get-all-mimetypes-by-file-extensions)
    - [Get all file extensions by MimeType](#get-all-file-extensions-by-mimetype)

## License

The code in this project is provided under the [MIT](https://opensource.org/licenses/MIT) license.

## Overview

With `horstoeko/mimedb` you can receive mimetypes by file extension and visa versa.

## Dependencies

This package has no dependencies.

## Installation

There is one recommended way to install `horstoeko/mimedb` via [Composer](https://getcomposer.org/):

* adding the dependency to your ``composer.json`` file:

```js
  "require": {
      ..
      "horstoeko/mimedb":"^1",
      ..
  },
```

## Usage

For detailed eplanation you may have a look in the [examples](https://github.com/horstoeko/mimedb/tree/master/examples) of this package and the documentation attached to every release.

### Get all MimeTypes by file extensions

```php
use horstoeko\mimedb\MimeDb;

require dirname(__FILE__) . "/../vendor/autoload.php";

$mimeDb = MimeDb::singleton();

// OUTPUT:
//   application/vnd.openxmlformats-officedocument.wordprocessingml.document

echo $mimeDb->findFirstMimeTypeByExtension('.docx') . PHP_EOL;

// OUTPUT:
//   application/vnd.openxmlformats-officedocument.wordprocessingml.document

foreach ($mimeDb->findAllMimeTypesByExtension('.docx') as $mimetype) {
    echo $mimetype . PHP_EOL;
}
```

### Get all file extensions by MimeType

```php

use horstoeko\mimedb\MimeDb;

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$mimeDb = MimeDb::singleton();

// OUTPUT:
//   docx

echo $mimeDb->findFirstFileExtensionByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document') . PHP_EOL;

// OUTPUT:
//   mkv
//   mk3d
//   mks

foreach ($mimeDb->findAllFileExtensionsByMimeType('video/x-matroska') as $fileExtension) {
    echo $fileExtension . PHP_EOL;
}

// OUTPUT:
//   docx

foreach ($mimeDb->findAllFileExtensionsByMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document') as $fileExtension) {
    echo $fileExtension . PHP_EOL;
}
```