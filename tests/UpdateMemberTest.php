<?php

use App\Member;

class NameGenerator {
	protected $alphabetic;

	public function __construct() {
		$this->alphabetic = array_merge(
			range('a', 'z'),
			range('A', 'Z')
		);
	}

	function word($length) {
		$word = "";
		$count = count($this->alphabetic);
		for($i = 0; $i < $length; ++$i) {
			$word .= $this->alphabetic[rand(0, $count - 1)];
		}
		return $word;
	}

	function phrase($num_words = 2, $word_length = 6) {
		$phrase = "";
		for($i = 0; $i < $num_words; ++$i) {
			$phrase .= $this->word($word_length). " ";
		}
		return $phrase;
	}
}

class AddressGenerator extends NameGenerator {
    function phrase($num_words = 3, $word_length = 6) {
        return Parent::phrase($num_words, $word_length);
    }
}


class UpdateMemberTest extends Illuminate\Foundation\Testing\TestCase
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

    public function testUpdateSuccess()
    {
        // make a valid member in database
        $data = $this->makeValidData();
        $new_data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
            'photo'     => null
        );
        $this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
        $this->assertResponseStatus(200);
        $this->seeInDatabase('members', $new_data);
        $this->notSeeInDatabase('members', $data['data']);
    }

    public function testUpdateValidationNameMustRequired()
    {
        // make a valid member in database
        $data = $this->makeValidData();
        $new_data = array(
            'name'      => null,
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99),
            'photo'     => null
        );
        $this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
        //validation error
        $this->assertResponseStatus(302);
        $this->assertSessionHasErrors(array(
            'name'      => 'Name must be required'
        ));
    }

    public function testUpdateValidationError_NameMustAlphaAndSpace()
    {
        // make a valid member in database
        $data = $this->makeValidData();
        $new_data = array(
            'name'      => "$". $this->name_generator->phrase(). "$",
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99)
        );
        $this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
        // validation failed, redirect back
        $this->assertResponseStatus(302);
        $this->assertSessionHasErrors(array(
            'name'       => 'The name may only contain letters and spaces'
        ));
        $this->seeInDatabase('members', $data['data']);
    }

    public function testUpdateValidationError_NameLengthMustBeLessThan100()
    {
        // make a valid member in database
        $data = $this->makeValidData();
        $new_data = array(
            'name'      => $this->name_generator->phrase(200),
            'address'   => $this->addr_generator->phrase(),
            'age'       => rand(1, 99)
        );
        $this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
        $this->assertResponseStatus(302);
        $this->assertSessionHasErrors(array(
            'name'      => 'Name length must be <= 100'
        ));
        $this->seeInDatabase('members', $data['data']);
    }

    public function testUpdateValidationError_AddressMustBeAlphaAndSpaces()
    {
        // make a valid member in database
        $data = $this->makeValidData();
        $new_data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => "$". $this->addr_generator->phrase(). "$",
            'age'       => rand(1, 99)
        );
        $this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
        // validation failed, redirect back
        $this->assertResponseStatus(302);
        $this->assertSessionHasErrors(array(
            'address'       => 'The address may only contain letters and spaces'
		));
        $this->seeInDatabase('members', $data['data']);
    }

    public function testUpdateValidationAgeError()
    {
        // make a valid member in database
        $data = $this->makeValidData();
        $new_data = array(
            'name'      => $this->name_generator->phrase(),
            'address'   => $this->addr_generator->phrase(),
            'age'       => 200 +rand(1, 99)
        );
        $this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
        // validation failed, redirect back
        $this->assertResponseStatus(302);
        $this->seeInDatabase('members', $data['data']);
    }

	public function testUpdateValidationError_Photo()
	{
		// make a valid member in database
		$data = $this->makeValidData();
		$new_data = array(
			'name'		=> $this->name_generator->phrase(),
			'address'	=> $this->addr_generator->phrase(),
			'age'		=> rand(1, 99)
		);
		// attach a file to the form
		/*
		$this->attach('tests/img/00.jpg', 'photo');
		$this->call('PUT', '/api/v1/member/'. $data['member']->id, $new_data);
		*/
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
