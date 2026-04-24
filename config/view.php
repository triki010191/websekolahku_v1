<?php

return [

    'paths' => [
        resource_path('views'),
    ],

    /*
    | Path file Blade hasil kompilasi. Wajib string path yang valid; hindari
    | realpath() di default (bisa false jika folder belum ada saat config load)
    | — dapat memicu error tempnam() saat menulis di XAMPP/Apache.
    */
    'compiled' => env('VIEW_COMPILED_PATH', storage_path('framework/views')),

];
