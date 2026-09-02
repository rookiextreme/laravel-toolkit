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
## File Upload

The `FileUpload` feature provides a simple way to upload files with configurable upload options.

The uploaded file must be provided as an `Illuminate\Http\UploadedFile` object.

### Basic Usage

```php
use Illuminate\Http\UploadedFile;
use Rookiextreme\LaravelToolkit\Upload\UploadOptions;

$upload->uploadFileInApp(
    $image,
    'uploads/images',
    new UploadOptions(
        extensions: ['pdf']
    )
);
```

`$image` must be an `UploadedFile` object.

### Upload Options

`UploadOptions` allows you to configure how the file should be uploaded.

```php
class UploadOptions
{
    public function __construct(
        public array $extensions = [],
        public bool $useOriginalName = false,
        public bool $useOriginalNameUnique = false,
        public bool $useRandomIntName = false,
        public int $maxSize = 0,
        public int $minSize = 0,
        public string $destination = 'storage',
        public string $disk = 'public'
    ){}
}
```

| Option                  | Type     | Default     | Description                                                       |
| ----------------------- | -------- | ----------- | ----------------------------------------------------------------- |
| `extensions`            | `array`  | `[]`        | Allowed file extensions.                                          |
| `useOriginalName`       | `bool`   | `false`     | Saves the file using its original filename.                       |
| `useOriginalNameUnique` | `bool`   | `false`     | Saves the original filename with a random number appended.        |
| `useRandomIntName`      | `bool`   | `false`     | Generates a random integer as the filename.                       |
| `maxSize`               | `int`    | `0`         | Maximum allowed file size.                                        |
| `minSize`               | `int`    | `0`         | Minimum allowed file size.                                        |
| `destination`           | `string` | `'storage'` | Determines whether the file is uploaded to `storage` or `public`. |
| `disk`                  | `string` | `'public'`  | Laravel filesystem disk used when uploading to storage.           |

### Filename Options

#### Original Filename

```php
new UploadOptions(
    extensions: ['jpg'],
    useOriginalName: true
);
```

#### Original Filename with Random Number

```php
new UploadOptions(
    extensions: ['jpg'],
    useOriginalNameUnique: true
);
```

Example:

```text
profile_48291.jpg
```

#### Random Integer Filename

```php
new UploadOptions(
    extensions: ['jpg'],
    useRandomIntName: true
);
```

Example:

```text
48291.jpg
```

### File Size

Maximum and minimum file sizes can be configured using `maxSize` and `minSize`.

```php
new UploadOptions(
    extensions: ['jpg', 'png'],
    maxSize: 2048,
    minSize: 100
);
```

### Destination

By default, files are uploaded to the `storage` destination.

```php
new UploadOptions(
    extensions: ['pdf']
);
```

Files can also be uploaded directly to the `public` directory:

```php
new UploadOptions(
    extensions: ['jpg'],
    destination: 'public'
);
```

### Storage Disk

When using the `storage` destination, a specific Laravel filesystem disk can be selected.

```php
new UploadOptions(
    extensions: ['pdf'],
    destination: 'storage',
    disk: 'public'
);
```

### Return Value

The upload method returns an array containing the uploaded file's path and filename.

```php
[
    'path' => 'uploads/images',
    'name' => '48291.jpg'
]
```

### Artisan Command

The `toolkit:make-mail-job` command provides a quick way to generate a predefined mailing job template in the application's `app/Jobs` directory.

Instead of manually creating and setting up a new queued mailing job every time a new mailing scenario is needed, the command generates the basic job structure automatically. The generated job can then be customized according to the application's requirements.

```bash
php artisan toolkit:make-mail-job {filename?}
```

If no filename is provided, the command will prompt for one. If no value is entered, a default filename with a random number will be generated.


```bash
php artisan toolkit:make-mail-job {filename?}
```

You can provide the filename directly:

```bash
php artisan toolkit:make-mail-job RegistrationMailingJob
```

If no filename is provided, the command will ask for one.

If no value is entered again, a default filename will be generated with a random number, for example:

```text
MailingJob_5832
```

### Mailing Job

A generated mailing job can be dispatched like this:

```php
dispatch(new RegistrationMailingJob(
    type: 'notification',
    to: [
        $user->email => $user->name
    ],
    subject: 'Your Registration Confirmation',
    blade: 'mailing.registration-confirmation',
    data: [
        'user' => $user,
    ],
    attachment: public_path('assets/files/document.pdf'),
));
```

The `data` parameter can contain any data required by the mailing job, including arrays, strings, objects, Eloquent models, and other application data.

For example:

```php
data: [
    'user' => $user,
    'registration' => $registration,
    'facility' => $facility,
],
```

The mailing job is queued and can be customized according to the application's requirements.

## QR Code

Provides a simple helper for generating QR codes without repeatedly setting up the QR code library in each Laravel project.

### Generate QR Code

```php id="83215"
$qr = $toolkit->generateQr(
    extension: 'png',
    size: 500,
    value: 'https://example.com'
);
```

The method returns the generated QR code output.

### Generate Base64

Pass `true` as the fourth argument to return the QR code as a Base64-encoded string:

```php id="42871"
$qr = $toolkit->generateQr(
    extension: 'png',
    size: 500,
    value: 'https://example.com',
    base64: true
);
```

This is useful when embedding the QR code directly into an image element.

### Using in Blade

When using the Base64 option, the result can be placed directly into an `<img>` element:

```blade id="59034"
<img src="data:image/png;base64,{{ $toolkit->generateQr(
    'png',
    500,
    'https://example.com',
    true
) }}" alt="QR Code">
```

You can also generate the QR code in your controller and pass it to the view:

```php id="77126"
$qr = $toolkit->generateQr(
    'png',
    500,
    'https://example.com',
    true
);

return view('example', compact('qr'));
```

Then in Blade:

```blade id="31548"
<img src="data:image/png;base64,{{ $qr }}" alt="QR Code">
```

### Parameters

| Parameter    | Type     | Default | Description                                       |
| ------------ | -------- | ------- | ------------------------------------------------- |
| `$extension` | `string` | `png`   | QR code image format                              |
| `$size`      | `float`  | `500`   | QR code size                                      |
| `$value`     | `mixed`  | `null`  | Value to encode into the QR code                  |
| `$base64`    | `bool`   | `false` | Whether to return the generated QR code as Base64 |

If no value is provided, the method returns `null`.



## Features

- ✅ Date Formatter
- ✅ API Response Helper
- ✅ File Uploaded
- ✅ Predefined Mailing Job Command
- ✅ QR Code Generator
- 🚧 More coming soon

## Installation

```bash
composer require rookiextreme/laravel-toolkit
```

## Roadmap

- [x] Date Formatter
- [x] API Response Helper
- [x] Image Uploader
- [ ] Model Actions
- [ ] Validation Helpers
- [ ] File Utilities

## License

MIT