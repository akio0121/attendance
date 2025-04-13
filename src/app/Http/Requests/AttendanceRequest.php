<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_work' => 'required',
            'finish_work' => 'required',
            'rests.*.start_rest' => 'required',
            'rests.*.finish_rest' => ['required', 'after:rests.*.start_rest'],
            'notes' => 'required',
            'rests.new.start_rest' => ['nullable', 'required_with:rests.new.finish_rest', 'date_format:H:i'],
            'rests.new.finish_rest' => ['nullable', 'required_with:rests.new.start_rest', 'date_format:H:i', 'after:rests.new.start_rest'],
        ];
    }

    public function messages()
    {
        return [
            'start_work.required' => '出勤時間を入力してください',
            'finish_work.required' => '退勤時間を入力してください',
            'rests.*.start_rest.required' => '休憩開始時間を入力してください',
            'rests.*.finish_rest.required' => '休憩終了時間を入力してください',
            'rests.*.finish_rest.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'rests.new.start_rest.required_with' => '休憩開始時間を入力してください',
            'rests.new.finish_rest.required_with' => '休憩終了時間を入力してください',
            'rests.new.finish_rest.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'notes.required' => '備考を記入してください',
        ];
    }

    //出勤時間が退勤時間より後の場合、エラーメッセージを表示する
    /*public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $start = $this->input('start_work');
            $finish = $this->input('finish_work');

            // 両方の値があるときだけチェック
            if ($start && $finish && $start > $finish) {
                $validator->errors()->add('start_work', '出勤時間もしくは退勤時間が不適切な値です');
            }
        });
    }*/

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $start = $this->input('start_work');
            $finish = $this->input('finish_work');

            // 出勤・退勤の前後関係チェック
            if ($start && $finish && $start > $finish) {
                $validator->errors()->add('start_work', '出勤時間もしくは退勤時間が不適切な値です');
            }

            // 退勤時間が存在する場合のみ、休憩との比較を行う
            if ($finish) {
                // 既存の休憩（rests[*]）をチェック
                foreach ($this->input('rests', []) as $index => $rest) {
                    if (!empty($rest['start_rest']) && $rest['start_rest'] > $finish) {
                        $validator->errors()->add("rests.$index.start_rest", "出勤時間もしくは退勤時間が不適切な値です");
                    }

                    if (!empty($rest['finish_rest']) && $rest['finish_rest'] > $finish) {
                        $validator->errors()->add("rests.$index.finish_rest", "出勤時間もしくは退勤時間が不適切な値です");
                    }
                }

                // 新規の休憩（rests.new）もチェック
                $newRest = $this->input('rests.new', []);
                if (!empty($newRest['start_rest']) && $newRest['start_rest'] > $finish) {
                    $validator->errors()->add("rests.new.start_rest", "出勤時間もしくは退勤時間が不適切な値です");
                }
                if (!empty($newRest['finish_rest']) && $newRest['finish_rest'] > $finish) {
                    $validator->errors()->add("rests.new.finish_rest", "出勤時間もしくは退勤時間が不適切な値です");
                }
            }
        });
    }
}
