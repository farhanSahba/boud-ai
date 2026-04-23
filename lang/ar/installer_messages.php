<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'  => __('أداة التثبيت'),
    'next'   => __('الخطوة التالية'),
    'back'   => __('السابق'),
    'finish' => __('تثبيت'),
    'forms'  => [
        'errorTitle' => __('حدثت الأخطاء التالية:'),
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => __('مرحباً'),
        'title'         => __('أداة التثبيت'),
        'message'       => __('معالج التثبيت والإعداد السهل.'),
        'next'          => __('فحص المتطلبات'),
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => __('الخطوة 1 | متطلبات الخادم'),
        'title'         => __('متطلبات الخادم'),
        'next'          => __('فحص الصلاحيات'),
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => __('الخطوة 2 | الصلاحيات'),
        'title'         => __('الصلاحيات'),
        'next'          => __('إعداد البيئة'),
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle'  => __('الخطوة 3 | إعدادات البيئة'),
            'title'          => __('إعدادات البيئة'),
            'desc'           => __('يرجى اختيار طريقة إعداد ملف <code>.env</code> للتطبيق.'),
            'wizard-button'  => __('إعداد بالمعالج'),
            'classic-button' => __('محرر النصوص الكلاسيكي'),
        ],
        'wizard' => [
            'templateTitle' => __('الخطوة 3 | إعدادات البيئة | المعالج الموجه'),
            'title'         => __('معالج <code>.env</code> الموجه'),
            'tabs'          => [
                'environment' => __('البيئة'),
                'database'    => __('قاعدة البيانات'),
                'application' => __('التطبيق'),
            ],
            'form' => [
                'name_required'                      => __('اسم البيئة مطلوب.'),
                'app_name_label'                     => __('اسم التطبيق'),
                'app_name_placeholder'               => __('اسم التطبيق'),
                'app_environment_label'              => __('بيئة التطبيق'),
                'app_environment_label_local'        => __('محلي'),
                'app_environment_label_developement' => __('تطوير'),
                'app_environment_label_qa'           => __('اختبار الجودة'),
                'app_environment_label_production'   => __('إنتاج'),
                'app_environment_label_other'        => __('أخرى'),
                'app_environment_placeholder_other'  => __('أدخل بيئتك...'),
                'app_debug_label'                    => __('وضع التصحيح'),
                'app_debug_label_true'               => __('مفعّل'),
                'app_debug_label_false'              => __('معطّل'),
                'app_log_level_label'                => __('مستوى السجل'),
                'app_log_level_label_debug'          => __('تصحيح'),
                'app_log_level_label_info'           => __('معلومات'),
                'app_log_level_label_notice'         => __('إشعار'),
                'app_log_level_label_warning'        => __('تحذير'),
                'app_log_level_label_error'          => __('خطأ'),
                'app_log_level_label_critical'       => __('حرج'),
                'app_log_level_label_alert'          => __('تنبيه'),
                'app_log_level_label_emergency'      => __('طوارئ'),
                'app_url_label'                      => __('رابط التطبيق'),
                'app_url_placeholder'                => __('رابط التطبيق'),
                'db_connection_failed'               => __('تعذر الاتصال بقاعدة البيانات.'),
                'db_connection_label'                => __('اتصال قاعدة البيانات'),
                'db_connection_label_mysql'          => __('mysql'),
                'db_connection_label_sqlite'         => __('sqlite'),
                'db_connection_label_pgsql'          => __('pgsql'),
                'db_connection_label_sqlsrv'         => __('sqlsrv'),
                'db_host_label'                      => __('خادم قاعدة البيانات'),
                'db_host_placeholder'                => __('خادم قاعدة البيانات'),
                'db_port_label'                      => __('منفذ قاعدة البيانات'),
                'db_port_placeholder'                => __('منفذ قاعدة البيانات'),
                'db_name_label'                      => __('اسم قاعدة البيانات'),
                'db_name_placeholder'                => __('اسم قاعدة البيانات'),
                'db_username_label'                  => __('اسم مستخدم قاعدة البيانات'),
                'db_username_placeholder'            => __('اسم مستخدم قاعدة البيانات'),
                'db_password_label'                  => __('كلمة مرور قاعدة البيانات'),
                'db_password_placeholder'            => __('كلمة مرور قاعدة البيانات'),

                'app_tabs' => [
                    'more_info'                     => __('معلومات إضافية'),
                    'broadcasting_title'            => __('البث، التخزين المؤقت، الجلسات، وقائمة الانتظار'),
                    'broadcasting_label'            => __('مشغل البث'),
                    'broadcasting_placeholder'      => __('مشغل البث'),
                    'cache_label'                   => __('مشغل التخزين المؤقت'),
                    'cache_placeholder'             => __('مشغل التخزين المؤقت'),
                    'session_label'                 => __('مشغل الجلسات'),
                    'session_placeholder'           => __('مشغل الجلسات'),
                    'queue_label'                   => __('مشغل قائمة الانتظار'),
                    'queue_placeholder'             => __('مشغل قائمة الانتظار'),
                    'redis_label'                   => __('مشغل Redis'),
                    'redis_host'                    => __('خادم Redis'),
                    'redis_password'                => __('كلمة مرور Redis'),
                    'redis_port'                    => __('منفذ Redis'),
                    'mail_label'                    => __('البريد'),
                    'mail_driver_label'             => __('مشغل البريد'),
                    'mail_driver_placeholder'       => __('مشغل البريد'),
                    'mail_host_label'               => __('خادم البريد'),
                    'mail_host_placeholder'         => __('خادم البريد'),
                    'mail_port_label'               => __('منفذ البريد'),
                    'mail_port_placeholder'         => __('منفذ البريد'),
                    'mail_username_label'           => __('اسم مستخدم البريد'),
                    'mail_username_placeholder'     => __('اسم مستخدم البريد'),
                    'mail_password_label'           => __('كلمة مرور البريد'),
                    'mail_password_placeholder'     => __('كلمة مرور البريد'),
                    'mail_encryption_label'         => __('تشفير البريد'),
                    'mail_encryption_placeholder'   => __('تشفير البريد'),
                    'pusher_label'                  => __('Pusher'),
                    'pusher_app_id_label'           => __('معرف تطبيق Pusher'),
                    'pusher_app_id_palceholder'     => __('معرف تطبيق Pusher'),
                    'pusher_app_key_label'          => __('مفتاح تطبيق Pusher'),
                    'pusher_app_key_palceholder'    => __('مفتاح تطبيق Pusher'),
                    'pusher_app_secret_label'       => __('كلمة سر تطبيق Pusher'),
                    'pusher_app_secret_palceholder' => __('كلمة سر تطبيق Pusher'),
                ],
                'buttons' => [
                    'setup_database'    => __('إعداد قاعدة البيانات'),
                    'setup_application' => __('إعداد التطبيق'),
                    'install'           => __('تثبيت'),
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => __('الخطوة 3 | إعدادات البيئة | المحرر الكلاسيكي'),
            'title'         => __('محرر البيئة الكلاسيكي'),
            'save'          => __('حفظ ملف .env'),
            'back'          => __('استخدام المعالج'),
            'install'       => __('حفظ وتثبيت'),
        ],
        'success' => __('تم حفظ إعدادات ملف .env بنجاح.'),
        'errors'  => __('تعذر حفظ ملف .env، يرجى إنشاؤه يدوياً.'),
    ],

    'install' => __('تثبيت'),

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => __('تم تثبيت التطبيق بنجاح في '),
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title'         => __('اكتمل التثبيت'),
        'templateTitle' => __('اكتمل التثبيت'),
        'finished'      => __('تم تثبيت التطبيق بنجاح.'),
        'migration'     => __('مخرجات الترحيل والبذر:'),
        'console'       => __('مخرجات وحدة التحكم:'),
        'log'           => __('سجل التثبيت:'),
        'env'           => __('ملف .env النهائي:'),
        'exit'          => __('اضغط هنا للخروج'),
    ],

    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'أداة التحديث',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'مرحباً بك في أداة التحديث',
            'message' => 'مرحباً بك في معالج التحديث.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'           => __('نظرة عامة'),
            'message'         => __('يوجد تحديث واحد.|يوجد :number تحديثات.'),
            'install_updates' => __('تثبيت التحديثات'),
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title'    => __('تم'),
            'finished' => __('تم تحديث قاعدة بيانات التطبيق بنجاح.'),
            'exit'     => __('اضغط هنا للخروج'),
        ],

        'log' => [
            'success_message' => __('تم تحديث التطبيق بنجاح في '),
        ],
    ],
];
