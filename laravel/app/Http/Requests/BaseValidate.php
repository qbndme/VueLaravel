<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseValidate extends FormRequest
{
    use SceneValidator;
    /**
     * 设置是否自动验证
     * @return bool
     */
    public function autoValidate()
    {
        return true;
    }

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->all();
        self::abnormal($error);
    }

    /** 定义错误信息json，可针对逻辑上的问题或验证抛出此错误来终止程序
     * @param string $massage
     * @param int $code
     */
    public static function abnormal($msg = 'error', $code = 400)
    {
        $response = response()->json([
            'code' => $code,
            'msg' => $msg,
        ], $code);
        throw new HttpResponseException($response);
    }

    /** 抛出异常,header状态码同code
     * @param string $massage
     * @param int $code
     */
    public static function throwOut($massage = 'error', $code = 400)
    {
        throw new HttpException($code, $massage);
    }

}
