<?php

use App\Member;

class DeleteMemberTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->name_generator = new NameGenerator;
        $this->addr_generator = new AddressGenerator;
    }

    public function testDeleteSuccess()
    {
        // create a valid member on database
        $data = $this->makeValidData();
        $passed_data = array_merge($data, array(
            '_token'    => Session::token()
        ));
        $this->call('DELETE', '/api/v1/member/'. $data['member']->id, $passed_data);
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
        /*
        $this->seeInDatabase('members', $data['data']);
        $this->assertNotNull($data['member']);
        */
        return $data;
    }
}

?>
