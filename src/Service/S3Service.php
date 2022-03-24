<?php

declare(strict_types=1);

namespace App\Service;

use Aws\S3\S3Client;
use App\Factory\S3ClientFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class S3Service
{
    private S3Client $client;

    public function __construct(S3ClientFactory $clientFactory, private string $bucket)
    {
        $this->client = $clientFactory->createClient();
    }

    public function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * Uploads a file to Amazon S3
     *
     * @param UploadedFile $file File.
     * @param string $path Path inside the bucket.
     * @param string $filename Name of the file.
     * @return string URL of the uploaded file.
     */
    public function upload(UploadedFile $file, string $path = '', string $filename = ''): string
    {
        $filename = $filename ?: $file->getClientOriginalName();
        $folderPath = !empty($path) ? "$path/" : '';
        $result = $this->client->putObject([
            'ACL' => 'public-read',
            'Bucket' => $this->bucket,
            'Key' => $folderPath . $filename,
            'SourceFile' => $file->getRealPath(),
            'ContentType' => $file->getMimeType()
        ]);

        $imageUrl = $result->get('ObjectURL');
        if (str_contains($imageUrl, 'minio')) {
            $imageUrl = str_replace('minio', 'localhost', $imageUrl);
        }

        return $imageUrl;
    }

    /**
     * Deletes an object inside Amazon S3
     *
     * @param string $key Path to the file inside the bucket.
     * @return bool
     */
    public function delete(string $key): bool
    {
        $result = $this->client->deleteObject([
            'Bucket' => $this->bucket,
            'Key' => $key
        ]);

        if ($result['DeleteMarker']) {
            return true;
        }
        return false;
    }
}
