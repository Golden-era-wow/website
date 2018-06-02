<?php

namespace Tests\Unit;

use App\IngameMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngameMailTest extends TestCase
{
    /**
     * @test
     */
    public function itBuildsACommandString()
    {
        $mail = new IngameMail;
        $mail->to = 'john@example.com';
        $mail->subject = 'hello';
        $mail->body = 'world';
        $mail->items = [[2,4], [3,1], [4,2]];

        $this->assertEquals("john@example.com hello world 2:4 3:1 4:2", $mail->toCommandString());
    }
}
