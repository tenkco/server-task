<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Недопустимый формат или слишком большой файл (макс. 5 Мб)';

    public function rule(): bool
    {
        if (empty($this->value) || $this->value['error'] !== UPLOAD_ERR_OK) {
            return true;
        }

        $file = $this->value;

        if ($file['size'] > 5 * 1024 * 1024) {
            $this->message = 'Файл слишком большой. Максимум 5 Мб.';
            return false;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            $this->message = 'Недопустимый формат. Разрешены: jpg, png, gif,';
            return false;
        }

        return true;
    }
}