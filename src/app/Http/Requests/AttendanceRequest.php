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
            'rests.*.start_rest' => ['required', 'after:start_work'],
            'rests.*.finish_rest' => ['required', 'after:rests.*.start_rest', 'after:start_work'],
            'notes' => 'required',
            'rests.new.start_rest' => ['nullable', 'required_with:rests.new.finish_rest', 'date_format:H:i'],
            'rests.new.finish_rest' => ['nullable', 'required_with:rests.new.start_rest', 'date_format:H:i', 'after:rests.new.start_rest'],
        ];
    }

    public function messages()
    {
        return [
            //出勤時間が空白
            'start_work.required' => '出勤時間を入力してください',
            //退勤時間が空白
            'finish_work.required' => '退勤時間を入力してください',
            //休憩開始時間が空白
            'rests.*.start_rest.required' => '休憩開始時間を入力してください',
            //休憩開始時間が勤務開始時間より前
            'rests.*.start_rest.after' => '休憩時間が勤務時間外です',
            //休憩終了時間が空白
            'rests.*.finish_rest.required' => '休憩終了時間を入力してください',
            //休憩終了時間が勤務開始時間より前
            'rests.*.finish_rest.after' => '休憩時間が勤務時間外です',
            //休憩終了時間が休憩開始時間より後
            'rests.*.finish_rest.after' => '休憩時間が勤務時間外です',
            //追加分の休憩開始時間が空白
            'rests.new.start_rest.required_with' => '休憩開始時間を入力してください',
            //追加分の休憩終了時間が空白
            'rests.new.finish_rest.required_with' => '休憩終了時間を入力してください',
            //備考が空白
            'notes.required' => '備考を記入してください',
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $start = $this->input('start_work');
            $finish = $this->input('finish_work');

            // 出勤・退勤の前後関係チェック
            if ($start && $finish && $start > $finish) {
                $validator->errors()->add('start_work', '出勤時間もしくは退勤時間が不適切な値です');
            }

            if ($finish) {
                // 既存の休憩（rests[*]）をチェック
                foreach ($this->input('rests', []) as $index => $rest) {
                    if (!empty($rest['start_rest']) && $rest['start_rest'] > $finish) {
                        $validator->errors()->add("rests.$index.start_rest", "休憩時間が勤務時間外です");
                    }
                    if (!empty($rest['finish_rest']) && $rest['finish_rest'] > $finish) {
                        $validator->errors()->add("rests.$index.finish_rest", "休憩時間が勤務時間外です");
                    }
                }

                // 新規の休憩（rests.new）もチェック
                $newRest = $this->input('rests.new', []);
                if (!empty($newRest['start_rest'])) {
                    if ($newRest['start_rest'] > $finish) {
                        $validator->errors()->add("rests.new.start_rest", "休憩時間が勤務時間外です");
                    }
                    if ($start && $newRest['start_rest'] < $start) {
                        $validator->errors()->add("rests.new.start_rest", "休憩時間が勤務時間外です");
                    }
                }

                if (!empty($newRest['finish_rest'])) {
                    if ($newRest['finish_rest'] > $finish) {
                        $validator->errors()->add("rests.new.finish_rest", "休憩時間が勤務時間外です");
                    }
                    if ($start && $newRest['finish_rest'] < $start) {
                        $validator->errors()->add("rests.new.finish_rest", "休憩時間が勤務時間外です");
                    }
                }
            }
        });
    }
}
