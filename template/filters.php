<?php


function filterString($field) {

    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);

    if(empty($field)) {

        return false;

    } else {

        return $field;

    }

}


function filterEmail($field) {
    
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    
    if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
        
        return $field;

    } else {

        return false;

    }

}

function canUpload($file) {

    $allowedFiles = [

        'pdf' => 'application/pdf'

    ];

    if(!in_array(mime_content_type($file['tmp_name']), $allowedFiles)) {

        return 'File type is not allowed';

    }

    $fileMaxSize = 50000 * 1024;

    if($file['size'] > $fileMaxSize) {

        return 'File size is not allowed, max allowed size: ' . $fileMaxSize;

    }

    return true;

}
