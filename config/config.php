<?php

// ------------------------------------------------------------------------------------------------------ //
//                                                captions                                                //
// ------------------------------------------------------------------------------------------------------ //

define('CAPTIONS', Array(
	'ru' => Array(
			'ROWS_LEFT' => Array(
				'1' => 'Название сервиса',
				'2' => 'Примечание'
			),
			'ROWS_RIGHT' => Array(
				'1' => '#user_id# #exit#',
				'2' => '#support#'
			)
	),
	'en' => Array(
			'ROWS_LEFT' => Array(
				'1' => 'Service name',
				'2' => 'Note'
			),
			'ROWS_RIGHT' => Array(
				'1' => '#user_id# #exit#',
				'2' => '#support#'
			)
	)
));

// ------------------------------------------------------------------------------------------------------ //
//                                                interface                                               //
// ------------------------------------------------------------------------------------------------------ //

define('INDIVIDUAL'            , 'blond'); // for all variants see the folder ./individual/
define('CABINET_MISSION'       , 'all'); // emoney, mfo, mlm, skinemsya, paycard, ident, mfo_BorrowPerson

// define('INDIVIDUAL'            , 'bropay'); 
// define('CABINET_MISSION'       , 'bropay' ); 

// define('INDIVIDUAL'            , 'mlm'); 
// define('CABINET_MISSION'       , 'mlm' ); 


define('ICON_TYPE'             , 'fa'); // image, fa, glyphicon

define('ID_OWNER'              , '221643000439444'); // needs for only CABINET_MISSION == 'mlm'
// define('ID_OWNER'              , ''); // needs for only CABINET_MISSION == 'mlm'

define('LANGUAGE_DEFAULT'      , 'ru'); // ru, en
define('LANGUAGE'      , 'ru');
define('PAGES_COUNT'           , 10); // 999999 / UNLIMITED_PAGES_VALUE - для скрытия страниц вообще

define('DEFAULT_PAGE'          , 'proc/main');

define('BALANCE_IN_MENU'       , false);
define('SHOW_LEFT_MENU'        , true);

// define('LOGO_STYLE'            , '');

// ------------------------------------------------------------------------------------------------------ //
//                                                dirs                                                    //
// ------------------------------------------------------------------------------------------------------ //

define('ROOT_DIR'              , __DIR__ . '/../App');
define('INCLUDES_DIR'          , ROOT_DIR . 'include/');
define('INCLUDES_PRIVATE_DIR'  , ROOT_DIR . 'include_private/');
define('LOG_DIR'               , '/logs/'); // !!!
define('LOG_FILE'              , 'retail');

define('MAIN_PATH'             , DIRECTORY_SEPARATOR);
define('PROC_PATH'             , MAIN_PATH . 'proc/');
define('INC_PATH'              , MAIN_PATH . 'include/');

// ------------------------------------------------------------------------------------------------------ //
//                                                graylog                                                 //
// ------------------------------------------------------------------------------------------------------ //
define('GELF_PARAMS'             , ['version' => '1.1', 'host' => 'replica-vm-alex', 'processing' => 'processing_dev', 'facility' => 'new_web',]);
define('GELF_URL'                , 'http://192.168.130.8:12201/gelf');
define('GELF_CMD_RES_MAX_SIZE'   , 20000);
define('GELF_CMD_RES_MAX_LENGTH' , 4000);
define('GELF_CMD_REQ_MAX_SIZE'   , 10000);
define('GELF_CMD_REQ_MAX_LENGTH' , 100);

// ------------------------------------------------------------------------------------------------------ //
//                                                processing                                              //
// ------------------------------------------------------------------------------------------------------ //

define('PROCESSING_URL'        , 'https://dkcp-dev.paypoint.pro/');
define('PROGRAM'               , '10022'); // 02001 без платежного пароля, 10022 с платежным паролем
define('PROGRAM_SKEYS'         , 'gameover_givepay_password');

define('DKCP_USER_LOGIN'       , 'dde611ty4s');
// define('DKCP_USER_LOGIN'       , 'ServiceMember');
// define('DKCP_USER_LOGIN'       , 'tester1');
// define('DKCP_USER_LOGIN'       , 'MFOshka');
define('DKCP_USER_PASSWORD'    , 'QWEdCVB67');
// define('DKCP_USER_PASSWORD'    , '123123');
define('DKCP_PATH_CERT'        , __DIR__ . '/../cert');
define('DKCP_CERT'             , DKCP_PATH_CERT . '/web.crt');
// define('DKCP_CERT'             , DKCP_PATH_CERT . '/mfo.crt');
// define('DKCP_CERT'             , DKCP_PATH_CERT . '/3.crt');
// define('DKCP_CERT'             , DKCP_PATH_CERT . '/test5.crt');
// define('DKCP_CERT'             , DKCP_PATH_CERT . '/mlm.crt');
define('DKCP_CERT_PASSWORD'    , 'QWEdCVB67');

define('PROTOCOL_VERSION'      , 'LAST');
define('USE_TOKEN'             , true);
define('TOKEN_LIFETIME'		   ,'1440');

// ------------------------------------------------------------------------------------------------------ //
//                                                tech                                                    //
// ------------------------------------------------------------------------------------------------------ //

define('DISPLAY_ERRORS'        , true);
define('ERROR_NO_REPORTING_VAL', [E_USER_DEPRECATED, E_DEPRECATED, E_NOTICE]); 
// define('ERROR_NO_REPORTING_VAL', [E_USER_DEPRECATED, E_DEPRECATED, E_NOTICE]); 

define('TIMEZONE'              , 'Europe/Moscow');

define('SESSION_DOMAIN'        , $_SERVER['SERVER_NAME']);
define('SESSION_COOKIE_NAME'   , 's_CORE' .  md5('CORE' . $_SERVER['SERVER_NAME']));


// if proxy
// cloudflare.com HTTP_CF_CONNECTING_IP
// or other HEADER NAME
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}

// ------------------------------------------------------------------------------------------------------ //
//                                                links, codes                                            //
// ------------------------------------------------------------------------------------------------------ //

define('URLS', Array(
	'MERCHANT_PROTOCOL'  => 'http://example.com/cooperation_shop.php',
	'MERCHANT_EXAMPLE'   => 'http://example.com/cooperation_shop.php#examples',
	'MERCHANT_PAYBUTTON' => 'https://pay-lab.paypoint.pro/proc/do/',
	'AUTOPAY_PROTOCOL'   => 'http://example.com/dev_autopay.php',
	'CORR_PASSPORT'      => 'https://my-a.paypoint.pro/proc/services/corr_info/',
	'INFO_PASSPORT'      => 'http://example.com/115.php',
	'MASSPAYMENT_INFO'   => 'http://web.example.com/dev_masspayment.html',
	'USER_REG'           => 'https://reg-a.paypoint.pro/',
	'COMPANY_REG'        => 'https://reg-a.paypoint.pro?usertype=2',
	'IMG_URL'            => '../../../img/forms/bankomat/'
));

define('PAYFORMS', Array(
	'BANK'          => '19748',
	'CARD'          => '19748',
	'RAPIDA_NAME'   => 'СУПЕРКАРТА',
	'RAPIDA_ACTIVE' => '15743',
	'RAPIDA_FILL'   => '15743'
));

define('TOP_MENU_ADV_BUTTONS', Array());

define('DEPOSIT_DOCUMENT_ADD_SUPPORT_CATEFORY', 123);

define('HANDLING_TYPE'         , '1'); // needs for only CABINET_MISSION == 'mlm'
define('HANDLING_TYPE_REPEAT'  , '1'); // needs for only CABINET_MISSION == 'mlm'

// вебкасса
define('SERVICE_URL'           , "https://$_SERVER[HTTP_HOST]/proc/fill/ps/show_result/");
define('URL_DECLINE'           , "https://$_SERVER[HTTP_HOST]/proc/fill/ps/show_result/");
define('URL_SUCCESS'           , "https://$_SERVER[HTTP_HOST]/proc/fill/ps/show_result/");
define('URL_CALLBACK'          , '');
define('FREE_PARAM'            , '');

define('CODES', Array(
	'INVEST_BALANCE_TYPE' => '650',
));

// в эти дни месяца запрещены эти команды
define('REJECT_DAYS', Array());

define('AUTOMATIC_EXT_TRANSACT', 'automatic!'); // если пусто, то ext_transact на pay может быть только уникальный

// доп. конфиг
$config_path = ROOT_DIR . 'adv_config.php';
if ( file_exists($config_path) ) {
    // require $config_path;
}

?>