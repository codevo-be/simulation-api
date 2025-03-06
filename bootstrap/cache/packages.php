<?php return array (
  'barryvdh/laravel-dompdf' => 
  array (
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
      'Pdf' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
    ),
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
  ),
  'laravel/passport' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
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
  'nunomaduro/termwind' => 
  array (
    'providers' => 
    array (
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ),
  ),
  'revolution/laravel-google-sheets' => 
  array (
    'providers' => 
    array (
      0 => 'Revolution\\Google\\Sheets\\Providers\\SheetsServiceProvider',
      1 => 'Revolution\\Google\\Client\\Providers\\GoogleServiceProvider',
    ),
    'google/apiclient-services' => 
    array (
      0 => 'Drive',
      1 => 'Sheets',
    ),
  ),
  'stancl/tenancy' => 
  array (
    'aliases' => 
    array (
      'Tenancy' => 'Stancl\\Tenancy\\Facades\\Tenancy',
      'GlobalCache' => 'Stancl\\Tenancy\\Facades\\GlobalCache',
    ),
    'providers' => 
    array (
      0 => 'Stancl\\Tenancy\\TenancyServiceProvider',
    ),
  ),
);