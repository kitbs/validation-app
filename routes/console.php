<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('validate {rule} {text}', function($rule, $text) {
    $validator = Validator::make(['text' => $text], ['text' => $rule]);
    dd($validator->passes());
    // $this->line($validator->errors());
});

Artisan::command('rules:import {namespace} {--method=validate,check} {--exclude=} {--only=} {--alias=}', function() {

    $namespace = $this->argument('namespace');
    $methods = explode(',', str_replace(' ', '', $this->option('method')));

    $exclude = $this->option('exclude') ? explode(',', str_replace(' ', '', $this->option('exclude'))) : [];
    $only = $this->option('only') ? explode(',', str_replace(' ', '', $this->option('only'))) : [];

    if (count($only) && count($exclude)) {
        throw new \Exception("Only one of --exclude or --only may be set.", 1);
    }

    $aliases = collect(explode(',', str_replace(', ', ',', $this->option('alias'))))->mapWithKeys(function($item) {
        $item = explode(':', $item);
        $key = array_shift($item);

        return [$key => $item];
    });

    $ruleStub = trim(Storage::get('validation/stubs/rule.stub'));
    $messageStub = trim(Storage::get('validation/stubs/message.stub'));

    $rules = [];
    $messages = [];

    $classmap = require base_path('vendor/composer/autoload_classmap.php');

    $classes = collect($classmap)->filter(function($path, $class) use ($namespace) {
        return str_is(trim($namespace,'\\').'\\*', $class);
    });

    $classes->each(function($path, $class) use ($methods, $namespace, $exclude, $only, $aliases, $ruleStub, $messageStub, &$rules, &$messages) {

        $ruleClass = new ReflectionClass($class);

        if ($ruleClass->isInstantiable()) {

            $validateMethod = null;

            foreach ($methods as $method) {
                if ($ruleClass->hasMethod($method)) {
                    $validateMethod = new ReflectionMethod($class, $method);
                    break;
                }
            }

            if (!$validateMethod) {

                $publicMethods = collect($ruleClass->getMethods(ReflectionMethod::IS_PUBLIC))->transform(function($method) {
                    return $method->getName();
                })->toArray();

                throw new \Exception(sprintf('Class "%s" does not have any methods matching "%s". Available methods are: "%s".', $class, implode(', ', $methods), implode(', ', $publicMethods)));
            }

            $rule = preg_replace('/^'.$namespace.'\\\\/', null, $class);
            $rule = explode('\\', $rule);
            $rule = array_map('snake_case', $rule);
            $rule = implode('.', $rule);

            if ((count($exclude) && !in_array($rule, $exclude, true)) || (count($only) && in_array($rule, $only, true)) || (!count($only) && !count($exclude))) {

                if ($aliases->has($rule)) {
                    $alias = $aliases->get($rule);
                    $rule = array_shift($alias);
                }

                if (isset($alias) && count($alias)) {
                    $ruleName = array_shift($alias);
                }
                else {
                    $ruleName = $ruleClass->getShortName();
                    $ruleName = preg_replace(['/([a-z])([0-9A-Z])/', '/([0-9])([A-Z])/'], '$1 $2', $ruleName);
                }

                $parameters = collect($validateMethod->getParameters())->mapWithKeys(function($parameter) {
                    if ($parameter->getPosition() > 0) {
                        return [
                            $parameter->getName() => $parameter->isOptional() ? $parameter->getDefaultValue() : $parameter->allowsNull() ? null : 'unset',
                        ];
                    }
                });

                // $parameters->shift(); // Ignore validated value

                $syntax = $rule;

                $parameterVariables = [];
                $i = 0;

                if ($parameters->count()) {
                    $syntax .= ':'.$parameters->map(function($value, $key) use (&$parameterVariables, &$i) {

                        $parameterVariables[] = '@$parameters['.$i.']'.($value !== 'unset' ? ' ?: ' . json_encode($value) : null);
                        $i++;

                        return $value !== 'unset' ? ($key . '=' . json_encode($value)) : $key;

                    })->implode(',');
                }

                $parameterVariables = !empty($parameterVariables) ? ', '.implode(', ', $parameterVariables) : null;

                $replacements = [
                    '__RULE__'       => $rule,
                    '__RULENAME__'   => $ruleName,
                    '__CLASS__'      => $class,
                    '__METHOD__'     => $validateMethod->getName(),
                    '__PARAMETERS__' => $parameterVariables, //TODO
                    '__SYNTAX__'     => $syntax,
                ];

                $rules[] = str_replace(array_keys($replacements), array_values($replacements), $ruleStub);
                // $messages[] = str_replace(array_keys($replacements), array_values($replacements), $messageStub);
                array_set($messages, $rule, str_replace(array_keys($replacements), array_values($replacements), $messageStub));

            }

        }

    });

    $rules = '<?php'.PHP_EOL.PHP_EOL.implode(PHP_EOL.PHP_EOL, $rules);
    // $messages = '<?php'.PHP_EOL.PHP_EOL.'return ['.PHP_EOL.implode(PHP_EOL, $messages).PHP_EOL.'];';
    $messages = '<?php'.PHP_EOL.PHP_EOL.'return '.var_export($messages, 1).';';

    Storage::put('validation/output/rules.php', $rules);
    Storage::put('validation/output/messages.php', $messages);

});
