<?php
namespace Rookiextreme\LaravelToolkit\Date;

class DateFormatter
{
    public function reverse(string $date): string
    {
        return date('Y-m-d', $this->parseDate($date));
    }

    public function regular(string $date): string
    {
        return date('d-m-Y', $this->parseDate($date));
    }

    public function parseDate($date)
    {
        $timestamp = strtotime($date);

        if($timestamp === false)
        {
            throw new \InvalidArgumentException('Invalid date : '.$date);
        }

        return $timestamp;
    }
}