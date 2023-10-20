<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tutor_id'=>'required|exists:tutors,id',
            'course_id'=>'required|exists:courses,id',
            'classroom_id'=>'required|exists:class_rooms,id',
            'time_slot'=>'required',
            'date'=>'required',
            //
        ];
    }
}
