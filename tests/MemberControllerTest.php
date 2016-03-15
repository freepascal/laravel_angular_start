<?php

use App\Member;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MemberControllerTest extends Illuminate\Foundation\Testing\TestCase
{
    protected $baseUrl = 'localhost:8000';
    protected $name_generator;
    protected $addr_generator;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $this->name_generator = new NameGenerator;
        $this->addr_generator = new AddressGenerator;

        //vfsStreamWrapper::register();
        return $app;
    }

    public function testListMemberSuccess()
    {
        $this->get('/api/v1/member')->seeJson();
    }
}

?>
