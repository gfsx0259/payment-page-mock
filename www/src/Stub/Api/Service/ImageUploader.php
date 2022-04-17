<?php

declare(strict_types=1);

namespace App\Stub\Api\Service;

use Exception;

class ImageUploader
{
    public const MIME_TYPES = [
        'jpg',
        'jpeg',
        'png',
        'svg'
    ];

    private string $fileNamePattern = 'img.%s';
    private string $uploadPath = 'public/uploads/route/';
    private string $dataUriPattern = '/data:image\/(.+);base64,(.*)/';

    /**
     * @throws Exception
     */
    public function handle(string $dataUri, array $availableMimeTypes = self::MIME_TYPES): string
    {
        if (!preg_match($this->dataUriPattern, $dataUri, $matches)) {
            throw new Exception('did not match data URI with image data');
        }

        $imageExtension = $matches[1];
        $encodedImageData = $matches[2];
        $decodedImageData = base64_decode($encodedImageData);

        if (!in_array($imageExtension, $availableMimeTypes)) {
            throw new Exception('invalid mime type');
        }

        if ($decodedImageData === false) {
            throw new Exception('base64_decode failed');
        }

        return $this->upload($decodedImageData, $imageExtension);
    }

    /**
     * @throws Exception
     */
    private function upload(string $decodedImageData, string $imageExtension): string
    {
        $fileName = sprintf($this->fileNamePattern, $imageExtension);

        if (file_put_contents($this->uploadPath . $fileName, $decodedImageData) !== false) {
            return $fileName;
        }

        throw new Exception('Can not load file image');
    }
}
