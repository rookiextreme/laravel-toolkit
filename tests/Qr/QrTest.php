<?php
namespace Tests\Qr;

use PHPUnit\Framework\TestCase;
use Rookiextreme\LaravelToolkit\Qr\Qr;

class QrTest extends TestCase
{
    public function test_generate_qr()
    {
        $module = new Qr();
        $qr = $module->generateQr(
            'png',
            500,
            'https://example.com'
        );

        $this->assertNotNull($qr);
    }

    public function test_generate_qr_base64()
    {
        $module = new Qr();
        $qr = $module->generateQr(
            'png',
            500,
            'https://example.com',
            true
        );

        $this->assertNotNull($qr);
        $this->assertNotFalse(base64_decode($qr, true));
    }

    public function test_generate_qr_without_value()
    {
        $module = new Qr();
        $qr = $module->generateQr();

        $this->assertNull($qr);
    }
}