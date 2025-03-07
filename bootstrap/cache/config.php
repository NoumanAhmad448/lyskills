<?php return array (
  'app' => 
  array (
    'name' => 'lyskills',
    'env' => 'dev',
    'dev_env' => 'dev',
    'testing_env' => 'testing',
    'live_env' => 'production',
    'email' => 'testing.lyskillls@lyskills.com',
    'debug' => false,
    'url' => 'http://localhost',
    'js_debug' => 'http://localhost',
    'asset_url' => NULL,
    'timezone' => 'Asia/Karachi',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:6O7neizvTL+onlOmKBvbkOWwz+0YVwbAhubYxEL4qKY=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
      1 => 'Intervention\\Image\\ImageServiceProvider',
      2 => 'Illuminate\\Auth\\AuthServiceProvider',
      3 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      4 => 'Illuminate\\Bus\\BusServiceProvider',
      5 => 'Illuminate\\Cache\\CacheServiceProvider',
      6 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      7 => 'Illuminate\\Cookie\\CookieServiceProvider',
      8 => 'Illuminate\\Database\\DatabaseServiceProvider',
      9 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      10 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      11 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      12 => 'Illuminate\\Hashing\\HashServiceProvider',
      13 => 'Illuminate\\Mail\\MailServiceProvider',
      14 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      15 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      20 => 'Illuminate\\Session\\SessionServiceProvider',
      21 => 'Illuminate\\Translation\\TranslationServiceProvider',
      22 => 'Illuminate\\Validation\\ValidationServiceProvider',
      23 => 'Illuminate\\View\\ViewServiceProvider',
      24 => 'App\\Providers\\AppServiceProvider',
      25 => 'App\\Providers\\AuthServiceProvider',
      26 => 'App\\Providers\\EventServiceProvider',
      27 => 'App\\Providers\\RouteServiceProvider',
      28 => 'App\\Providers\\FortifyServiceProvider',
      29 => 'App\\Providers\\JetstreamServiceProvider',
      30 => 'Cocur\\Slugify\\Bridge\\Laravel\\SlugifyServiceProvider',
      31 => 'Anhskohbo\\NoCaptcha\\NoCaptchaServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'Image' => 'Intervention\\Image\\Facades\\Image',
      'NoCaptcha' => 'Anhskohbo\\NoCaptcha\\Facades\\NoCaptcha',
      'Slugify' => 'Cocur\\Slugify\\Bridge\\Laravel\\SlugifyFacade',
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
    ),
    'google_captcha_key' => '6LdLRZoaAAAAAHyIWTIk5usnFgVUZzx4CKXiZGvm',
    'google_captcha_secret' => '6LdLRZoaAAAAAJA5O2ra78tWYhr8KNQCzSwvwwOx',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'useTLS' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'B:\\lyskills\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => 'AKIA2UC27DZFJ5MSS563',
        'secret' => '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',
        'region' => 'ap-south-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'lyskills_cache',
  ),
  'constants' => 
  array (
    'error' => 'error',
    'successed' => 'successed',
    'idle' => 'idle',
    'active_users' => 'Active Users ',
    'Admins' => 'Admins ',
    'Users' => 'Users ',
    'Lands' => 'Lands ',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'actions' => 'migration_actions',
    'default' => 'mysql',
    'current_db' => 'usmansaleem234_lyskills_new',
    'testing_db' => 'usmansaleem234_lyskills_new_testing',
    'laravel_db' => 'usmansaleem234_laravel',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'usmansaleem234_lyskills_new',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'usmansaleem234_lyskills_new',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'usmansaleem234_lyskills_new',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'usmansaleem234_lyskills_new',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'lyskills_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'public_path' => NULL,
    'convert_entities' => true,
    'options' => 
    array (
      'font_dir' => 'B:\\lyskills\\storage\\fonts',
      'font_cache' => 'B:\\lyskills\\storage\\fonts',
      'temp_dir' => 'C:\\Users\\eren\\AppData\\Local\\Temp',
      'chroot' => 'B:\\lyskills',
      'allowed_protocols' => 
      array (
        'file://' => 
        array (
          'rules' => 
          array (
          ),
        ),
        'http://' => 
        array (
          'rules' => 
          array (
          ),
        ),
        'https://' => 
        array (
          'rules' => 
          array (
          ),
        ),
      ),
      'log_output_file' => NULL,
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_paper_orientation' => 'portrait',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => true,
    ),
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => 'B:\\lyskills\\storage\\fonts/',
      'font_cache' => 'B:\\lyskills\\storage\\fonts/',
      'temp_dir' => 'C:\\Users\\eren\\AppData\\Local\\Temp',
      'chroot' => 'B:\\lyskills',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'files' => 
  array (
    'components' => 'components',
    'components_' => 'components.',
    'partials' => 'partials',
    'partials_' => 'partials.',
    'svg' => 'components.svg.',
    'middlewares' => 'middlewares.',
    'lib' => 'lib.',
    'forms' => 'components.forms.',
    'cls' => 'cls.',
  ),
  'filesystems' => 
  array (
    'default' => 's3',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'B:\\lyskills\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'B:\\lyskills\\storage\\app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => 'AKIA2UC27DZFJ5MSS563',
        'secret' => '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',
        'region' => 'ap-south-1',
        'bucket' => 'lyskills-by-us-yes-that-us',
        'visibility' => NULL,
        'url' => 'https://lyskills-by-us-yes-that-us.s3.ap-south-1.amazonaws.com',
        'endpoint' => '',
        'scheme' => 'http',
      ),
    ),
    'links' => 
    array (
      'B:\\lyskills\\public\\storage' => 'B:\\lyskills\\storage\\app/public',
    ),
  ),
  'fortify-options' => 
  array (
    'two-factor-authentication' => 
    array (
      'confirmPassword' => true,
    ),
  ),
  'fortify' => 
  array (
    'guard' => 'web',
    'middleware' => 
    array (
      0 => 'web',
    ),
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => true,
    'home' => '/',
    'prefix' => '',
    'domain' => NULL,
    'lowercase_usernames' => false,
    'limiters' => 
    array (
      'login' => NULL,
    ),
    'paths' => 
    array (
      'login' => NULL,
      'logout' => NULL,
      'password' => 
      array (
        'request' => NULL,
        'reset' => NULL,
        'email' => NULL,
        'update' => NULL,
        'confirm' => NULL,
        'confirmation' => NULL,
      ),
      'register' => NULL,
      'verification' => 
      array (
        'notice' => NULL,
        'verify' => NULL,
        'send' => NULL,
      ),
      'user-profile-information' => 
      array (
        'update' => NULL,
      ),
      'user-password' => 
      array (
        'update' => NULL,
      ),
      'two-factor' => 
      array (
        'login' => NULL,
        'enable' => NULL,
        'confirm' => NULL,
        'disable' => NULL,
        'qr-code' => NULL,
        'secret-key' => NULL,
        'recovery-codes' => NULL,
      ),
    ),
    'redirects' => 
    array (
      'login' => NULL,
      'logout' => NULL,
      'password-confirmation' => NULL,
      'register' => NULL,
      'email-verification' => NULL,
      'password-reset' => NULL,
    ),
    'features' => 
    array (
      0 => 'registration',
      1 => 'reset-passwords',
      2 => 'email-verification',
      3 => 'update-profile-information',
      4 => 'update-passwords',
      5 => 'two-factor-authentication',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'health' => 
  array (
    'result_stores' => 
    array (
      'Spatie\\Health\\ResultStores\\EloquentHealthResultStore' => 
      array (
        'connection' => 'mysql',
        'model' => 'Spatie\\Health\\Models\\HealthCheckResultHistoryItem',
        'keep_history_for_days' => 5,
      ),
      'Spatie\\Health\\ResultStores\\CacheHealthResultStore' => 
      array (
        'store' => 'file',
      ),
    ),
    'notifications' => 
    array (
      'enabled' => true,
      'notifications' => 
      array (
        'Spatie\\Health\\Notifications\\CheckFailedNotification' => 
        array (
          0 => 'slack',
        ),
      ),
      'notifiable' => 'Spatie\\Health\\Notifications\\Notifiable',
      'throttle_notifications_for_minutes' => 60,
      'throttle_notifications_key' => 'health:latestNotificationSentAt:',
      'mail' => 
      array (
        'to' => 'your@example.com',
        'from' => 
        array (
          'address' => 'testing.lyskillls@lyskills.com',
          'name' => 'lyskills',
        ),
      ),
      'slack' => 
      array (
        'webhook_url' => 'https://hooks.slack.com/services/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',
        'channel' => 'web-development',
        'username' => 'urooman',
        'icon' => NULL,
      ),
    ),
    'oh_dear_endpoint' => 
    array (
      'enabled' => false,
      'always_send_fresh_results' => true,
      'secret' => NULL,
      'url' => '/oh-dear-health-check-results',
    ),
    'horizon' => 
    array (
      'heartbeat_url' => NULL,
    ),
    'schedule' => 
    array (
      'heartbeat_url' => NULL,
    ),
    'theme' => 'dark',
    'silence_health_queue_job' => true,
    'json_results_failure_status' => 200,
  ),
  'jetstream' => 
  array (
    'stack' => 'livewire',
    'features' => 
    array (
    ),
  ),
  'logging' => 
  array (
    'default' => 'daily',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'B:\\lyskills\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'B:\\lyskills\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'B:\\lyskills\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'contact_us_email' => NULL,
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'server1.lyskills.com',
        'port' => '587',
        'encryption' => 'tls',
        'username' => 'testing.lyskillls@lyskills.com',
        'password' => 'Vp=5&DOxM;Wj',
        'timeout' => NULL,
        'auth_mode' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
    ),
    'from' => 
    array (
      'address' => 'testing.lyskillls@lyskills.com',
      'name' => 'lyskills',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'B:\\lyskills\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'paypal' => 
  array (
    'client_id' => 'AXbkD4sjcsh8B4UHg-RK9YlWEkMU5BA_uijeHKXTqabhHL4ygBOYLIPns28c2scKRoBpV-HviMNEIVIq',
    'secret' => 'ELAXDqXafM-_zzW57beawqtmgmPacumVPu5mKu3JIhTfpWnq9xjapdcAm8mksz-VxrcrjNJpe70q_-Fl',
    'settings' => 
    array (
      'mode' => 'live',
      'http.ConnectionTimeOut' => 30,
      'log.LogEnabled' => true,
      'log.FileName' => 'B:\\lyskills\\storage/logs/paypal.log',
      'log.LogLevel' => 'ERROR',
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'AKIA2UC27DZFJ5MSS563',
        'secret' => '0x7kQ36zNGQ5QI+m6PjqQ93d6ghKKCwi5jJjsGin',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'suffix' => NULL,
        'region' => 'ap-south-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => '127.0.0.1',
      2 => '127.0.0.1:8000',
      3 => '::1',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'middleware' => 
    array (
      'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
      'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
    ),
  ),
  'services' => 
  array (
    'google' => 
    array (
      'client_id' => '951762114669-f3i0iv95cbg3rfpgucbn7hrm0ur9pdaq.apps.googleusercontent.com',
      'client_secret' => 'VM4qISOIzRpBETtf6ZmIu3QA',
      'redirect' => 'https://lyskills.com/google/callback',
    ),
    'facebook' => 
    array (
      'client_id' => '173700187810965',
      'client_secret' => 'f5a7bbbd7ac65506a0abdc2c0db4c3db',
      'redirect' => 'https://lyskills.com/facebook/callback',
    ),
    'linkedin' => 
    array (
      'client_id' => '86749emnjpqo7c',
      'client_secret' => 'ekzKnpmANI4VISAW',
      'redirect' => 'https://lyskills.com/linkedin/callback',
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => '525600',
    'expire_on_close' => true,
    'encrypt' => false,
    'files' => 'B:\\lyskills\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'lyskills_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'setting' => 
  array (
    'http' => 'http',
    'roles' => 
    array (
      'admin' => 'admin',
      'instructor' => 'instructor',
      'super_admin' => 'super_admin',
      'dev' => 'dev',
      'user' => 'user',
    ),
    's3Url' => 'http://lyskills-by-us-yes-that-us.s3.ap-south-1.amazonaws.com/',
    'no_reply_email_pass' => '30vx5Ga{f,XJ30vx5Ga{f,XJ30vx5Ga{f,XJ30vx5Ga{f,XJ',
    'max_tble_size' => 90000000,
    'retry_time' => 5,
    'show_site_log' => true,
    'login_profile' => true,
    'guest_search_bar' => true,
    'category_menu' => true,
    'homepage_image' => true,
    'show_courses_main_page' => true,
    'main_courses_heading' => false,
    'all_categories' => true,
    'all_posts' => true,
    'all_faqs' => true,
    'aos_js' => false,
    'aos_css' => false,
    'guest_footer' => true,
    'guest_header' => true,
    'show_courses_on_category' => true,
    'guest_blade' => 'layouts.guest',
    'welcome_blade' => 'welcome',
    'show_blade' => 'category.show',
    'user_notification' => true,
    'course_banner' => true,
    'show_course_blade' => 'course.show-course',
    'course_nav' => true,
    'course_enrollment_count' => true,
    'course_desc_wishlist_btn' => true,
    'course_desc_share_btn' => true,
    'course_desc_gift_btn' => false,
    'show_course_video' => true,
    'show_hide_coupon' => true,
    'show_hide_course_content' => true,
    'show_hide_course_desc' => true,
    'dir_path' => 'storage/img',
    'show_errors_label' => 'show_errors',
    'db_helper' => 'usmansaleem234_laravel.',
    'err_msg' => 'Something went wrong',
    'logout_msg' => 'You are logged out',
    'enable_course_unenroll' => true,
    'admin_guest_search_bar' => true,
    'admin_email' => 'anime@bypass.com',
    'coupon_form' => true,
    'store_img_s3' => true,
    'set_time_limit' => 60000,
    'upload_max_filesize' => '2000M',
    'memory_limit' => '8096M',
    'base_env' => NULL,
    'env_files' => 
    array (
      0 => '.env',
      1 => '.env.dev',
      2 => '.env.live.example',
      3 => '.env.dev.example',
    ),
    'en_showing_vid_val' => false,
  ),
  'table' => 
  array (
    'map' => 'map',
    'message' => 'message',
    'status' => 'status',
    'w_name' => 'w_name',
    'ends_at' => 'ends_at',
    'starts_at' => 'starts_at',
    'cron_jobs' => 'cron_jobs',
    'uuid' => 'uuid',
    'land_logs' => 'land_logs',
    'land_id' => 'land_id',
    'permissions' => 'permissions',
    'roles' => 'roles',
    'jobs' => 'jobs',
    'job_id' => 'job_id',
    'user_profiles' => 'user_profiles',
    'mobile' => 'mobile',
    'age' => 'age',
    'gender' => 'gender',
    'address' => 'address',
    'deleted_at' => 'deleted_at',
    'password' => 'password',
    'name' => 'name',
    'lands_ids' => 'lands_ids',
    'land_ops_id' => 'land_ops_id',
    'countries' => 'countries',
    'cities' => 'cities',
    'states' => 'states',
    'land_create' => 'land_create',
    'land_create_logs' => 'land_create_logs',
    'land_files' => 'land_files',
    'land_create_id' => 'land_create_id',
    'f_name' => 'f_name',
    'f_mimetype' => 'f_mimetype',
    'is_admin_approved' => 'is_admin_approved',
    'created_at' => 'created_at',
    'comment' => 'comment',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'city' => 'city',
    'size' => 'size',
    'location' => 'location',
    'description' => 'description',
    'title' => 'title',
    'is_active' => 'is_active',
    'user' => 'user',
    'users' => 'users',
    'link' => 'link',
    'user_id' => 'user_id',
    'is_super_admin' => 'is_super_admin',
    'is_admin' => 'is_admin',
    'primary_key' => 'id',
    'lands' => 'lands',
    'land_comments' => 'land_comments',
    'land_comments_logs' => 'land_comments_logs',
    'SubmitButton' => 'Submit',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'B:\\lyskills\\resources\\views',
    ),
    'compiled' => 'B:\\lyskills\\storage\\framework\\views',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'cashier' => 
  array (
    'key' => 'pk_live_51HgB5sKqvwo7IBqOHR7UDYA4BTeqzl8rW7jNrTviy8ZQBQomKMmscf0AmAjcOzLQoAkrJebIuoAPl7qHQO2twwGH00TGvUjKte',
    'secret' => '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',
    'path' => 'stripe',
    'webhook' => 
    array (
      'secret' => NULL,
      'tolerance' => 300,
    ),
    'model' => 'App\\Models\\User',
    'currency' => 'usd',
    'currency_locale' => 'en',
    'payment_notification' => NULL,
    'invoices' => 
    array (
      'renderer' => 'Laravel\\Cashier\\Invoices\\DompdfInvoiceRenderer',
      'options' => 
      array (
        'paper' => 'letter',
      ),
    ),
    'logger' => 'stack',
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Http\\Livewire',
    'view_path' => 'B:\\lyskills\\resources\\views/livewire',
    'layout' => 'layouts.app',
    'asset_url' => NULL,
    'app_url' => NULL,
    'middleware_group' => 'web',
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
    ),
    'manifest_path' => NULL,
    'back_button_cache' => false,
    'render_on_redirect' => false,
  ),
  'flare' => 
  array (
    'key' => NULL,
    'flare_middleware' => 
    array (
      0 => 'Spatie\\FlareClient\\FlareMiddleware\\RemoveRequestIp',
      1 => 'Spatie\\FlareClient\\FlareMiddleware\\AddGitInformation',
      2 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddNotifierName',
      3 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddEnvironmentInformation',
      4 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionInformation',
      5 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddDumps',
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddLogs' => 
      array (
        'maximum_number_of_collected_logs' => 200,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddQueries' => 
      array (
        'maximum_number_of_collected_queries' => 200,
        'report_query_bindings' => true,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddJobs' => 
      array (
        'max_chained_job_reporting_depth' => 5,
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestBodyFields' => 
      array (
        'censor_fields' => 
        array (
          0 => 'password',
          1 => 'password_confirmation',
        ),
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestHeaders' => 
      array (
        'headers' => 
        array (
          0 => 'API-KEY',
        ),
      ),
    ),
    'send_logs_as_events' => true,
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'auto',
    'enable_share_button' => true,
    'register_commands' => false,
    'solution_providers' => 
    array (
      0 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\BadMethodCallSolutionProvider',
      1 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\MergeConflictSolutionProvider',
      2 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\UndefinedPropertySolutionProvider',
      3 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\IncorrectValetDbCredentialsSolutionProvider',
      4 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingAppKeySolutionProvider',
      5 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\DefaultDbNameSolutionProvider',
      6 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\TableNotFoundSolutionProvider',
      7 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingImportSolutionProvider',
      8 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\InvalidRouteActionSolutionProvider',
      9 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\ViewNotFoundSolutionProvider',
      10 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\RunningLaravelDuskInProductionProvider',
      11 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingColumnSolutionProvider',
      12 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownValidationSolutionProvider',
      13 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingMixManifestSolutionProvider',
      14 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingViteManifestSolutionProvider',
      15 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingLivewireComponentSolutionProvider',
      16 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UndefinedViewVariableSolutionProvider',
      17 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\GenericLaravelExceptionSolutionProvider',
    ),
    'ignored_solution_providers' => 
    array (
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => 'B:\\lyskills',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
    'settings_file_path' => '',
    'recorders' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\Recorders\\DumpRecorder\\DumpRecorder',
      1 => 'Spatie\\LaravelIgnition\\Recorders\\JobRecorder\\JobRecorder',
      2 => 'Spatie\\LaravelIgnition\\Recorders\\LogRecorder\\LogRecorder',
      3 => 'Spatie\\LaravelIgnition\\Recorders\\QueryRecorder\\QueryRecorder',
    ),
  ),
  'captcha' => 
  array (
    'secret' => '6LdLRZoaAAAAAJA5O2ra78tWYhr8KNQCzSwvwwOx',
    'sitekey' => '6LdLRZoaAAAAAHyIWTIk5usnFgVUZzx4CKXiZGvm',
    'options' => 
    array (
      'timeout' => 30,
    ),
  ),
  'horizon' => 
  array (
    'silenced' => 
    array (
      0 => 'Spatie\\Health\\Jobs\\HealthQueueJob',
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
