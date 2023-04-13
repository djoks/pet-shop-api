<?php

namespace App\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Illuminate\Support\Facades\Storage;

class CryptoService
{
    protected string $appUrl;

    public function __construct()
    {
        $appUrl = config('app.url');

        if (! is_string($appUrl)) {
            throw
            new \RuntimeException('app.url config value must be a string');
        }

        $this->appUrl = $appUrl;
    }

    public function getConfig(): Configuration|null
    {
        $privateKey = $this->getPrivateKey();
        $publicKey = $this->getPublicKey();

        if (! $privateKey || ! $publicKey) {
            return null;
        }

        return Configuration::forAsymmetricSigner(
            new Sha256(),
            $privateKey,
            $publicKey
        );
    }

    public function getPrivateKey(): InMemory|null
    {
        $privateKeyContent = Storage::get('private_key.pem');

        if (! $privateKeyContent) {
            return null;
        }

        return InMemory::plainText($privateKeyContent);
    }

    public function getPublicKey(): InMemory|null
    {
        $publicKeyContent = Storage::get('public_key.pem');

        if (! $publicKeyContent) {
            return null;
        }

        return InMemory::plainText($publicKeyContent);
    }
}
