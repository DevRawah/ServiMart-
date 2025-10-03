<?php

class Upload
{
    protected $uploadDir;
    protected $defaultUploadDir = 'Uploads';
    public $file;
    public $fileName;
    public $filePath;
    protected $rootDir;
    protected $errors = [];


    public function __construct($uploadDir, $rootDir = false)
    {
        if ($rootDir) {
            $this->rootDir = $rootDir;
        } else {
            $this->rootDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
        }
        $this->filePath =  $uploadDir;
        $this->uploadDir = $this->rootDir . '/' . $uploadDir;
    }

    protected function validate()
    {
        if (!$this->isSizeAllowed()) {
            array_push($this->errors, 'File size not allowed');
        }
        if (
            isset($this->file['tmp_name']) &&
            file_exists($this->file['tmp_name']) &&
            is_uploaded_file($this->file['tmp_name'])
        ) {
            if (!$this->isMimeAllowed()) {
                $this->errors[] = 'File type not allowed';
            }
        }
        return $this->errors;
    }

    protected function createUploadDir()
    {
        if (!is_dir($this->uploadDir)) {
            umask(0);
            if (!mkdir($this->uploadDir, 0775)) {
                array_push($this->errors, 'Could not create upload dir');
                return false;
            }
        }
        return true;
    }

    public function upload()
    {
        $this->fileName = time() . '_' . basename($this->file['name']);
        $this->filePath .= '/' . $this->fileName;

        if ($this->validate()) {
            return $this->errors;
        }

        if (!$this->createUploadDir()) {
            return $this->errors;
        }

        $destination = $this->uploadDir . '/' . $this->fileName;
        if (!move_uploaded_file($this->file['tmp_name'], $destination)) {
            $this->errors[] = 'Error uploading your file';
            return $this->errors;
        }
        return true;
    }

    protected function isMimeAllowed()
    {
        $allowed = [
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'html' => 'text/html'
        ];

        if (
            empty($this->file['tmp_name']) ||
            !file_exists($this->file['tmp_name'])
        ) {
            return false;
        }

        $fileMimeType = mime_content_type($this->file['tmp_name']);

        return in_array($fileMimeType, $allowed);
    }

    protected function isSizeAllowed()
    {
        $maxFailSize = 10 * 1024 * 1024;
        $fileSize = $this->file['size'];

        if ($fileSize > $maxFailSize) {
            return false;
        };
        return true;
    }
}
