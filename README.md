# Template

** How start **

$tpl = new Template('index');
$tpl->key('title', 'Template Page');

$content = "Test content";
$tpl->key('content', $content);

echo $tpl->init();

** How to use key method **

* PHP site
$tpl->key('content', $content);

* tpl site
{CONTENT}

