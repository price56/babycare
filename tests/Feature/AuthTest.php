<?php

namespace Tests\Feature;

use App\Events\UserJoinEvent;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @test
     * @group auth
     */
    public function 회원가입을_할_경우_user_join_event_가_발생한다()
    {
        $userData = User::factory()->make()->toArray();
        $userData['password_confirmation'] = $userData['password'] = 'password1234';
        Event::fake();
        Event::assertNothingDispatched();
        $this->postJson(route('auth.join'), $userData)->assertCreated();
        Event::assertDispatched(UserJoinEvent::class);
    }


    /**
     * @test
     * @group auth
     */
    public function 올바른_이메일과_비밀번호로_로그인_할_수_있다()
    {
        $response = $this->postJson(route('auth.login'), $this->successLoginData($this->email()));

        $response->assertStatus(200)
            ->assertSeeText('access_token');
    }

    /**
     * @test
     * @group auth
     */
    public function 올바른_이메일과_틀린_비밀번호로는_로그인_할_수_없다()
    {
        $this->withExceptionHandling();

        $response = $this->postJson(route('auth.login'), $this->failLoginData($this->email()));

        $response
            ->assertUnauthorized()
            ->assertJsonStructure([
            'message',
            'exception',
            'file',
            'trace',
        ]);
    }

    /**
     * @test
     * @group auth
     */
    public function 올바른_휴대폰번호와_비밀번호로_로그인_할_수_있다()
    {
        $response = $this->postJson(route('auth.login'), $this->successLoginData($this->mobile()));

        $response->assertStatus(200)
            ->assertSeeText('access_token');
    }

    /**
     * @test
     * @group auth
     */
    public function 올바른_휴대폰번호와_틀린비밀번호로는_로그인_할_수_없다()
    {
        $this->withExceptionHandling();

        $response = $this->postJson(route('auth.login'), $this->failLoginData($this->mobile()));

        $response
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
                'exception',
                'file',
                'trace',
            ]);
    }

    /**
     * @test
     * @group auth
     */
    public function 회원의_로그인은_필수값이_입력되지_않으면_에러를_리턴한다()
    {
        $this->withExceptionHandling();
        // mobile or email 검증
        $this->postJson(route('auth.login'), [
            'password' => self::PASSWORD,
        ])->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);

        // password 검증 1
        $this->postJson(route('auth.login'), [
            'mobile' => self::PASSWORD,
        ])->assertStatus(422)
            ->assertSee('password')
            ->assertJsonStructure([
                'message',
                'errors',
            ]);

        // password 검증 2
        $this->postJson(route('auth.login'), [
            'email' => self::PASSWORD,
        ])->assertStatus(422)
            ->assertSee('password')
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }
}
