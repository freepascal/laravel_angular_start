<?php

use App\Http\Requests\MemberRequest;
//use Mockery;

//http://www.geoffakens.com/2015/02/08/disable-csrf-token-verification-for-laravel-5-unit-tests/

// mock MemberRequest to test upload_file
class MockMemberRequest
{
    function __construct()
    {

    }
}

class StoreMemberTest extends Illuminate\Foundation\Testing\TestCase
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
        return $app;
    }

    // UI Test
    public function testStoreSuccess_0()
    {
        //$this->visit('/create');
        /*
            ->type('name', $this->name_generator->phrase())
            ->type('address', $this->addr_generator->phrase())
            ->type('age', rand(1, 99))
            ->attach('file:///home/injury/Desktop/member/tests/img/00.jpg', photo)
            ->press('submit')
            ->seePageIs('/');
        */
    }

    public function testStoreSuccess()
    {
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99)
        );
        $new_data = array_merge($data, array(
            'photo'     => null,
            //'_token'    => Session::token()
        ));
        $response = $this->call('POST', '/api/v1/member', $new_data);
        // because of success, this redirect url
        $this->assertResponseStatus(302);
        // when success, redirect
        $this->assertRedirectedToRoute('member_list');
        $this->seeInDatabase("members", $data);
        $this->assertSessionHas('message', array(
            'type'  => 'success',
            'text'  => 'Create new member successfully'
        ));
    }

    public function testStoreSuccessAndRedirect()
    {
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
            'photo'     => null
        );
        $new_data = array_merge($data, array(
            '_token'    => Session::token()
        ));
        $response = $this->call('POST', '/api/v1/member', $new_data);
    }

    public function testStoreValidationNameError()
    {
        $data = array(
            'name'      => "$". $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99)
        );
        $test = array_merge($data, array(
            'photo'     => null,
            '_token'    => Session::token()
        ));
        $response = $this->call('POST', '/api/v1/member', $test);
        $this->notSeeInDatabase('members', $data);
    }

    public function testStoreValidationAddressError()
    {
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => "$". $this->addr_generator->phrase(). "$",
            'age'       => rand(1, 99)
        );
        $test = array_merge($data, array(
            'photo'     => null,
            '_token'    => Session::token()
        ));
        $response = $this->call('POST', '/api/v1/member', $test);
        $this->notSeeInDatabase('members', $data);
    }

    public function testStoreValidationAgeError()
    {
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => 200 + rand(1, 99)
        );
        $test = array_merge($data, array(
            'photo'     => null,
            '_token'    => Session::token()
        ));
        $response = $this->call('POST', '/api/v1/member', $test);
        $this->assertNotEquals(200, $response->status());
        $this->notSeeInDatabase('members', $data);
    }

    // test create member with a photo
    public function testStoreMember_WithMockingUploadFile_Success() {

        /* $path, $originalName, $mimeType = null, $size = null, $error = null, $test = false */
        // mock uploaded file
        // the last parameter indicates whether it is a test file.
        // If this is true, then it will fix your problems, as it skips the validity check.
        $uploaded_file = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $path = storage_path('img/00.jpeg'),
            $originalName = '00.jpeg',
            'image/jpeg',
            1024,
            null,
            $test_env = true
        );

        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
        );

        $this->call(
            'POST',
            '/api/v1/member',
            $data,
            $cookies = array(),
            $files = array('photo' => $uploaded_file),
            $server = array()
            /*
            $server = array(
                'Content-Type'  => 'multipart/form-data'
            )
            */
        );
        // redirect on success or redirect back if validation error
        $this->assertResponseStatus(302);
        //$this->seeInDatabase('members', $data);
    }

    public function testUploadFile()
    {
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
            '_token'    => Session::token(),
        );
    }

    public function testUploadFile2()
    {
        $uploaded_file = Mockery::mock(
            '\Symfony\Component\HttpFoundation\File\UploadedFile',
            array(
                'getClientOriginalName'      => 'image-1.jpg',
                'getClientOriginalExtension' => 'jpg',
            )
        );
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
        //    '_token'    => Session::token()
        );
        $response = $this->action(
            'POST', 'MemberController@store', [], $data, array('photo' => $uploaded_file)
        );
        var_dump($response);
        /*
        $response->assertSessionHas('message', array(
            'type'  => 'success',
            'text'  => 'Create new member successfully'
        ));
        */
    }

    // http://stackoverflow.com/questions/33281614/how-to-test-file-upload-with-laravel-and-phpunit
    public function test_upload_again_again_again()
    {
        $uploaded_file = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $path = storage_path('img/00.jpeg'),
            $originalName = '00.jpeg',
            'image/jpeg',
            1024,
            null,
            $test_env = true
        );
        $values = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99)
        );
        $response = $this->action(
            'POST',
            'MemberController@store',
            [],
            $values,
            [],
            array('photo' => $uploaded_file)
        );
        $this->assertResponseStatus(302);
        $this->assertSessionHas('message', array(
            'type'  => 'success',
            'text'  => 'Create new member successfully'
        ));
    }

    protected function setUp()
    {
        parent::setUp();
    }
}


?>
