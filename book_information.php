<?php

$path = '/var/www/html/parser/author_image/b/237689/fb2/Martin_Pesn-lda-i-plameni-A-Song-of-Ice-and-Fire-_1_Igra-prestolov.EhlHEw.237689.fb2.zip';

if(!file_exists($path)):
    echo "$path - файл не существует \n";
    return;
endif;

function convert_format($path){
    $file = substr($path, 0 , strpos($path, '.'));
    if(is_dir("{$file}")) return $file; 
    $cmd = "ebook-convert {$path} {$file}";
    exec(escapeshellcmd($cmd), $output, $return_var);
    check_convert($output);
    return $file;
}

function check_convert($output){
    array_pop($output);
    if(empty($output)):
        echo "Конвертирование не удалось \n";
    else:
        echo "Файл удачно сохранен \n";
    endif;
}

function get_data_from_resource($path){
    $file = convert_format($path);
    $opf = 'content.opf';
    $package = simplexml_load_file($file . '/' . $opf);
    $data = [
        'title' => '', 
        'creator' => '', 
        'creator' => '', 
        'language' => '', 
        'date' => '', 
        'description' => '', 
        'publisher' => ''
    ];
    foreach($data as $key => $value){
        $data[$key] = (string) $package->metadata->children('dc', true)->$key;
    }
    print_r($data);
}

get_data_from_resource($path);