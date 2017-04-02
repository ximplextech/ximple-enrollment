<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'EduSec',
	//'language' => 'gu',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
			'log',
			[
		        'class' => 'app\components\LanguageSelector',
		        'supportedLanguages' => ['en', 'gu', 'fr', 'hi', 'es', 'ar'],
		    ],
	],
    'components' => [
		'request' => [
			'cookieValidationKey' => 'JDqkJaMgIITAKcsJY6yvLQdM9jf7WghX',
		],
		'pdf'=>[
			'class'=>'app\components\ExportToPdf',
		],
		'excel'=>[
			'class'=>'app\components\ExportToExcel',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'getid'=>[
			'class'=>'app\components\GetUserId',
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'defaultRoles' => ['guest'],
		],
		'dateformatter'=>[
			'class'=>'app\components\DateFormat',
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => false,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'i18n' => [
		    'translations' => [
		        'app*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		            //'sourceLanguage' => 'en-US',
		            /*'fileMap' => [
		                'app' => 'app.php',
		                'app/error' => 'error.php',
		            ],*/
		        ],
		        'yii*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@yii/messages',
		        ],
		        'course*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		        'stu*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		        'emp*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		        'dash*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		        'fees*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		        'report*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		        'urights*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		            'basePath' => '@app/messages',
		        ],
		    ],
		],
		'formatter' => [
			'dateFormat' => 'dd-MM-yyyy',
			'datetimeFormat' => 'php:d-m-Y H:i:s',
			'timeFormat' => 'php:H:i:s',
			'decimalSeparator' => ',',
			'thousandSeparator' => ' ',
			'currencyCode' => 'USD',
			'class' => 'yii\i18n\Formatter',
		],
        	'db' => require(__DIR__ . '/db.php'),
    ],
	
	'as access' => [
		'class' => 'mdm\admin\components\AccessControl',
		'allowActions' => [
			'site/*',
			'installation/*',
		]
	],
    'params' => $params,
    'modules' => [
	'course' => 'app\modules\course\CourseModule',
	'student' => 'app\modules\student\StudentModule',
	'employee' => 'app\modules\employee\EmployeeModule',
	'fees' => 'app\modules\fees\FeesModule',
	'report' => 'app\modules\report\Report',
	'dashboard' => 'app\modules\dashboard\DashboardModule',
        'building' => [
            'class' => 'app\modules\building\BuildingModule',
        ],
        'room' => [
            'class' => 'app\modules\room\RoomModule',
        ],
        'semester' => [
            'class' => 'app\modules\semester\SemesterModule',
        ],
        'schoolyear' => [
            'class' => 'app\modules\schoolyear\SchoolyearModule',
        ],
        'subjects' => [
            'class' => 'app\modules\subjects\SubjectsModule',
        ],
        'classschedule' => [
            'class' => 'app\modules\classschedule\ClassScheduleModule',
        ],
	'rights' => [
        'class' => 'mdm\admin\Module',
	    'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'user_id', // id field of model User
		    'usernameField' => 'user_login_id', // username field of model User
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    //configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
	
	$config['components']['assetManager'] = [
		'linkAssets' => true,
	];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [ //here
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'backendCrud' => '@app/templates/crud/default', // template name => path to template
                ]
            ],
            'model' => [ // generator name
                'class' => 'yii\gii\generators\model\Generator', // generator class
                'templates' => [ //setting for out templates
                    'backendModel' => '@app/templates/model/default', // template name => path to template
                ]
            ],
            
        ],
    ];
}
//print_r($config); die();
return $config;
