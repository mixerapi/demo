# MixerAPI Demo Application

This demo makes use of the experimental [service container](https://book.cakephp.org/4/en/development/dependency-injection.html)
which introduces dependency injection to CakePHP ^4.2 projects.

See [src/Application.php](src/Application.php) for the service provider definition and
[plugins/Crud/src](plugins/Crud/src) for services and service provider. This allows services to be injected into
controller actions. Example:

```php
public function view(GetRecordService $getRecord, string $id)
{
    $this->set('actor', $getRecord->table('Actors')->retrieve($id));
}
```

In [plugins/Crud/src/Plugin.php](plugins/Crud/src/Plugin.php) a `Controller.initialize` and `Controller.beforeRender`
event eliminate the need for `$this->viewBuilder->setOption('serialize', 'data')` and `$this->request->allow()` in
the controller actions.

```php
public function view(GetRecordService $getRecord, string $id)
{
    //$this->request->allow('get'); # automatically set by an event
    $this->set('actor', $getRecord->table('Actors')->retrieve($id));
    //$this->viewBuilder()->setOption('serialize', 'actor'); # automatically set by an event
}
```

None of is necessary within your implementation, this is just another way to write an application.

The live demo make use of [CakePHP Preloader](https://github.com/cnizzardini/cakephp-preloader) to generate an OPCache
preload file.
