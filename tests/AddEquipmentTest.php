<?php
// tests/AddEquipmentTest.php

namespace tests;

use PHPUnit\Framework\TestCase;
use Validators\DateValidator;
use Validators\ImageValidator;
use Validators\PositiveNumberValidator;
use Validators\RequiredValidator;

class AddEquipmentTest extends TestCase
{
    public function test_negative_price_fails()
    {
        $validator = new PositiveNumberValidator('Price', -500);
        $this->assertFalse($validator->rule(), "Валидатор цены должен отклонить отрицательное число");
    }

    public function test_valid_price_passes()
    {
        $validator = new PositiveNumberValidator('Price', 15000);

        $this->assertTrue($validator->rule(), "Валидатор цены должен пропустить положительное число");
    }

    public function test_future_date_fails()
    {
        $futureDate = date('Y-m-d', strtotime('+10 years'));

        $validator = new DateValidator('Commissioning_date', $futureDate);

        $this->assertFalse($validator->rule(), "Валидатор даты должен отклонить будущую дату");
    }

    public function test_valid_date_passes()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $validator = new DateValidator('Commissioning_date', $yesterday);

        $this->assertTrue($validator->rule(), "Валидатор даты должен пропустить вчерашнюю дату");
    }

    public function test_empty_required_field_fails()
    {
        $validator = new RequiredValidator('Name', '');

        $this->assertFalse($validator->rule(), "Валидатор Required должен отклонить пустую строку");
    }

    public function test_invalid_image_extension_fails()
    {
        $fakeFile = [
            'name' => 'virus.exe',
            'type' => 'application/x-msdownload',
            'tmp_name' => '/tmp/php123',
            'error' => 0,
            'size' => 1024
        ];

        $validator = new ImageValidator('image', $fakeFile);

        $this->assertFalse($validator->rule(), "Валидатор изображения должен отклонить .exe файл");
    }

    public function test_valid_image_passes()
    {
        $fakeImage = [
            'name' => 'photo.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/php123',
            'error' => 0,
            'size' => 1024
        ];

        $validator = new ImageValidator('image', $fakeImage);

        $this->assertTrue($validator->rule(), "Валидатор изображения должен пропустить .jpg файл");
    }
}