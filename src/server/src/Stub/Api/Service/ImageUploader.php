<?php

declare(strict_types=1);

namespace App\Stub\Api\Service;

use Exception;
use Yiisoft\Files\FileHelper;

class ImageUploader
{
    public const MIME_TYPES = [
        'jpg',
        'jpeg',
        'png',
        'svg',
        'svg+xml',
    ];

    private const MIME_TYPES_FILE_EXTENSION = [
        'svg+xml' => 'svg',
    ];

    private string $fileNamePattern = '%s.%s';
    private string $baseUploadPath = 'public/uploads/';
    private string $dataUriPattern = '/data:image\/(.+);base64,(.*)/';

    /**
     * @param string $uploadPath
     */
    public function setUploadPath(string $uploadPath): void
    {
        $this->baseUploadPath = $this->baseUploadPath . $uploadPath;
    }

    /**
     * @throws Exception
     */
    public function handle(string $dataUri, string $fileName): string
    {
        if (!preg_match($this->dataUriPattern, $dataUri, $matches)) {
            throw new Exception('did not match data URI with image data');
        }

        $fileExt = $matches[1];
        $encodedImageData = $matches[2];
        $decodedImageData = base64_decode($encodedImageData);

        if (!in_array($fileExt, self::MIME_TYPES)) {
            throw new Exception('invalid mime type');
        }

        if ($decodedImageData === false) {
            throw new Exception('base64_decode failed');
        }

        return $this->upload(
            $decodedImageData,
            $fileName,
            $fileExt
        );
    }

    /**
     * @throws Exception
     */
    private function upload(
        string $decodedImageData,
        string $fileName,
        string $fileExt
    ): string
    {
        FileHelper::ensureDirectory($this->baseUploadPath);

        $fullFileName = sprintf(
            $this->fileNamePattern,
            $fileName,
            self::MIME_TYPES_FILE_EXTENSION[$fileExt] ?? $fileExt
        );

        if (file_put_contents($this->baseUploadPath . $fullFileName, $decodedImageData) !== false) {
            return $fullFileName;
        }

        throw new Exception('Can not load file image');
    }
}
