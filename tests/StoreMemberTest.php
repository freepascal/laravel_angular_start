<?php

use App\Member;
use App\Http\Requests\MemberRequest;

/*
If we don't, we need to add a field called '_token' => Session->token()
http://www.geoffakens.com/2015/02/08/disable-csrf-token-verification-for-laravel-5-unit-tests/
*/
class StoreMemberTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->name_generator = new NameGenerator;
        $this->addr_generator = new AddressGenerator;
    }

    public function clearDatabase()
    {
        $this->call('DELETE', '/api/v1/member/'. $data['member']->id, $r_data);
        $this->notSeeInDatabase('members', $data['data']);
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

    /*
    If this test generates errors, please read:
        https://laracasts.com/discuss/channels/general-discussion/runtimeexception-on-fresh-install?page=1
    */
    public function testStoreMemberWithUploadedFile_Success()
    {
        $data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99)
        );
        $this->visit('/create')
            ->type($data['name'],               $field = 'name')
            ->type($data['address'],           'address')
            ->type($data['age'],               'age')
            ->attach(storage_path('/img/file.png'), 'photo')
            ->press('Create');
        $this->seeInDatabase('members', $data);
    }
}

?>
