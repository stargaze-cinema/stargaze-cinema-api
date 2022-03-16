<?php

namespace App\Service;

use Aws\S3\S3Client;
use App\Factory\S3ClientFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class S3Service
{
    private S3Client $client;

    private string $bucket;

    public function __construct(S3ClientFactory $clientFactory, string $bucket)
    {
        $this->client = $clientFactory->createClient();
        $this->bucket = $bucket;
    }

    /**
     * Uploads a file to amazon s3 using
     *
     * @param UploadedFile $file
     * @param string $folderPath
     * @param string $fileName
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $folderPath, string $fileName): string
    {
        $folderPath = !empty($folderPath) ? "$folderPath/" : '';
        $path =   $folderPath . $fileName . '.'. $file->guessClientExtension();
        $result = $this->client->putObject([
            'Bucket' => $this->bucket,
            'SourceFile' => $file->getRealPath(),
            'Key' => $path
        ]);

        return $result->get('ObjectURL');
    }
}
