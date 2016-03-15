<?php

use App\Member;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MemberControllerTest extends TestCase
{
    /*
    One option is to rollback the database after each test and migrate it before the next test.
    Laravel provides a simple DatabaseMigrations trait that will automatically handle this for you.
    Simply use the trait on your test class
    */
    //use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->name_generator = new NameGenerator;
        $this->addr_generator = new AddressGenerator;
    }
    public function testListMemberSuccess()
    {
        $this->get('/api/v1/member')->seeJson();
    }
}

?>
