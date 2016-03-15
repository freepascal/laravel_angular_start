<?php

use App\Member;

class ListMemberTest extends TestCase
{
    public function testListMemberSuccess()
    {
        $this->get('/api/v1/member')->seeJson();
    }
}

?>
