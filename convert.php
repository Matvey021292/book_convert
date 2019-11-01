<?php
header('Content-Type: text/html; charset=utf-8');

$path = '/var/www/html/parser/author_image/b/237689/fb2/Martin_Pesn-lda-i-plameni-A-Song-of-Ice-and-Fire-_1_Igra-prestolov.EhlHEw.237689.fb2.zip';

if(!file_exists($path)):
    echo "$path - файл не существует \n";
    return;
endif;

function explode_file($name, $format_convert){
    $formats = [
        '.fb2.zip','.epub', '.mobi', '.html'
    ];
    
    foreach($formats as $key => $format):
        if(strpos($name, $format)):
            $name = str_replace($format, '.' . $format_convert, $name);
        endif;
    endforeach;
    return $name;
}

function convert_format($path, $format){
    $file = explode_file($path, $format);
    if(file_exists("{$file}")):
        echo "Файл формата {$format} - уже существует \n";
        return;
    endif;
    $cmd = "ebook-convert {$path} {$file}";
    exec(escapeshellcmd($cmd), $output, $return_var);
    check_convert($output);
}

function check_convert($output){
    array_pop($output);
    if(empty($output)):
        echo "Конвертирование не удалось \n";
    else:
        echo "Файл удачно сохранен \n";
    endif;
}

convert_format($path, 'epub');
