<?php

namespace Entities;

use DateTime;

class File
{
    public function __construct(
        public string $id,
        public string $name,
        public string $path,
        public string $version,
        public string $asset_id,
        public string $description,
        public int $size,
        public int $created_at,
    ) {}

    /**
     * @return array{ file_name: string, mime_type: string, filesize: int, path: string }
     */
    public function getDownloadData(): array
    {
        $file_name = explode('/', $this->path);
        $file_name = $file_name[array_key_last($file_name)];

        $path = BASE_PATH . '../storage' . $this->path;
        $mime_type = mime_content_type($path);
        $filesize = filesize($path);

        return [
            'file_name' => $file_name,
            'mime_type' => $mime_type,
            'filesize' => $filesize,
            'path' => $path
        ];
    }

    public function getFormatedSize(): string
    {
        return formatBytes($this->size);
    }

    public function getFormatedCreatedAt(): string
    {
        $date = new DateTime();
        $date->setTimestamp($this->created_at);
        return $date->format('d M Y');
    }
}
