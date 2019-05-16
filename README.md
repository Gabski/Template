# Template

## How start 

```php
$tpl = new Template('index');
$tpl->key('title', 'Template Page');

$content = "Test content";
$tpl->key('content', $content);

echo $tpl->init();
```

## How to use load method 
You can reload main .tpl file in PHP site

### PHP site

```php
$tpl->load('name', 'dir/', '.tpl');
```

## How to use key method 

### PHP site

```php
$tpl->key('content', $content);
$tpl->key('string', 'Test string');
```

### tpl site

```html
{CONTENT}
{STRING}
```

## How to use tpl include 
You can include other .tpl file by name, in the same directory

### tpl site
```html
{include name.tpl}
```
