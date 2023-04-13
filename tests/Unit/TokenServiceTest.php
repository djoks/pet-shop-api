<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TokenService;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;

class TokenServiceTest extends TestCase
{
    /** @test */
    public function can_generate_jwt_token(): void
    {
        // Create a mock user object
        $user = User::factory()->create([
            'uuid' => Str::uuid()
        ]);

        // Instantiate the TokenService
        $tokenService = new TokenService();

        // Call the function to generate the JWT token with the user object
        $token = $tokenService->generate($user);

        // Verify that the token is not null and not empty
        $this->assertNotNull($token);
        $this->assertNotEmpty($token);
    }

    /** @test */
    public function can_generate_jwt_token_title(): void
    {
        $request = new Request();
        $request->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');

        // Instantiate the TokenService
        $tokenService = new TokenService();

        // Call the function to generate the JWT token title with the request object
        $title = $tokenService->generateTitle();

        // Verify that the token is not null and not empty
        $this->assertNotNull($title);
        $this->assertNotEmpty($title);
    }
}
