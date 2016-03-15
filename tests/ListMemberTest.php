<?php

use App\Member;

class ListMemberTest extends Illuminate\Foundation\Testing\TestCase
{
    protected $baseUrl = 'localhost:8000';

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    public function testListMemberSuccess()
    {
        $this->get('/api/v1/member')->seeJson();
    }
}

?>
