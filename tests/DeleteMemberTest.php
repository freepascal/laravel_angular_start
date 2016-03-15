<?php

use App\Member;

class DeleteMemberTest extends Illuminate\Foundation\Testing\TestCase
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

    public function testDeleteSuccess()
    {
        // create a valid member on database
        $data = $this->makeValidData();
        $r_data = array_merge($data, array(
            '_token'    => Session::token()
        ));
        $this->call('DELETE', '/api/v1/member/'. $data['member']->id, $r_data);
        $this->notSeeInDatabase('members', $data['data']);
    }

    public function makeValidData()
    {
        $old_data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
            'photo'     => null
        );
        // insert a record to database and retrieve the id to make a PUT request
        $mem = Member::create($old_data);
        $data = array(
            'data'      => $old_data,
            'member'    => $mem
        );
        $this->seeInDatabase('members', $data['data']);
        $this->assertNotNull($data['member']);
        return $data;
    }
}

?>
