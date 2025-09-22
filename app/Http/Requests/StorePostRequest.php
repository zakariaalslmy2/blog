<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post; // تأكد من استدعاء مودل الـ Post

class StorePostRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مصرحًا له بإجراء هذا الطلب.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // نقل منطق التحقق من الصلاحيات هنا
        // سيتم التحقق من سياسة 'create' المرتبطة بمودل الـ Post
        return $this->user()->can('create', Post::class);
    }

    /**
     * الحصول على قواعد التحقق التي تنطبق على الطلب.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // تعريف جميع قواعد التحقق هنا
        $rules = [
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // الصورة اختيارية، ويجب أن تكون صورة وبحد أقصى 2MB
            'category_id' => ['required', 'integer', 'exists:categories,id'], // حقل إلزامي، ويجب أن تكون قيمته موجودة في جدول categories
        ];

        // إضافة قواعد التحقق بشكل ديناميكي لكل اللغات المعرفة في النظام
        foreach (config('app.languages') as $key => $lang) {
            $rules[$key . '.title'] = ['required', 'string', 'max:255'];
            $rules[$key . '.smallDesc'] = ['required', 'string', 'max:500'];
            $rules[$key . '.content'] = ['required', 'string'];
            $rules[$key . '.tags'] = ['nullable', 'string'];
        }


        return $rules;
    }

    /**
     * تنقية البيانات وتجهيزها قبل عملية التحقق.
     * هذا هو المكان الأمثل لعملية الـ Sanitization.
     */
    protected function prepareForValidation(): void
    {
        // حلقة على كل اللغات لتنقية حقولها
        foreach (config('app.languages') as $key => $lang) {
            $this->mergeIfMissing([$key => []]); // التأكد من وجود المصفوفة لتجنب الأخطاء

            $this->merge([
                $key => [
                    // استخدام strip_tags لإزالة أي أكواد HTML أو Javascript (حماية من XSS)
                    'title' => $this->stripTags($this->input("$key.title")),
                    'smallDesc' => $this->stripTags($this->input("$key.smallDesc")),
                    'content' => $this->cleanContent($this->input("$key.content")), // يمكن استخدام دالة مخصصة للمحتوى
                    'tags' => $this->stripTags($this->input("$key.tags")),
                ],
            ]);
        }
    }

    /**
     * دالة مساعدة لإزالة الوسوم.
     */
    private function stripTags(?string $value): ?string
    {
        return $value ? strip_tags($value) : null;
    }

    /**
     * دالة لتنقية المحتوى (يمكن تخصيصها للسماح ببعض وسوم HTML الآمنة باستخدام مكتبة خارجية مثل HTMLPurifier).
     */
    private function cleanContent(?string $value): ?string
    {
        // كمثال بسيط، سنقوم بإزالة الوسوم هنا أيضاً.
        return $value ? strip_tags($value) : null;
    }
}
