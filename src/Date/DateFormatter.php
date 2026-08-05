<?php
namespace Rookiextreme\LaravelToolkit\Date;

class DateFormatter
{
    public function reverse(string $date): string
    {
        $timestamp = strtotime($date);

        if($timestamp === false)
        {
            throw new \InvalidArgumentException('Invalid date : '.$date);
        }

        return date('Y-m-d', strtotime($date));
    }

    public function regular(string $date): string
    {
        $timestamp = strtotime($date);

        if($timestamp === false)
        {
            throw new \InvalidArgumentException('Invalid date : '.$date);
        }

        return date('d-m-Y', strtotime($date));
    }
}