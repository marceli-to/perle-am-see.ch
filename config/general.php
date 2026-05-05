<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */
use craft\helpers\App;
$isDev = App::env('ENVIRONMENT') === 'dev';
$isProd = App::env('ENVIRONMENT') === 'production';

return [
    // Global settings
    '*' => [
        // Default Week Start Day (0 = Sunday, 1 = Monday...)
        'defaultWeekStartDay' => 1,

        // Whether generated URLs should omit "index.php"
        'omitScriptNameInUrls' => true,

        // Control Panel trigger word
        'cpTrigger' => 'adm',

        // The secure key Craft will use for hashing and encrypting data
        'securityKey' => getenv('SECURITY_KEY'),

        // nexocom Defaults
        'timezone' => 'Europe/Zurich',
        'limitAutoSlugsToAscii' => true,
        'convertFilenamesToAscii' => true,
        'sendPoweredByHeader' => false,
        'testToEmailAddress' => $isDev ? 'info@nexocom.ch' : null,
        'defaultTemplateExtensions' => ['html', 'twig', 'njk'],
        'csrfTokenName' => 'CSRF_TOKEN',
        'phpSessionName' => 'SessionIdWeb',
		'generateTransformsBeforePageLoad' => false,
    ],

    // Dev environment settings
    'dev' => [
        // Dev Mode (see https://craftcms.com/guides/what-dev-mode-does)
        'devMode' => true,
		'maxRevisions' => 1,
    ],

    // Staging environment settings
    'staging' => [
        // Set this to `false` to prevent administrative changes from being made on staging
        'allowAdminChanges' => false,
    ],

    // Production environment settings
    'production' => [
        // Set this to `false` to prevent administrative changes from being made on production
        'allowAdminChanges' => true,
      	'allowUpdates' => false,
    ],
];
