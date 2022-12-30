<?php

/**
 * Description of Upload
 * Responsible for uploading images, files and media to the system.
 * @author Klethônio Ferreira
 */
class Upload
{

    private $file;
    private $name;
    private $maxSize;
    private $allowed;

    /** IMAGE UPLOAD */
    private $width;
    private $image;
    
    /** FILE UPLOAD */
    private $allowedFiles = [ 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/pdf'
    ];

    /** MEDIA UPLOAD */
    private $allowedMedias = [
        'audio/mp3',
        'video/mp4'
    ];

    /** RESULT */
    private $result;
    private $error;

    /** PATHS */
    private $folder;
    private $destine;
    private static $baseDir;

    /**
     * Instantiate the class and check if the default or custom directory has already been created.
     * @param string $baseDir | (path ie. './uploads')
     */
    public function __construct(string $baseDir = './uploads')
    {
        self::$baseDir = $baseDir;
        if (!file_exists(self::$baseDir) && !is_dir(self::$baseDir)) {
            mkdir(self::$baseDir, 0777);
        }
    }

    /**
     * Just attach an array of type $_FILES and, if you want, a name and a custom width.
     * @param array $file | $_FILES (JPG or PNG)
     * @param string $name
     * @param int $width
     * @param string $folder | Custom folder
     */
    public function uploadImage(array $file, $name = null, $width = 1024, $folder = 'images'): void
    {
        $this->file = $file;
        $this->name = (string) $name ? $name : substr($this->file['name'], 0, strrpos($this->file['name'], '.'));
        $this->width = (int) $width ?? 1024;
        $this->folder = (string) $folder ?? 'images';
        $this->error = null;
        $this->result = null;

        $this->checkFolder($this->folder);
        $this->setFileName();
        $this->createImage();
    }

    /**
     * Just attach an array of type $_FILES from a file and, if you want, a name and a custom size.
     * @param array $file | $_FILES (PDF or DOCX)
     * @param string $name
     * @param string $folder | Custom folder
     * @param int $maxSize | (MB)
     */
    public function uploadFile(array $file, $name = null, $folder = 'files', $maxSize = 2): void
    {
        $this->file = $file;
        $this->name = (string) $name ? $name : substr($this->file['name'], 0, strrpos($this->file['name'], '.'));
        $this->folder = (string) $folder ?? 'files';
        $this->maxSize = (int) $maxSize ?? 2;
        $this->allowed = $this->allowedFiles;
        $this->error = null;
        $this->result = null;

        $this->moveFile($this->allowedFiles);
    }

    /**
     * Just attach an array of type $_FILES of a medium and, if you want, a name and a custom size.
     * @param array $file |  $_FILES (MP3 or MP4)
     * @param string $name
     * @param string $folder | Custom folder
     * @param int $maxSize (MB)
     */
    public function uploadMedia(array $file, $name = null, $folder = 'medias', $maxSize = 20): void
    {
        $this->file = $file;
        $this->name = (string) $name ? $name : substr($this->file['name'], 0, strrpos($this->file['name'], '.'));
        $this->folder = (string) $folder ??'medias';
        $this->maxSize = (int) $maxSize ?? 20;
        $this->allowed = $this->allowedMedias;
        $this->error = null;
        $this->result = null;

        $this->moveFile();
    }

    /**
     * By executing a getResult() it is possible to check if the Upload was successful or not.
     * @return string | Path and file name
     */
    public function getResult(): null|string
    {
        return $this->result;
    }

    /**
     * Returns a string with the last recorded error.
     * @return string
     */
    public function getError(): null|string
    {
        return $this->error;
    }

    //PRIVATE

    //Checks and creates directories.
    private function checkFolder($folder): void
    {
        list($y, $m) = explode('/', date('Y/m'));
        $this->createFolder($folder);
        $this->createFolder("{$folder}/{$y}");
        $this->createFolder("{$folder}/{$y}/{$m}");
        $this->destine = "{$folder}/{$y}/{$m}";
    }

    //Checks and creates the base directory.
    private function createFolder($folder): void
    {
        if (!file_exists(self::$baseDir . "/" . $folder) && !is_dir(self::$baseDir . "/" . $folder)) {
            mkdir(self::$baseDir . "/" . $folder);
        }
    }

    //Verifies and assembles the filenames by treating the string.
    private function setFileName(): void
    {
        $fileName = Prepare::slug($this->name) . strrchr($this->file['name'], '.');
        if (file_exists(self::$baseDir . "/{$this->destine}/{$fileName}")) {
            for ($i = 2; 1; $i++) {
                $fileName = Prepare::slug($this->name) . "-{$i}" . strrchr($this->file['name'], '.');
                if (!file_exists(self::$baseDir . "/{$this->destine}/{$fileName}")) {
                    break;
                }
            }
        }
        $this->name = $fileName;
    }

    //Upload images and resize them.
    private function createImage(): void
    {
        switch ($this->file['type']) {
            case 'image/jpg' :
            case 'image/jpeg' :
            case 'image/pjpeg' : $this->image = imagecreatefromjpeg($this->file['tmp_name']);
                break;
            case 'image/png' :
            case 'image/x-png' : $this->image = imagecreatefrompng($this->file['tmp_name']);
                break;
        }
        if (!$this->image) {
            $this->error = 'Invalid file type, only JPG or PNG are accepted.';
        } else {
            $x = imagesx($this->image);
            $y = imagesy($this->image);
            $imageWidth = $this->width < $x ? $this->width : $x;
            $imageHeight = $imageWidth * $y / $x;

            $newImage = imagecreatetruecolor($imageWidth, $imageHeight);
            imagealphablending($newImage, FALSE);
            imagesavealpha($newImage, TRUE);
            imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $imageWidth, $imageHeight, $x, $y);
            switch ($this->file['type']) {
                case 'image/jpg' :
                case 'image/jpeg' :
                case 'image/pjpeg' : imagejpeg($newImage, self::$baseDir . "/{$this->destine}/$this->name", 100);
                    break;
                case 'image/png' :
                case 'image/x-png' : imagepng($newImage, self::$baseDir . "/{$this->destine}/$this->name");
                    break;
            }

            if (!$newImage) {
                $this->error = 'Creating image error.';
            } else {
                $this->result = "{$this->destine}/{$this->name}";
            }
            imagedestroy($this->image);
            imagedestroy($newImage);
        }
    }

    //Send files and media
    private function moveFile(): void
    {
        if ($this->file['size'] > ($this->maxSize * 1024 * 1024)) {
            $this->error = "Maximum size allowed is {$this->maxSize}MB";
        } elseif (!in_array($this->file['type'], $this->allowed)) {
            $this->error = 'Invalid file type, only ' . implode(', ', $this->allowed) . ' are accepted.';
        } else {
            $this->checkFolder($this->folder);
            $this->setFileName();

            if (move_uploaded_file($this->file['tmp_name'], self::$baseDir . "/{$this->destine}/{$this->name}")) {
                $this->result = "{$this->destine}/{$this->name}";
            }else{
                $this->error = 'File upload error: Contact the developer.';
            }
        }
    }

}
