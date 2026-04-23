<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted'        => 'يجب قبول حقل :attribute.',
    'accepted_if'     => 'يجب قبول حقل :attribute عندما يكون :other بقيمة :value.',
    'active_url'      => 'حقل :attribute يجب أن يكون رابطاً صالحاً.',
    'after'           => 'حقل :attribute يجب أن يكون تاريخاً بعد :date.',
    'after_or_equal'  => 'حقل :attribute يجب أن يكون تاريخاً بعد أو يساوي :date.',
    'alpha'           => 'حقل :attribute يجب أن يحتوي على أحرف فقط.',
    'alpha_dash'      => 'حقل :attribute يجب أن يحتوي على أحرف، أرقام، شرطات، وشرطات سفلية فقط.',
    'alpha_num'       => 'حقل :attribute يجب أن يحتوي على أحرف وأرقام فقط.',
    'array'           => 'حقل :attribute يجب أن يكون مصفوفة.',
    'ascii'           => 'حقل :attribute يجب أن يحتوي على أحرف ورموز أحادية البايت فقط.',
    'before'          => 'حقل :attribute يجب أن يكون تاريخاً قبل :date.',
    'before_or_equal' => 'حقل :attribute يجب أن يكون تاريخاً قبل أو يساوي :date.',
    'between'         => [
        'array'   => 'حقل :attribute يجب أن يحتوي على عدد عناصر بين :min و :max.',
        'file'    => 'حقل :attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون بين :min و :max.',
        'string'  => 'حقل :attribute يجب أن يكون بين :min و :max حرفاً.',
    ],
    'boolean'           => 'حقل :attribute يجب أن يكون صحيحاً أو خاطئاً.',
    'confirmed'         => 'تأكيد حقل :attribute غير متطابق.',
    'current_password'  => 'كلمة المرور غير صحيحة.',
    'date'              => 'حقل :attribute يجب أن يكون تاريخاً صالحاً.',
    'date_equals'       => 'حقل :attribute يجب أن يكون تاريخاً مساوياً لـ :date.',
    'date_format'       => 'حقل :attribute يجب أن يطابق الصيغة :format.',
    'decimal'           => 'حقل :attribute يجب أن يحتوي على :decimal منازل عشرية.',
    'declined'          => 'يجب رفض حقل :attribute.',
    'declined_if'       => 'يجب رفض حقل :attribute عندما يكون :other بقيمة :value.',
    'different'         => 'حقل :attribute و :other يجب أن يكونا مختلفين.',
    'digits'            => 'حقل :attribute يجب أن يكون :digits أرقام.',
    'digits_between'    => 'حقل :attribute يجب أن يكون بين :min و :max أرقام.',
    'dimensions'        => 'حقل :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'          => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_end_with'   => 'حقل :attribute يجب ألا ينتهي بأحد القيم التالية: :values.',
    'doesnt_start_with' => 'حقل :attribute يجب ألا يبدأ بأحد القيم التالية: :values.',
    'email'             => 'حقل :attribute يجب أن يكون عنوان بريد إلكتروني صالح.',
    'ends_with'         => 'حقل :attribute يجب أن ينتهي بأحد القيم التالية: :values.',
    'enum'              => 'القيمة المختارة لـ :attribute غير صالحة.',
    'exists'            => 'القيمة المختارة لـ :attribute غير صالحة.',
    'file'              => 'حقل :attribute يجب أن يكون ملفاً.',
    'filled'            => 'حقل :attribute يجب أن يحتوي على قيمة.',
    'gt'                => [
        'array'   => 'حقل :attribute يجب أن يحتوي على أكثر من :value عناصر.',
        'file'    => 'حقل :attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من :value.',
        'string'  => 'حقل :attribute يجب أن يكون أكثر من :value حرفاً.',
    ],
    'gte' => [
        'array'   => 'حقل :attribute يجب أن يحتوي على :value عناصر أو أكثر.',
        'file'    => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value.',
        'string'  => 'حقل :attribute يجب أن يكون أكثر من أو يساوي :value حرفاً.',
    ],
    'image'     => 'حقل :attribute يجب أن يكون صورة.',
    'in'        => 'القيمة المختارة لـ :attribute غير صالحة.',
    'in_array'  => 'حقل :attribute يجب أن يكون موجوداً في :other.',
    'integer'   => 'حقل :attribute يجب أن يكون عدداً صحيحاً.',
    'ip'        => 'حقل :attribute يجب أن يكون عنوان IP صالح.',
    'ipv4'      => 'حقل :attribute يجب أن يكون عنوان IPv4 صالح.',
    'ipv6'      => 'حقل :attribute يجب أن يكون عنوان IPv6 صالح.',
    'json'      => 'حقل :attribute يجب أن يكون نص JSON صالح.',
    'lowercase' => 'حقل :attribute يجب أن يكون بأحرف صغيرة.',
    'lt'        => [
        'array'   => 'حقل :attribute يجب أن يحتوي على أقل من :value عناصر.',
        'file'    => 'حقل :attribute يجب أن يكون أقل من :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أقل من :value.',
        'string'  => 'حقل :attribute يجب أن يكون أقل من :value حرفاً.',
    ],
    'lte' => [
        'array'   => 'حقل :attribute يجب ألا يحتوي على أكثر من :value عناصر.',
        'file'    => 'حقل :attribute يجب أن يكون أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أقل من أو يساوي :value.',
        'string'  => 'حقل :attribute يجب أن يكون أقل من أو يساوي :value حرفاً.',
    ],
    'mac_address' => 'حقل :attribute يجب أن يكون عنوان MAC صالح.',
    'max'         => [
        'array'   => 'حقل :attribute يجب ألا يحتوي على أكثر من :max عناصر.',
        'file'    => 'حقل :attribute يجب ألا يكون أكبر من :max كيلوبايت.',
        'numeric' => 'حقل :attribute يجب ألا يكون أكبر من :max.',
        'string'  => 'حقل :attribute يجب ألا يكون أكثر من :max حرفاً.',
    ],
    'max_digits' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max أرقام.',
    'mimes'      => 'حقل :attribute يجب أن يكون ملفاً من نوع: :values.',
    'mimetypes'  => 'حقل :attribute يجب أن يكون ملفاً من نوع: :values.',
    'min'        => [
        'array'   => 'حقل :attribute يجب أن يحتوي على الأقل :min عناصر.',
        'file'    => 'حقل :attribute يجب أن يكون على الأقل :min كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون على الأقل :min.',
        'string'  => 'حقل :attribute يجب أن يكون على الأقل :min حرفاً.',
    ],
    'min_digits'       => 'حقل :attribute يجب أن يحتوي على الأقل :min أرقام.',
    'missing'          => 'حقل :attribute يجب أن يكون غير موجود.',
    'missing_if'       => 'حقل :attribute يجب أن يكون غير موجود عندما يكون :other بقيمة :value.',
    'missing_unless'   => 'حقل :attribute يجب أن يكون غير موجود ما لم يكن :other بقيمة :value.',
    'missing_with'     => 'حقل :attribute يجب أن يكون غير موجود عندما يكون :values موجوداً.',
    'missing_with_all' => 'حقل :attribute يجب أن يكون غير موجود عندما تكون :values موجودة.',
    'multiple_of'      => 'حقل :attribute يجب أن يكون من مضاعفات :value.',
    'not_in'           => 'القيمة المختارة لـ :attribute غير صالحة.',
    'not_regex'        => 'صيغة حقل :attribute غير صالحة.',
    'numeric'          => 'حقل :attribute يجب أن يكون رقماً.',
    'password'         => [
        'letters'       => 'حقل :attribute يجب أن يحتوي على حرف واحد على الأقل.',
        'mixed'         => 'حقل :attribute يجب أن يحتوي على حرف كبير وحرف صغير على الأقل.',
        'numbers'       => 'حقل :attribute يجب أن يحتوي على رقم واحد على الأقل.',
        'symbols'       => 'حقل :attribute يجب أن يحتوي على رمز واحد على الأقل.',
        'uncompromised' => 'قيمة :attribute المعطاة ظهرت في تسريب بيانات. يرجى اختيار :attribute مختلف.',
    ],
    'present'              => 'حقل :attribute يجب أن يكون موجوداً.',
    'prohibited'           => 'حقل :attribute محظور.',
    'prohibited_if'        => 'حقل :attribute محظور عندما يكون :other بقيمة :value.',
    'prohibited_unless'    => 'حقل :attribute محظور ما لم يكن :other ضمن :values.',
    'prohibits'            => 'حقل :attribute يمنع وجود :other.',
    'regex'                => 'صيغة حقل :attribute غير صالحة.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_array_keys'  => 'حقل :attribute يجب أن يحتوي على مدخلات لـ: :values.',
    'required_if'          => 'حقل :attribute مطلوب عندما يكون :other بقيمة :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
    'required_unless'      => 'حقل :attribute مطلوب ما لم يكن :other ضمن :values.',
    'required_with'        => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_with_all'    => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without'     => 'حقل :attribute مطلوب عندما لا يكون :values موجوداً.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يكون أي من :values موجوداً.',
    'same'                 => 'حقل :attribute يجب أن يطابق :other.',
    'size'                 => [
        'array'   => 'حقل :attribute يجب أن يحتوي على :size عناصر.',
        'file'    => 'حقل :attribute يجب أن يكون :size كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون :size.',
        'string'  => 'حقل :attribute يجب أن يكون :size حرفاً.',
    ],
    'starts_with' => 'حقل :attribute يجب أن يبدأ بأحد القيم التالية: :values.',
    'string'      => 'حقل :attribute يجب أن يكون نصاً.',
    'timezone'    => 'حقل :attribute يجب أن يكون منطقة زمنية صالحة.',
    'unique'      => 'قيمة :attribute مستخدمة بالفعل.',
    'uploaded'    => 'فشل رفع :attribute.',
    'uppercase'   => 'حقل :attribute يجب أن يكون بأحرف كبيرة.',
    'url'         => 'حقل :attribute يجب أن يكون رابطاً صالحاً.',
    'ulid'        => 'حقل :attribute يجب أن يكون ULID صالح.',
    'uuid'        => 'حقل :attribute يجب أن يكون UUID صالح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [],

];
