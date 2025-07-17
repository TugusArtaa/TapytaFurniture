<?php

class Route
{
    // Array untuk menyimpan daftar URI yang terdaftar
    private static $uriList = array();
    // Array untuk menyimpan fungsi callback yang terkait dengan setiap URI
    private static $uriCallback = array();

    // Metode untuk menambahkan URI dan fungsi callback ke dalam daftar
    static public function add($uri, $function)
    {
        self::$uriList[] = $uri;
        self::$uriCallback[$uri] = $function;
    }

    // Metode untuk mengecek URI yang sesuai dan memanggil fungsi callback yang bersesuaian
    static public function submit()
    {
        // Mendapatkan URI dari permintaan saat ini
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        // Variabel untuk memeriksa kecocokan URI
        $doesUriMatch = false;

        // Loop melalui daftar URI yang terdaftar
        foreach (self::$uriList as $u) {
            if ($u == $uri) {
                $doesUriMatch = true;
                break;
            }
        }

        // Jika URI cocok, panggil fungsi callback yang bersesuaian
        if ($doesUriMatch) {
            call_user_func(self::$uriCallback[$uri]);
        } else {
            // Jika URI tidak cocok, kirim respons kode 404 dan tampilkan halaman 404
            http_response_code(404);
            require __DIR__ . '/views/404.php';
        }
    }
}