<?php

use JetBrains\PhpStorm\NoReturn;

function show404(): void {
    header('HTTP/1.1 404 Not Found', true, 404);
    require './404.php';
    exit();
}

/**
 * Enlève les caractères spéciaux.
 *
 * @param string $string
 *
 * @return string
 */
function escape(string $string): string {
    global $linkConnectDB;
    return mysqli_real_escape_string($linkConnectDB, $string);
}

/**
 * Change le string voulu a un format SLUG.
 *
 * @param $str
 *
 * @return array|string|string[]|null
 */
function convert_name($str): array|string|null {
    $str = preg_replace("/[äàáạảãâầấậẩẫăằắặẳẵ]/iu", 'a', $str);
    $str = preg_replace("/[ëèéẹẻẽêềếệểễ]/iu", 'e', $str);
    $str = preg_replace("/[ïîìíịỉĩ]/iu", 'i', $str);
    $str = preg_replace("/[öòóọỏõôồốộổỗơờớợởỡ]/iu", 'o', $str);
    $str = preg_replace("/[ûüùúụủũưừứựửữ]/iu", 'u', $str);
    $str = preg_replace("/[ÿỳýỵỷỹ]/iu", 'y', $str);
    $str = preg_replace("/[đ]/iu", 'd', $str);
    $str = preg_replace("/[ÄÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/iu", 'A', $str);
    $str = preg_replace("/[ËÈÉẸẺẼÊỀẾỆỂỄ]/iu", 'E', $str);
    $str = preg_replace("/[ÏÌÍỊỈĨ]/iu", 'I', $str);
    $str = preg_replace("/[ÖÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/iu", 'O', $str);
    $str = preg_replace("/[ÜÛÙÚỤỦŨƯỪỨỰỬỮ]/iu", 'U', $str);
    $str = preg_replace("/[ỲÝỴỶỸ]/iu", 'Y', $str);
    $str = preg_replace("/[Đ]/iu", 'D', $str);
    $str = preg_replace("/[\“\”\‘\’\,\!\&\;\@\#\%\~\`\=\_\'\]\[\}\{\)\(\+\^]/", '-', $str);
    return preg_replace("/( )/", '-', $str);
}

/**
 * Génère un lien SLUG.
 *
 * @param $str
 * @return array|string
 */
function slug($str): array|string {
    $str = convert_name($str);
    $str = strtolower($str);
    return str_replace(" ", "-", $str);
}

function upload($field, $config = []) {
    $options = array('name' => '', 'upload_path' => './', 'allowed_exts' => '*', 'overwrite' => true, 'max_size' => 0);
    $options = array_merge($options, $config);

    if (!isset($_FILES[$field])) return false;
    $file = $_FILES[$field];
    if ($file['error'] != 0) return false;

    $temp = explode('.', $file['name']);

    $ext = end($temp); // Met le pointeur de l'array a son dernier element

    if ($options['allowed_exts'] != '*') {
        $allowedExts = explode('|', $options['allowed_exts']);
        if (!in_array($ext, $allowedExts)) return false;
    }

    $size = $file['size'] / 1024 / 1024;
    if (($options['max_size'] > 0) && ($size > $options['max_size'])) return false;

    $name = empty($options['name']) ? $file['name'] : $options['name'] . '.' . $ext;
    $file_path = $options['upload_path'] . $name;

    if ($options['overwrite'] && file_exists($file_path)) unlink($file_path);

    move_uploaded_file($file['tmp_name'], $file_path);

    return $name;
}

/**
 * Si l'utilisateur n'est pas admin, l'envoyer sur la page d'acceuil.
 *
 * @return void
 * @throws Exception
 */
function permission_user(): void {
    global $userNav;
    $userLogin = getById($userNav, 'users');
    if ($userLogin['role_id'] == 0) {
        header('location:index.php');
        exit;
    }
}

/**
 * Si l'utilisateur est admin, l'envoyer sur la page admin.
 *
 * @return void
 * @throws Exception
 */
function permission_admin(): void {
    global $userNav;
    $userLogin = getById($userNav, 'users');
    if ($userLogin['role_id'] == 2) {
        header('location:admin.php');
        exit;
    }
}

/**
 * Fonction de débugage PHP courante.
 *
 * @return void
 */
#[NoReturn] function dd(): void {
    echo '<pre>';
    foreach (func_get_args() as $arg) {
        var_dump($arg);
    }
    die;
}