<?php
namespace Src\Validator;

class Validator
{
    protected array $fields = [];
    protected array $rules = [];
    protected array $errors = [];

    protected array $validators = [
        'required'       => \Validators\RequiredValidator::class,
        'unique'         => \Validators\UniqueValidator::class,
        'positiveNumber' => \Validators\PositiveNumberValidator::class,
        'date'           => \Validators\DateValidator::class,
        'image'          => \Validators\ImageValidator::class,
    ];

    public function __construct(array $fields, array $rules)
    {
        $this->fields = $fields;
        $this->rules = $rules;
    }
    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules as $fieldName => $fieldRules) {
            foreach ($fieldRules as $rule) {
                if (str_contains($rule, ':')) {
                    [$ruleName, $argsString] = explode(':', $rule, 2);
                    $args = explode(',', $argsString);
                } else {
                    $ruleName = $rule;
                    $args = [];
                }

                $validatorClass = $this->validators[$ruleName] ?? null;

                if (!$validatorClass || !class_exists($validatorClass)) {
                    continue;
                }

                $validator = new $validatorClass(
                    $fieldName,
                    $this->fields[$fieldName] ?? null,
                    $args
                );

                $result = $validator->validate();

                if ($result !== true) {
                    $this->errors[$fieldName][] = $result;
                }
            }
        }

        return empty($this->errors);
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}