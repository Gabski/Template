<?php
require_once 'Template.php';

$tpl = new Template('index');
$tpl->key('title', 'Template Page');

$content = "Test content";
$tpl->key('content', $content);

echo $tpl->init();