<?php


namespace Chareice\PhoneService\Contracts;


interface PhoneService
{
    public function verifyPhoneWithCode(string $phone, string $code);
    public function getVerificationCode(string $phone);
}