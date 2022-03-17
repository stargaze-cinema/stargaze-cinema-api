<?php

namespace App\Factory;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

/**
 * Class S3ClientFactory
 * @package App\Factory
 */
class S3ClientFactory
{
    private string $region;

    private string $key;

    private string $secret;

    private string $endpoint;

    public function __construct(string $region, string $key, string $secret, string $endpoint)
    {
        $this->region = $region;
        $this->key = $key;
        $this->secret = $secret;
        $this->endpoint = $endpoint;
    }

    /**
     * Creates a S3 client
     *
     * @return S3Client
     */
    public function createClient(): S3Client
    {
        $s3 =  new S3Client([
            'version'     => 'latest',
            'region'      => $this->region,
            'credentials' => new Credentials($this->key, $this->secret),
            'endpoint'    => $this->endpoint,
            'use_path_style_endpoint' => true,
        ]);

        return $s3;
    }
}
