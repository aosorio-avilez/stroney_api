<?php

namespace App\Features\Core\Framework\Helper;

use Aws\S3\S3Client;

/**
 * JWT factory for create valid JWT Tokens
 */
class S3UrlHelper
{
    /**
     * Get s3 url for path
     *
     * @param integer $path
     * @return string
     */
    public static function getUrl(string $path): string
    {
        return app(S3Client::class)->getObjectUrl(
            getenv('AWS_S3_BUCKET'),
            getenv('AWS_S3_PATH') . $path
        );
    }
}
