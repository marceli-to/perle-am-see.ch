<?php
/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app.php and app.[web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 *
 * If you want to modify the application config for *only* web requests or
 * *only* console requests, create an app.web.php or app.console.php file in
 * your config/ folder, alongside this one.
 */

/* For mailpit / mailerconfig change:
https://github.com/craftcms/cms/blob/3.x/src/config/app.php
https://github.com/craftcms/cms/blob/5.x/src/helpers/App.php#L975
*/
return [
    'modules' => [
        'my-module' => \modules\Module::class,
    ],
    'components' => [
        'mailer' => function() {
            $config = craft\helpers\App::mailerConfig();

            // Use Mailpit in dev mode:
            if (Craft::$app->getConfig()->getGeneral()->devMode) {
                $adapter = craft\helpers\MailerHelper::createTransportAdapter(
                    craft\mail\transportadapters\Sendmail::class,
                    [
                        'command' => ini_get('sendmail_path'),
                    ]
                );

                // Override the transport:
                $config['transport'] = $adapter->defineTransport();
            }

            // Return the initialized component:
            return Craft::createObject($config);
        },
    ],
];
