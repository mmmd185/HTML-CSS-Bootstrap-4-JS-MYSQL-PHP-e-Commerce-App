<?php

class Upload {


    protected $uploadDir;
    protected $defaultUploadDir = 'uploads/products';
    public $file;
    public $fileName;
    public $filePath;
    protected $rootDir;
    protected $errors = [];


    public function __construct($uploadDir, $rootDir = false)
    {

        if($rootDir) {

            $this->rootDir = $rootDir;
        
        } else {

            $this->rootDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'uploads/products';
        }

        $this->filePath = $uploadDir;
        $this->uploadDir = $this->rootDir . '/' . $uploadDir;

    }


    protected function createUploadDir() {

        if(!is_dir($this->uploadDir)) {

            umask(0);

            if(!mkdir($this->uploadDir, 0775)) {

                array_push($this->errors, 'Could not create upload dir');
                return false;

            }

        }

        return true;

    }


    public function upload(){

        $this->fileName = time().$this->file['name'];
        $this->filePath .= '/'.$this->fileName;
    
        if($this->validate()){

            return $this->errors;

        } else if(!$this->createUploadDir()){

            return $this->errors;

        } else if(!move_uploaded_file($this->file['tmp_name'], $this->uploadDir.'/'.$this->fileName)){

            array_push($this->errors, 'Error uploading your file');

        }

        return $this->errors;

    }



    protected function validate(){


        if(!$this->isMimeAllowed()){ 

            array_push($this->errors, 'File Type not allowed');

        } else if (!$this->isSizeAllowed()) {

            array_push($this->errors, 'File size not allowed');

        } 

        return $this->errors;

    }


    protected function isMimeAllowed() {


        $allowedFiles = [

            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg'    
        ];

        $fileMime = mime_content_type($this->file['tmp_name']);
    
        if(!in_array($fileMime, $allowedFiles)) {
    
            return false;
    
        }

        return true;

    }



    protected function isSizeAllowed() {


        $fileMaxSize = 50000 * 1024;

        if($this->file['size'] > $fileMaxSize) {
    
            return false;

        }
    
        return true;

    }


}