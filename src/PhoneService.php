<?php


namespace Chareice\PhoneService;


use Chareice\PhoneService\Contracts\PhoneService as PhoneServiceInterface;
use Chareice\VerificationCode\VerificationCodeService;
use EasyWeChat\MiniProgram\Application;

class PhoneService implements PhoneServiceInterface
{
    protected VerificationCodeService $codeService;
    protected Application $miniApp;

    public function __construct(VerificationCodeService $codeService, Application $miniApp)
    {
        $this->codeService = $codeService;
        $this->miniApp = $miniApp;
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

    public function getPhoneByWechat(string $code, string $iv, string $encryptData): string
    {
        $sessionInfo = $this->miniApp->auth->session($code);
        $sessionKey = $sessionInfo['session_key'];
        $data = $this->miniApp->encryptor->decryptData($sessionKey, $iv, $encryptData);
        return $data['purePhoneNumber'];
    }
}