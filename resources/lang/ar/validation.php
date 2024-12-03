<?php

return [

    /*
    |--------------------------------------------------------------------------
    | خطوط اللغة للتحقق
    |--------------------------------------------------------------------------
    |
    | السطور التالية تحتوي على رسائل الخطأ الافتراضية المستخدمة من قبل
    | الفئة المسؤولة عن التحقق. بعض هذه القواعد تحتوي على إصدارات متعددة،
    | مثل قواعد الحجم. يمكنك تعديل هذه الرسائل بحرية هنا.
    |
    */

    'accepted' => 'يجب قبول الحقل :attribute.',
    'active_url' => 'الحقل :attribute ليس رابط URL صحيح.',
    'after' => 'يجب أن يكون الحقل :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون الحقل :attribute تاريخًا مساويًا أو بعد :date.',
    'alpha' => 'يجب أن يحتوي الحقل :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي الحقل :attribute على أحرف، أرقام، شرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي الحقل :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون الحقل :attribute مصفوفة.',
    'before' => 'يجب أن يكون الحقل :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون الحقل :attribute تاريخًا مساويًا أو قبل :date.',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute بين :min و :max حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute بين :min و :max عناصر.',
    ],
    'boolean' => 'يجب أن تكون قيمة الحقل :attribute إما صحيحة أو خاطئة.',
    'confirmed' => 'تأكيد الحقل :attribute غير متطابق.',
    'date' => 'الحقل :attribute ليس تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون الحقل :attribute تاريخًا مساويًا لـ :date.',
    'date_format' => 'الحقل :attribute لا يتطابق مع التنسيق :format.',
    'different' => 'يجب أن يكون الحقل :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي الحقل :attribute على :digits رقم.',
    'digits_between' => 'يجب أن يحتوي الحقل :attribute بين :min و :max أرقام.',
    'dimensions' => 'الحقل :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'الحقل :attribute يحتوي على قيمة مكررة.',
    'email' => 'يجب أن يكون الحقل :attribute عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن ينتهي الحقل :attribute بأحد القيم التالية: :values.',
    'exists' => 'الحقل :attribute المحدد غير صالح.',
    'file' => 'يجب أن يكون الحقل :attribute ملفًا.',
    'filled' => 'يجب أن يحتوي الحقل :attribute على قيمة.',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute أكبر من :value حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على أكثر من :value عناصر.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من أو تساوي :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute أكبر من أو يساوي :value حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على :value عناصر أو أكثر.',
    ],
    'image' => 'يجب أن يكون الحقل :attribute صورة.',
    'in' => 'الحقل :attribute غير صالح.',
    'in_array' => 'الحقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون الحقل :attribute رقمًا صحيحًا.',
    'ip' => 'يجب أن يكون الحقل :attribute عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون الحقل :attribute عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون الحقل :attribute عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون الحقل :attribute نص JSON صالح.',
    'lt' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أقل من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أقل من :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute أقل من :value حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على أقل من :value عناصر.',
    ],
    'lte' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أقل من أو تساوي :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أقل من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute أقل من أو يساوي :value حروف.',
        'array' => 'يجب ألا يحتوي الحقل :attribute على أكثر من :value عناصر.',
    ],
    'max' => [
        'numeric' => 'يجب ألا تكون قيمة الحقل :attribute أكبر من :max.',
        'file' => 'يجب ألا يكون حجم الملف :attribute أكبر من :max كيلوبايت.',
        'string' => 'يجب ألا يكون طول النص :attribute أكبر من :max حروف.',
        'array' => 'يجب ألا يحتوي الحقل :attribute على أكثر من :max عناصر.',
    ],
    'mimes' => 'يجب أن يكون الحقل :attribute ملفًا من النوع: :values.',
    'mimetypes' => 'يجب أن يكون الحقل :attribute ملفًا من النوع: :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute على الأقل :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على الأقل :min عناصر.',
    ],
    'not_in' => 'الحقل :attribute غير صالح.',
    'not_regex' => 'تنسيق الحقل :attribute غير صالح.',
    'numeric' => 'يجب أن يكون الحقل :attribute رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب أن يكون الحقل :attribute موجودًا.',
    'regex' => 'تنسيق الحقل :attribute غير صالح.',
    'required' => 'الحقل :attribute مطلوب.',
    'required_if' => 'الحقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_unless' => 'الحقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'الحقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_with_all' => 'الحقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without' => 'الحقل :attribute مطلوب عندما لا يكون :values موجودًا.',
    'required_without_all' => 'الحقل :attribute مطلوب عندما لا يكون أي من :values موجودًا.',
    'same' => 'يجب أن يتطابق الحقل :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute :size.',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute :size حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على :size عناصر.',
    ],
    'starts_with' => 'يجب أن يبدأ الحقل :attribute بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون الحقل :attribute نصًا.',
    'timezone' => 'يجب أن يكون الحقل :attribute منطقة زمنية صحيحة.',
    'unique' => 'الحقل :attribute مستخدم بالفعل.',
    'uploaded' => 'فشل في تحميل الحقل :attribute.',
    'url' => 'تنسيق الحقل :attribute غير صالح.',
    'uuid' => 'يجب أن يكون الحقل :attribute UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | خطوط اللغة المخصصة للتحقق
    |--------------------------------------------------------------------------
    |
    | هنا يمكنك تحديد رسائل تحقق مخصصة لخصائص باستخدام
    | صيغة "attribute.rule" لتسمية السطور. هذا يجعل من السهل
    | تحديد رسالة لغة معينة لقاعدة معينة.
    |
    */

    'custom' => [
        'nombre-del-atributo' => [
            'nombre-de-la-regla' => 'رسالة مخصصة',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | أسماء الخصائص المخصصة للتحقق
    |--------------------------------------------------------------------------
    |
    | السطور التالية تُستخدم لتغيير أسماء الخصائص
    | إلى أسماء أكثر قابلية للفهم للقارئ مثل "البريد الإلكتروني"
    | بدلاً من "email". هذا يجعل الرسالة أكثر وضوحًا.
    |
    */

    'attributes' => [],

];
