<?php
//
// kj_download_speed_limit, its guide on the help page of the control panel
// Arabic
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
// The keys are the ones of help_en.php, a key that is missing here is shown in English.
//  - names in <strong> are written as the control panel shows them, the words of Kleeja are in lang/ar/
//  - a <code> that begins or ends with a symbol has dir="ltr", or the symbol moves to the other side
//

return [
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_TITLE' => 'تحديد سرعة التحميل',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_INTRO' =>
        'حدّد أعلى سرعة تُحمِّل بها كل مجموعة الملفات، لتوفير الباندويث في خادمك. يمكنك مثلاً منح الزوار سرعة معتدلة، والسماح لأعضائك بتحميل أسرع.',

    //
    // what the plugin does
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_1' =>
        'تضيف <strong>الحد الأقصى لسرعة التحميل</strong> إلى <strong>تعديل البيانات</strong> في كل مجموعة، بالكيلوبايت في الثانية. وتبدأ كل المجموعات بالسرعة <code>0</code>، فلا تُحدّ سرعة أي مجموعة حتى تحددها أنت.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_2' =>
        'ترسل كل ملف تقدّمه كليجا بسرعة مجموعة الزائر: الملفات المحمّلة والصور والمصغرات.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_3' => 'السرعة <code>0</code> تلغي الحد في تلك المجموعة.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_4' => 'تبدأ المجموعة الجديدة بسرعة المجموعة التي تنسخ إعداداتها منها.',

    //
    // how to set the speed of a group
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_TITLE' => 'حدّد سرعة مجموعة',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_1' => 'افتح <strong>الأعضاء والمجموعات</strong>.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_2' => 'اضغط <strong>تعديل البيانات</strong> على المجموعة، مثل الزوار.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_3' =>
        'اكتب السرعة في <strong>الحد الأقصى لسرعة التحميل</strong> بالكيلوبايت في الثانية (1024 كيلوبايت في الثانية = 1 ميقابايت في الثانية)، أو <code>0</code> لإلغاء الحد.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_4' =>
        'اضغط <strong>موافق</strong>. تُطبَّق السرعة الجديدة على عمليات التحميل التي تبدأ بعد ذلك.',

    //
    // common questions
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_1' => 'ما السرعة التي أختارها؟',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_1' =>
        'يعتمد ذلك على خادمك وعلى أحجام ملفاتك. بسرعة 100 كيلوبايت في الثانية يُحمَّل ملف حجمه 10 ميقابايت في دقيقتين تقريبًا، وبسرعة 500 كيلوبايت في الثانية في 20 ثانية تقريبًا. ابدأ بسرعة سخية، واخفضها إن استهلك خادمك باندويث أكثر من اللازم.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_2' => 'هل السرعة لكل زائر أم للموقع كله؟',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_2' =>
        'لكل عملية تحميل. فالزائر الذي يحمّل ملفين معًا يحصل على السرعة مرتين، وكذلك برنامج التحميل الذي يفتح عدة اتصالات للملف نفسه.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_3' => 'حدّدت سرعة، لكن التحميل لم يصبح أبطأ. لماذا؟',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_3' =>
        'لا تحدّ الإضافة إلا سرعة الملفات التي ترسلها كليجا بنفسها. فإذا كان <strong>شكل روابط الملفات</strong> أو <strong>شكل روابط الصور</strong> في <strong>اعدادات التحميل</strong> رابطًا مباشرًا، فخادم الويب هو من يرسل تلك الملفات، ولا تنطبق عليها أي سرعة. وكذلك إذا عرّف <code>config.php</code> الثابت <code>MAKE_DOPHP_301_HEADER</code>. تأكد أيضًا من أن الإضافة مفعّلة، ومن أنك غيّرت مجموعة الزائر نفسه: الزوار هم من لم يسجّلوا دخولهم.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_4' => 'تغيّرت سرعات مجموعاتي بعد تحديث الإضافة. لماذا؟',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_4' =>
        'قبل الإصدار 1.2 كانت الإضافة ترسل الملفات أسرع بنحو 3.3 مرات من الرقم المكتوب في الحقل. أما الإصدار 1.2 فيرسلها بالسرعة المكتوبة، ورفع السرعات التي حفظتها لتبقى عمليات التحميل بالسرعة التي كانت عليها: أصبحت 30 مثلاً 100. اخفض الرقم إن أردت السرعة التي كان يعرضها من قبل.',

    //
    // beside the guide
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_1' => 'امنح الزوار سرعة أقل من الأعضاء، فالتحميل الأسرع سبب وجيه للتسجيل.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_2' => 'أبقِ سرعة المسؤولين <code>0</code>، حتى لا يبطئك الحد أبدًا.',

    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_WARNING_1' =>
        'تشغل كل عملية تحميل عملية PHP واحدة في خادمك حتى تنتهي، والتحميل البطيء يستمر مدة أطول. وفي موقع مزدحم، قد تستنفد السرعة المنخفضة جدًا هذه العمليات وتبطئ الموقع كله.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_WARNING_2' =>
        'تُرسل الصور والمصغرات أيضًا بسرعة المجموعة، فالسرعة المنخفضة جدًا تبطئ تحميل الصفحات التي تعرض كثيرًا منها.',

    //
    // in the guide of the groups, whose settings the plugin adds to
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_NOTE' =>
        'تضيف إضافة <strong>تحديد سرعة التحميل</strong> سرعة التحميل إلى <strong>تعديل البيانات</strong> في كل مجموعة. <a href="#help-kj_download_speed_limit">اقرأ دليلها</a>.',
];
