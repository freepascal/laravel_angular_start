<?php

class MemberControllerAgainTest extends Illuminate\Foundation\Testing\TestCase
{
    protected $baseUrl = 'localhost:8000';

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    public function test_can_upload_a_file()
    {
        // given
        $test_file_path = base_path(). '/tests/img/file.png';
        $this->assertTrue(file_exists($test_file_path), 'Test file does not exists');
    }
}

?>
