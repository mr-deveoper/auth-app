<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Shared\MockSocialite;
use Tests\TestCase;
use Laravel\Socialite\Contracts\Factory as Socialite;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class GoogleLoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private function mockSocialite(int $id, string $email, string $name): void
    {
        $socialiteUser = $this->createMock(\Laravel\Socialite\Two\User::class);
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;
        $socialiteUser->name = $name;

        $socialiteUser->expects($this->any())
            ->method('getId')
            ->willReturn($id);
        $socialiteUser->expects($this->any())
            ->method('getName')
            ->willReturn($name);
        $socialiteUser->expects($this->any())
            ->method('getEmail')
            ->willReturn($email);
        $socialiteUser->expects($this->any())
            ->method('getAvatar')
            ->willReturn('https://lh3.googleusercontent.com/a/AATXAJyjvc3Ab4YyUA-vI8hkMVwxX-RUAdzw-PWSYNRL=s96-c');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);
        $provider->expects($this->any())
            ->method('stateless')
            ->willReturn($provider);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }

    private function mockSocialiteException(): void
    {
        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willThrowException(new ClientException(
                'Socialite Exception',
                new Request('GET', 'https://testing.com'),
                new Response()
            ));
        $provider->expects($this->any())
            ->method('stateless')
            ->willReturn($provider);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }

    public function test_redirect_to_google()
    {
        $this
            ->get(route('loginWithGoogle'))
            ->assertStatus(302)
            ->assertSee('accounts.google.com/o/oauth2/auth');
    }

    public function test_create_new_user_on_first_authentication()
    {
        $this->mockSocialite(123, 'test@test.com', 'Test');

        $this
            ->get(route('googleCallback'))
            ->assertStatus(302);

        $this->assertDatabaseCount(User::class, 1);
        /** @var User $user */
        $user = User::query()->first();

        $this->assertSame('123', $user->google_id);
        $this->assertSame('Test', $user->name);
        $this->assertSame('test@test.com', $user->email);
    }

    public function test_get_existing_user_on_non_first_authentication()
    {
        $this->mockSocialite(123, 'test@test.com', 'Test');

        $this
            ->get(route('googleCallback'))
            ->assertStatus(302);

        $this->assertDatabaseCount(User::class, 1);
    }

    public function test_throws_exception_when_user_not_authenticated()
    {
        $this->mockSocialiteException();

        $this
            ->get(route('googleCallback'))
            ->assertStatus(500)
            ->assertSee('Error happened while login with google!');

        $this->assertDatabaseCount(User::class, 1);
    }
}
