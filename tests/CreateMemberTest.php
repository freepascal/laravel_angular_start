<?php

/*
http://www.geoffakens.com/2015/02/08/disable-csrf-token-verification-for-laravel-5-unit-tests/
*/

class CreateMemberTest extends TestCase
{    
    public function testCreateViewSuccess()
    {
        $this->get('/api/v1/member/create');
        $this->assertViewHas('name', '');
        $this->assertViewHas('address', '');
        $this->assertViewHas('age', '');
    }
}

?>
