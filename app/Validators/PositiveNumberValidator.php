<?php
namespace Validators;
use Src\Validator\AbstractValidator;

class PositiveNumberValidator extends AbstractValidator
{
    protected string $message = 'Цена должна быть числом больше нуля';

    public function rule(): bool
    {
        return is_numeric($this->value) && $this->value >= 0;
    }
}