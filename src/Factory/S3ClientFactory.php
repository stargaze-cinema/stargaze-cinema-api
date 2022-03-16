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
        $credentials = new Credentials($this->key, $this->secret);

        $s3 =  new S3Client([
            'version'     => 'latest',
            'region'      => $this->region,
            'credentials' => $credentials,
            'endpoint'    => 'http://minio:9000',
            'use_path_style_endpoint' => true,
        ]);

        dd($s3->listBuckets());

        return $s3;
    }
}
