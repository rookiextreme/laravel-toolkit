<?php
declare(strict_types=1);
namespace Tests\Upload;

use Illuminate\Http\UploadedFile;
use Orchestra\Testbench\TestCase;
use Rookiextreme\LaravelToolkit\Upload\FileUpload;
use Rookiextreme\LaravelToolkit\Upload\UploadOptions;

class FileUploaderTest extends TestCase
{
    public function test_get_extension_param_error()
    {
        $upload = new FileUpload();

        $this->expectException(\TypeError::class);
        $upload->getExtension('dsfds');
    }

    public function test_get_extension_param_success()
    {
        $upload = new FileUpload();
        $mockFile = UploadedFile::fake()->create('image.png', 100);

        $this->assertSame(
            'png',
            $upload->getExtension($mockFile)
        );
    }

    public function test_validate_allowed_extension_param_array_error()
    {
        $upload = new FileUpload();

        $this->expectException(\TypeError::class);
        $upload->validateAllowedExtension(['image' => 'someimage.png'], ['pdf', 'png']);
    }

    public function test_validate_allowed_extension_no_extension_error()
    {
        $upload = new FileUpload();

        $this->expectException(\TypeError::class);
        $upload->validateAllowedExtension(['png', 'pdf']);
    }

    public function test_validate_allowed_extension_empty_extensions()
    {
        $upload = new FileUpload();

        $this->expectException(\TypeError::class);
        $upload->validateAllowedExtension('exe');
    }

    public function test_validate_allowed_extension_not_allowed_extension()
    {
        $upload = new FileUpload();
        $this->assertFalse($upload->validateAllowedExtension('exe', ['pdf', 'png']));
    }

    public function test_validate_allowed_extension_allowed_extension()
    {
        $upload = new FileUpload();
        $this->assertIsBool($upload->validateAllowedExtension('pdf', ['pdf', 'png']));
    }

    public function test_validate_filename_incorrect_format()
    {
        $upload = new FileUpload();
        $this->expectException(\TypeError::class);
        $upload->getSavedFileName(1);
    }

    public function test_validate_filename_use_original_name()
    {
        $upload = new FileUpload();
        $options = new UploadOptions(
            useOriginalName: true,
            useOriginalNameUnique: false,
            useRandomIntName: false
        );
        $this->assertSame(
            'imaging',
            $upload->getSavedFileName('imaging', $options)
        );
    }

    public function test_validate_filename_use_unique()
    {
        $upload = new FileUpload();
        $options = new UploadOptions(
            useOriginalName: false,
            useOriginalNameUnique: true,
            useRandomIntName: false
        );
        $this->assertStringContainsString(
            '_',
            $upload->getSavedFileName('imaging', $options)
        );
    }

    public function test_validate_filename_use_random_int()
    {
        $upload = new FileUpload();
        $options = new UploadOptions(
            useOriginalName: false,
            useOriginalNameUnique: false,
            useRandomIntName: true
        );
        $this->assertTrue(is_numeric($upload->getSavedFileName('imaging', $options)));
    }

    public function test_validate_filename_all_false()
    {
        $upload = new FileUpload();
        $options = new UploadOptions(
            useOriginalName: false,
            useOriginalNameUnique: false,
            useRandomIntName: false
        );
        $this->assertTrue(is_string($upload->getSavedFileName('imaging', $options)));
    }

    public function test_storage_no_param_error()
    {
        $upload = new FileUpload();
        $this->expectException(\TypeError::class);
        $upload->checkAllowedDestination();
    }

    public function test_storage_param_not_string_error()
    {
        $upload = new FileUpload();
        $this->expectException(\TypeError::class);
        $upload->checkAllowedDestination(22);
    }

    public function test_storage_param_no_available_storage_error()
    {
        $upload = new FileUpload();
        $this->expectException(\Exception::class);
        $upload->checkAllowedDestination('hello');
    }

    public function test_storage_param_correct()
    {
        $upload = new FileUpload();
        $this->assertNull($upload->checkAllowedDestination('public'));
    }

    public function test_upload()
    {
        $upload = new FileUpload();
        $image = UploadedFile::fake()->image('image.png', 100);

        $this->assertIsArray($upload->uploadFileInApp($image, 'uploads/images', new UploadOptions(extensions: ['jpg', 'png'])));
    }

    public function test_upload_no_option_error()
    {
        $upload = new FileUpload();
        $image = UploadedFile::fake()->image('image.png', 100);

        $this->expectException(\Exception::class);
        $upload->uploadFileInApp($image, 'uploads/images');
    }

    public function test_upload_no_option_and_path_error()
    {
        $upload = new FileUpload();
        $image = UploadedFile::fake()->image('image.png', 100);

        $this->expectException(\ArgumentCountError::class);
        $upload->uploadFileInApp($image);
    }

    public function test_upload_no_params_error()
    {
        $upload = new FileUpload();

        $this->expectException(\ArgumentCountError::class);
        $upload->uploadFileInApp();
    }

    public function test_upload_wrong_extension()
    {
        $upload = new FileUpload();
        $image = UploadedFile::fake()->image('image.png', 100);

        $this->expectException(\Exception::class);
        $upload->uploadFileInApp($image, 'uploads/images', new UploadOptions(extensions: ['pdf']));
    }
}