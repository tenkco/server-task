<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class DateValidator extends AbstractValidator
{
    protected string $message = 'Некорректная дата';

    public function rule(): bool
    {
        $date = \DateTime::createFromFormat('Y-m-d', $this->value);
        if (!$date || $date->format('Y-m-d') !== $this->value) {
            $this->message = 'Не правильный формат даты';
            return false;
        }

        $today = new \DateTime();
        $inputDate = new \DateTime($this->value);

        $today->setTime(0, 0, 0);

        if ($inputDate > $today) {
            $this->message = 'Дата не может быть больше сегодняшней';
            return false;
        }

        return true;
    }
}