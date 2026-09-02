<?php
namespace Rookiextreme\LaravelToolkit\Upload;

class UploadOptions
{
    public function __construct(
        public array $extensions = [],
        public bool $useOriginalName = false,
        public bool $useOriginalNameUnique = false,
        public bool $useRandomIntName = false,
        public int $maxSize = 0,
        public int $minSize = 0,
        public string $destination = 'storage',
        public string $disk = 'public'
    ){}
}