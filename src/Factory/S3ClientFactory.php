<?php

namespace App\Factory;

use Aws\S3\S3Client;

/**
 * Class S3ClientFactory
 * @package App\Factory
 */
final class S3ClientFactory
{
    const AMAZON_S3_VERSION = '2006-03-01';

    private string $region;

    private string $key;

    private string $secret;

    public function __construct(string $region, string $key, string $secret)
    {
        $this->region = $region;
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * Creates a S3 client
     *
     * @return S3Client
     */
    public function createClient(): S3Client
    {
        return new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ]
        ]);
    }
}
