<?php

namespace Tests\Unit;



use App\Event;
use App\Member;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


//use PHPUnit\Framework\TestCase;

class EventControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //Test for add Member positive
    public function testAddMember()
    {
        $user = factory(User::class)->create();
        factory(Event::class)->create();
        $response =
            $this->actingAs($user, 'api')->

            withHeaders([
                'Content-Type' => 'multipart/form-data',
                'Accept' => 'application/json'

            ])->json('POST', '/api/add_member', ['name' => 'Sally','surname' => 'Sally','email' => 'test@tt.tt','event_id' => '1']);
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' =>'member was created'

            ]);
    }


    //Test for add Member positive
    public function testGetMembers()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create();

        Member::create([
            'name' => 'testName',
            'email' => 'testEmail@test.com',
            'surname' => 'TestLastName',
            'event_id'=>1
        ]);

        $response =
            $this->actingAs($user, 'api')->

            withHeaders([
                'Content-Type' => 'multipart/form-data',
                'Accept' => 'application/json'

            ]) ->json('post','/api/get_members',['event_id'=>1]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',

            ]);

    }




}
