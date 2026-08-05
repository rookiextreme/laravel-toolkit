<?php
namespace Rookiextreme\Toolkit\Date;

class DateFormatter
{
    public function reverse($date): string
    {
        return date('Y-m-d', strtotime($date));
    }

    public function regular($date): string
    {
        return date('d-m-Y', strtotime($date));
    }
}