<?php return array (
  'barryvdh/laravel-dompdf' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
    ),
  ),
  'barryvdh/laravel-snappy' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Snappy\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\Snappy\\Facades\\SnappyPdf',
      'SnappyImage' => 'Barryvdh\\Snappy\\Facades\\SnappyImage',
    ),
  ),
  'beyondcode/laravel-websockets' => 
  array (
    'providers' => 
    array (
      0 => 'BeyondCode\\LaravelWebSockets\\WebSocketsServiceProvider',
    ),
    'aliases' => 
    array (
      'WebSocketRouter' => 'BeyondCode\\LaravelWebSockets\\Facades\\WebSocketRouter',
    ),
  ),
  'facade/ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'fruitcake/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'laravel/passport' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ),
  ),
  'laravel/socialite' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
    ),
    'aliases' => 
    array (
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravel/ui' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Ui\\UiServiceProvider',
    ),
  ),
  'lummy/laravel-vue-api-crud-generator' => 
  array (
    'providers' => 
    array (
      0 => 'lummy\\vueApi\\vueApiServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'simplesoftwareio/simple-qrcode' => 
  array (
    'providers' => 
    array (
      0 => 'SimpleSoftwareIO\\QrCode\\QrCodeServiceProvider',
    ),
    'aliases' => 
    array (
      'QrCode' => 'SimpleSoftwareIO\\QrCode\\Facades\\QrCode',
    ),
  ),
);