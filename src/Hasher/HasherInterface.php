<?php

namespace CleverAge\SyliusColissimoPlugin\Hasher;

interface HasherInterface
{
    public function hash(string $data, string $encryptionKey): string;

    public function decrypt(string $hashedData, string $encryptionKey): string;
}
