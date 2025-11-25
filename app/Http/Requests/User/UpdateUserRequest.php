<?php

namespace App\Http\Requests\user;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    public function rules()
    {
        // نحصل على الـ User ID من الراوت لاستثنائه من فحص التكرار
        $userId = $this->route('user') ? $this->route('user')->id : $this->id;

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6', // كلمة المرور اختيارية عند التعديل
            'status'   => 'nullable|in:admin,writer,null',
        ];
    }
}
