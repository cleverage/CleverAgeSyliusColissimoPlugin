<?php

namespace CleverAge\SyliusColissimoPlugin\Hasher;

final class CredentialsHasher implements HasherInterface
{
    private const CIPHER_ALGO = 'aes-256-ecb';

    public function hash(string $data, string $encryptionKey): string
    {
        return openssl_encrypt($data, self::CIPHER_ALGO, $encryptionKey);
    }

    public function decrypt(string $hashedData, string $encryptionKey): string
    {
        return openssl_decrypt($hashedData, self::CIPHER_ALGO, $encryptionKey);
    }
}
