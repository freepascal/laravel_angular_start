<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MakeTest extends TestCase
{
    public function testExample()
    {
        $this->visit('/');
        $this->assertTrue(true);
    }
}
