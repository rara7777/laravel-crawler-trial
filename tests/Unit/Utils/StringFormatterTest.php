<?php

namespace Tests\Unit\Utils;

use App\Utils\StringFormatter;
use Tests\TestCase;

class StringFormatterTest extends TestCase
{
    /** @test */
    public function it_can_get_title()
    {
        $string = '<title>myTitle</title>';
        $result = StringFormatter::getTitle($string);
        $this->assertEquals('myTitle', $result);
    }

    /** @test */
    public function it_can_get_description()
    {
        $string = '<meta="description" content="myDescription">';
        $result = StringFormatter::getDescription($string);
        $this->assertEquals('myDescription', $result);
    }
}
