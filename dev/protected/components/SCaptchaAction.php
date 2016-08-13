<?php
/**
 * 重构验证码类
 * 生成数字型验证码
 */
class SCaptchaAction extends CCaptchaAction {

    /**
     * 生成验证码
     * @return string
     */
    protected function generateVerifyCode() {
        if ($this->minLength > $this->maxLength)
            $this->maxLength = $this->minLength;
        if ($this->minLength < 3)
            $this->minLength = 3;
        if ($this->maxLength > 20)
            $this->maxLength = 20;
        $length = mt_rand($this->minLength, $this->maxLength);
        $letters = '1234567890';
        $code = '';
        for ($i = 0; $i < $length; ++$i) {
            $code.=$letters[mt_rand(0, 9)];
        }
        return $code;
    }

}
