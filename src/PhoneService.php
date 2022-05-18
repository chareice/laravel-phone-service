<?php


namespace Chareice\PhoneService;


use Chareice\PhoneService\Contracts\PhoneService as PhoneServiceInterface;
use Chareice\VerificationCode\VerificationCodeService;

class PhoneService implements PhoneServiceInterface
{
    protected VerificationCodeService $codeService;

    public function __construct(VerificationCodeService $codeService)
    {
        $this->codeService = $codeService;
    }

    public function getVerificationCode(string $phone) : string
    {
        return $this->codeService->setCode($phone, 60 * 30);
    }

    public function verifyPhoneWithCode(string $phone, string $code): bool
    {
        if (!$this->codeService->check($phone, $code)) {
            return false;
        }

        return $phone;
    }

}