<?php
define('APP_ROOT', dirname(__FILE__, 2));

define("DB_HOST", $_ENV['DB_HOST'] ?? 'localhost');
define("DB_PORT", $_ENV['DB_PORT'] ?? '3306');
define("DB_USER", $_ENV['DB_USER'] ?? 'root');
define("DB_PASS", $_ENV['DB_PASS'] ?? 'root');
define("DB_NAME", $_ENV['DB_NAME'] ?? 'checkride');

const URLROOT = 'http://localhost/checkride';
const SITENAME = 'checkride';
const APP_URL = 'gs-checkride.com';

const TASK_NOT_CREATED = 'Something went wrong creating new task';
const TASK_NOT_UPDATED = 'Task updated successfully';
const TASK_NOT_DELETED = 'Something went wrong deleting task';