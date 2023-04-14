<?php

namespace App\Services;

use App\Models\User;
use DateTimeImmutable;
use Lcobucci\JWT\Token;
use App\Models\JwtToken;
use Illuminate\Support\Str;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\JoseEncoder;

class TokenService
{
    protected \App\Services\CryptoService $cryptoService;

    protected string $appUrl;

    public function __construct(\App\Services\CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
        $this->appUrl = config('app.url');
        if (!is_string($this->appUrl)) {
            throw
            new \RuntimeException('app.url config value must be a string');
        }
    }

    public function generate(
        User|null $user
    ): string {
        if (!$user) {
            return '';
        }

        $now = new DateTimeImmutable();
        $expiresAt = $now->modify('+1 hour');

        $config = $this->cryptoService->getConfig();
        $jwt = $this->save(user: $user, expiresAt: $expiresAt);

        return $this->buildToken(
            config: $config,
            jwt: $jwt,
            user: $user,
            now: $now
        );
    }

    public function save(
        User|null $user,
        DateTimeImmutable $expiresAt
    ): JwtToken {
        if ($user) {
            return JwtToken::create([
                'user_id' => $user->id,
                'unique_id' => Str::uuid(),
                'token_title' => $this->generateTitle(),
                'restrictions' => null,
                'permissions' => null,
                'expires_at' => $expiresAt,
            ]);
        }

        return new JwtToken();
    }

    public function generateTitle(): string
    {
        $deviceMatches = $this->getUserAgent();

        // Get the device and OS names
        $device = $deviceMatches[0] ?? 'Unknown Device';
        $os = $osMatches[0] ?? 'Unknown OS';

        // Construct the string
        return "Device: {$device}, OS: {$os}";
    }

    /**
     * @return array<string>
     */
    public function getUserAgent(): array
    {
        $userAgent = request()->header('User-Agent');

        // Device and OS patterns
        $devicePattern = '/\b(?:iPhone|iPod|iPad|Android|BlackBerry
        |Windows Phone|webOS)\b/i';
        $osPattern = '/\b(?:Windows|Mac OS X|Linux|iOS|Android
        |Windows Phone|BlackBerry|webOS)\b/i';

        // Match the patterns against the User-Agent
        if ($userAgent) {
            preg_match($devicePattern, $userAgent, $deviceMatches);
            preg_match($osPattern, $userAgent, $osMatches);
        }

        return $deviceMatches;
    }

    public function decode(string $token): Token|null
    {
        $parser = new Parser(new JoseEncoder());

        if ($token) {
            return $parser->parse($token);
        }

        return null;
    }

    private function buildToken(
        Configuration|null $config,
        JwtToken $jwt,
        User $user,
        DateTimeImmutable $now
    ): string {

        if (!$config) {
            return '';
        }

        return $config->builder()
            ->issuedBy($this->appUrl)
            ->permittedFor($this->appUrl)
            ->identifiedBy($jwt->unique_id)
            ->relatedTo($user->email)
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('user_uuid', $user->uuid)
            ->getToken($config->signer(), $config->signingKey())
            ->toString();
    }
}
