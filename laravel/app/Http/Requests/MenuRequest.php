<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseValidate;

class MenuRequest extends BaseValidate
{

    public function rules()
    {
        $rules = [
            'h5_id' => 'required |exists:h5_template,h5_id',
            'font_color' => 'required|string|nullable',
            'select_color' => 'string|nullable',
            'background_color' => 'string|nullable',
            'position' => 'required|int| between:0,1',
        ];
        return $rules;
    }

    public function messages()
    {
        $message = [
            'h5_id.required' => 'h5_id必须填写',
            'h5_id.exists' => 'h5_id不存在!',
            'position.required' => '请选择位置!',
            'font_color.required' => 'font_color必须填写',
        ];
        return $message;
    }

    public function scene()
    {
        return [
            'index' => [
                'h5_id', //复用 rules() 下规则
                'position' => 'required|int', //重置规则
            ],
            //edit场景
            // 'index' => ['name'],
        ];
    }

    public function autoValidate()
    {
        $sceneName = $this->getSceneName();
        if (in_array($sceneName, ['index'])) { //add 场景下关闭自动验证
            return false;
        }
        return true;
    }

}
