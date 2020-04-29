<?php
namespace Toyza55k\Backend\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait ModelReplacements {

	public function buildModelReplacements(array $replace, $model)
	{
	    $modelClass = $this->parseModel($model);

	    return array_merge($replace, [
	        'DummyFullModelClass' => $modelClass,
	        '{{ namespacedModel }}' => $modelClass,
	        '{{namespacedModel}}' => $modelClass,
	        'DummyModelClass' => class_basename($modelClass),
	        '{{ model }}' => class_basename($modelClass),
	        '{{model}}' => class_basename($modelClass),
	        'DummyModelVariable' => lcfirst(class_basename($modelClass)),
	        '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
	        '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
	        'DummyModelVariableKebab' => Str::kebab(class_basename($modelClass)),
	        '{{ modelVariableKebab }}' => Str::kebab(class_basename($modelClass)),
	        '{{modelVariableKebab}}' => Str::kebab(class_basename($modelClass)),
	        'DummyModelVariableSnake' => Str::snake(class_basename($modelClass)),
	        '{{ modelVariableSnake }}' => Str::snake(class_basename($modelClass)),
	        '{{modelVariableSnake}}' => Str::snake(class_basename($modelClass)),
	    ]);
	}

	public function parseModel($model)
	{
	    if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
	        throw new InvalidArgumentException('Model name contains invalid characters.');
	    }

	    $model = trim(str_replace('/', '\\', $model), '\\');

	    if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
	        $model = $rootNamespace.$model;
	    }

	    return $model;
	}

}