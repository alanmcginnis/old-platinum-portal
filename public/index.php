<?php
// Set the document root to the parent directory
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

// Handle static files
$request_uri = $_SERVER['REQUEST_URI'];
$file_path = dirname(__DIR__) . $request_uri;

// If it's a file that exists, serve it directly
if (is_file($file_path) && substr($file_path, -4) !== '.php') {
    $mime_types = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
        'ico' => 'image/x-icon'
    ];
    
    $extension = pathinfo($file_path, PATHINFO_EXTENSION);
    if (isset($mime_types[$extension])) {
        header('Content-Type: ' . $mime_types[$extension]);
    }
    
    readfile($file_path);
    exit;
}

// For PHP files, include them
if (is_file($file_path) && substr($file_path, -4) === '.php') {
    include $file_path;
    exit;
}

// Default to index.html
if (is_file(dirname(__DIR__) . '/index.html')) {
    include dirname(__DIR__) . '/index.html';
    exit;
}

// 404 if nothing found
http_response_code(404);
echo '404 - File not found';
?>
