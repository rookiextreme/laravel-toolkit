<?php
namespace Tests\Date;

use PHPUnit\Framework\TestCase;
use Rookiextreme\LaravelToolkit\Date\DateFormatter;

class DateFormatterTest extends TestCase
{
    public function test_reverse_date()
    {
        $formatter = new DateFormatter();
        $this->assertSame(
            '2026-08-01',
            $formatter->reverse('01-08-2026'),
            'Date reverse test successful'
        );
    }

    public function test_invalid_reverse_date()
    {
        $formmater = new DateFormatter();

        $this->expectException(\Exception::class);

        $formmater->reverse('Hello');
    }

    public function test_regular_date()
    {
        $formatter = new DateFormatter();
        $this->assertSame(
            '01-08-2026',
            $formatter->regular('2026-08-01'),
        );
    }

    public function test_invalid_regular_date()
    {
        $formmater = new DateFormatter();

        $this->expectException(\Exception::class);

        $formmater->regular('Hello');
    }

    public function test_reverse_accept_same_format(): void
    {
        $formatter = new DateFormatter();

        $this->assertSame(
            '2026-08-06',
            $formatter->reverse('2026-08-06')
        );
    }
}