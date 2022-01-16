# MixerAPI Demo Application

This demo makes use of the optional MixerApi/Crud plugin which uses CakePHPs
[service container](https://book.cakephp.org/4/en/development/dependency-injection.html)
for dependency injection. Example:

```php
public function add(CreateInterface $create, string $id)
{
    $this->set('data', $create->create($this));
}
```

This produces the same result as traditional bake scaffolding such as the example below in fewer lines and handles JSON
serialization automatically.

The live demo make use of [CakePHP Preloader](https://github.com/cnizzardini/cakephp-preloader) to generate an OPCache
preload file.
