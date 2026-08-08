# Laravel Toolkit

A collection of reusable Laravel utilities for common development tasks.

> ⚠️ This package is currently a personal learning project.
> It is used to learn Composer packages, PHPUnit, package architecture, and Laravel package development while also serving as a reusable toolkit for my own Laravel applications.

## Usage

### DateFormatter

```php
use RookieXtreme\LaravelToolkit\Date\DateFormatter;

$dateFormatter = new DateFormatter();

$dateFormatter->reverse('06-08-2026');
// 2026-08-06

$dateFormatter->regular('2026-08-06');
// 06-08-2026
```

### API Response Helper

Build the payload
```php
use RookieXtreme\LaravelToolkit\Response\ApiResponse;

$apiResponse = new ApiResponse();

//Status can be either 'success' or 'error' only

$payload = $apiResponse->buildMessagePayload('success', 'Some label');
/*
    [
        'status' => 'success',
        'message' => 'Some label'
    ]
*/

$payload = $apiResponse->buildDataPayload('success', ['id' => 1, 'something' => true]);
/*
    [
        'status' => 'success',
        'data' => ['id' => 1, 'something' => true]
    ]
*/
```

Send payload to build JSON response
```php
$apiResponse->jsonResponse($payload)
//returns Laravel JSON response object
```

## Features

- ✅ Date Formatter
- ✅ API Response Helper
- 🚧 More coming soon

## Installation

```bash
composer require rookiextreme/laravel-toolkit
```

## Roadmap

- [x] Date Formatter
- [x] API Response Helper
- [ ] Image Uploader
- [ ] Model Actions
- [ ] Validation Helpers
- [ ] File Utilities

## License

MIT