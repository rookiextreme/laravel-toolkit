<?php
namespace Rookiextreme\LaravelToolkit\Qr;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Qr
{
    public function generateQr(string $extension = 'png', float $size = 500, mixed $value = null, $base64 = false)
    {
        $qr = QrCode::format($extension)->size($size);

        if($value)
        {
            $generate = $qr->generate($value);
            return $base64 ? base64_encode($generate) : $generate;
        }
       return null;
    }
}