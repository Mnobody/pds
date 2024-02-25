<?php

declare(strict_types=1);

namespace Shared\Infrastructure\FileSystem;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem as LeagueFileSystem;
use League\Flysystem\StorageAttributes;

final class FileSystem implements FileSystemInterface
{
    private const BUCKET_NAME = 'pdt';
    private const ROOT        = '/';

    private const KEY    = 'minioadmin';
    private const SECRET = 'minioadmin';

    private const REGION                  = 'us-east-1'; // default
    private const ENDPOINT                = 'http://minio:9000';
    private const USE_PATH_STYLE_ENDPOINT = true;

    private LeagueFileSystem $system;

    public function __construct()
    {
        $adapter = new AwsS3V3Adapter(
            new S3Client([
                'region'                  => self::REGION,
                'endpoint'                => self::ENDPOINT,
                'use_path_style_endpoint' => self::USE_PATH_STYLE_ENDPOINT,
                'credentials'             => [
                    'key'    => self::KEY,
                    'secret' => self::SECRET,
                ],
            ]),
            self::BUCKET_NAME,
        );

        $this->system = new LeagueFileSystem($adapter);
    }

    public function list(): array
    {
        return array_map(
            static fn (StorageAttributes $item) => $item->path(),
            $this->system->listContents(self::ROOT)->toArray(),
        );
    }

    public function exists(string $path): bool
    {
        return $this->system->fileExists($path);
    }

    public function read(string $path): string
    {
        return $this->system->read($path);
    }
}
