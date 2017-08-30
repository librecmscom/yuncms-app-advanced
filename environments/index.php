<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'skipFiles'  => [
 *             // list of files that should only copied once and skipped if they already exist
 *         ],
 *         'setWritable' => [
 *             // list of directories that should be set writable
 *         ],
 *         'setExecutable' => [
 *             // list of files that should be set executable
 *         ],
 *         'setCookieValidationKey' => [
 *             // list of config files that need to be inserted with automatically generated cookie validation keys
 *         ],
 *         'createSymlink' => [
 *             // list of symlinks to be created. Keys are symlinks, and values are the targets.
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Development' => [
        'path' => 'dev',
        'setNginxConf' => [
            'nginx.conf',
        ],
        'setWritable' => [
            'api/runtime',
            'backend/runtime',
            'backend/web/assets',
            'frontend/runtime',
            'frontend/web/assets',
        ],
        'setExecutable' => [
            'yii',
            'yii_test',
        ],
        'setCookieValidationKey' => [
            'api/config/main-local.php',
            'backend/config/main-local.php',
            'frontend/config/main-local.php',
        ],
//        'createSymlink' => [
//            'frontend/web/uploads' => 'uploads',
//            'backend/web/uploads' => 'uploads',
//            'api/web/uploads' => 'uploads',
//        ],
    ],
    'Production' => [
        'path' => 'prod',
        'setNginxConf' => [
            'nginx.conf',
        ],
        'setWritable' => [
            'backend/runtime',
            'backend/web/assets',
            'frontend/runtime',
            'frontend/web/assets',
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'api/config/main-local.php',
            'backend/config/main-local.php',
            'frontend/config/main-local.php',
        ],
//        'createSymlink' => [
//            'frontend/web/uploads' => 'uploads',
//            'backend/web/uploads' => 'uploads',
//            'api/web/uploads' => 'uploads',
//        ],
    ],
];
