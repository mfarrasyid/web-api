<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'v5';
$query_builder = TRUE;

$db['v5'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost:6033',
	'username' => 'root',
	'password' => '',
	'database' => 'web-app-stater-kit-master',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
