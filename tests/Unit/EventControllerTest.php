<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;

class EventControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddMember()
    {
        $user = factory(User::class)->create();

//        Passport::actingAs(
//            factory(User::class)->create()
//);

        $response =
//            $this->actingAs($user, 'api')->

            $this->withHeaders([
                'Content-Type' => 'multipart/form-data',
            'Accept' => 'application/json',

            //'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmJhZTM5YWVlZmI0NjM3MDlhOTliNzkwMjc2NzdjZTZiMjllMjAyNzM1YWEzZjUzODJkMTdkYTJlMmNiODI1YzcxOGM1YzgwMmVlYjExNGYiLCJpYXQiOjE1OTQ1NDcyNTIsIm5iZiI6MTU5NDU0NzI1MiwiZXhwIjoxNjI2MDgzMjUyLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.KBfdzpOa004Th8760W-6yyLglj73O4v_eA8XE0WFtrnFrx-ri6OAxUuheOyh1nWz9kqhzuMBmMU7cQEj31SBgYtvKd1gFY6IWCmJncc5dpNOscpNSNxnaOnFs6qOr4tsdUn3tTt6YMMO7IgF1A0FHrK93nk-QlqFXza-ADAorKXz9L8L0Rb3qKuuwDtwZyIDYwURVeJwdHx5EXqbHpDCYCVjHdxxX0-djTldArRH22h8Eyqz02kTNH-0Esvo9xvkUL8z3WF1IjhsFB9qPh0cZ0ot16HnUy9LreimSMrVcM7afDFcQM808Qdp31_71vacsvxs2lXe79mfBOgOGBbTrQN-NWVlLSQmqsQwojDlwObgRdYpxH_G3pWzd19BB1z7KowmsPOHeS6gvgKEAa0mdwGn_pyTg9Ob75AsM_sDFikvQ7RC3JA9C9lPOE5RrwOFqRPeAE6AtTTD31kCFmxJOAMvGbqNXPKobhE4z5kMDVojqz0eO4YeB1-4YpWzl5ME_YtwpGnNFxbGS7EDlLe-ocfQNwivmyymZUz3SHn0gZ4H9xGQaHS-X4YzeS0bCLglygVQhEsBdulRZhvi5MJ01J_CAFZTmBHCr7y766s8ObXvO_5Etur45IUoNXcQHj34NovdEhXcbtxKFcfZij7MGM9B-su_oT4FYILf0Uybibc',
        ])->json('POST', '/api/add_member', ['name' => 'Sally']);
            $response
                ->assertStatus(200)
                ->assertJson([
                    'message' =>'member was created',
                ]);
    }




}
