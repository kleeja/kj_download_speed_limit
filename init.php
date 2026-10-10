<?php
// Kleeja Plugin
// kj_download_speed_limit
// Version: 1.2
// Developer: Kleeja team

// Prevent illegal run
if (!defined('IN_PLUGINS_SYSTEM')) {
    exit();
}

// Plugin Basic Information
$kleeja_plugin['kj_download_speed_limit']['information'] = [
    // The casual name of this plugin, anything can a human being understands
    'plugin_title' => [
        'en' => 'Download Speed Limit',
        'ar' => 'تحديد سرعة التحميل',
    ],
    // Who wrote this plugin?
    'plugin_developer' => 'Kleeja.net',
    //settings page, if there is one (what after ? like cp=j_plugins)
    'settings_page' => 'cp=g_users',
    // This plugin version
    'plugin_version' => '1.2',
    // Explain what is this plugin, why should I use it?
    'plugin_description' => [
        'en' =>
            'Set the highest download speed of each group, in kilobytes per second, to save the bandwidth of your server.',
        'ar' => 'حدّد أعلى سرعة تحميل لكل مجموعة، بالكيلوبايت في الثانية، لتوفير الباندويث في خادمك.',
    ],
    // Min version of Kleeja that's requiered to run this plugin
    'plugin_kleeja_version_min' => '4.0.0',
    // Max version of Kleeja that support this plugin, use 0 for unlimited
    'plugin_kleeja_version_max' => '4.9',
    // Should this plugin run before others?, 0 is normal, and higher number has high priority
    'plugin_priority' => 0,
];

//after installation message, you can remove it, it's not requiered
$kleeja_plugin['kj_download_speed_limit']['first_run']['ar'] = "
تضيف هذه الإضافة حقل «الحد الأقصى لسرعة التحميل» إلى إعدادات كل مجموعة، ولا تحدّ سرعة أي مجموعة حتى تحددها أنت.
لتحديد سرعة مجموعة، اضغط «تعديل البيانات» عليها في صفحة إدارة المجموعات، واكتب السرعة بالكيلوبايت في الثانية، أو 0 لإلغاء الحد.
<br>
<a href='./index.php?cp=g_users'>إدارة المجموعات</a> -
<a href='./index.php?cp=s_help#help-kj_download_speed_limit'>دليل الإضافة</a> -
<a href='https://github.com/kleeja/kj_download_speed_limit/issues' target='_blank' rel='noopener'>الإبلاغ عن مشكلة</a>
";

$kleeja_plugin['kj_download_speed_limit']['first_run']['en'] = "
This plugin adds a Download speed limit field to the settings of every group, and no group has a limit until you set one.
To set the speed of a group, select Edit data on it in Groups Management, and type the speed in KB/s, or 0 for no limit.
<br>
<a href='./index.php?cp=g_users'>Groups Management</a> -
<a href='./index.php?cp=s_help#help-kj_download_speed_limit'>Plugin guide</a> -
<a href='https://github.com/kleeja/kj_download_speed_limit/issues' target='_blank' rel='noopener'>Report a problem</a>
";

// Plugin Installation function
$kleeja_plugin['kj_download_speed_limit']['install'] = function ($plg_id) {
    $options = [];

    foreach (kj_download_speed_limit_configs() as $name => $setting) {
        $options[$name] = [
            'value' => $setting['value'],
            'html' => $setting['html'],
            'order' => $setting['order'],
            'plg_id' => $plg_id,
            'type' => 'groups',
        ];
    }

    add_config_r($options);

    foreach (kj_download_speed_limit_translations() as $lang_id => $words) {
        add_olang($words, $lang_id, $plg_id);
    }
};

// the words and the field of the setting are written again, so a new version brings its own (1.2 rewrote both),
// with queries of its own: add_olang(), delete_olang(), update_config() and delete_cache() run hooks,
// or need the groups, and the plugins are still loading.
// $kleeja_plugin isn't a global, Kleeja includes this file in a method, so the closure takes the information above with it
$kleeja_plugin['kj_download_speed_limit']['update'] = function ($old_version, $new_version) use ($kleeja_plugin) {
    global $SQL, $dbprefix;

    $result = $SQL->build([
        'SELECT' => 'plg_id',
        'FROM' => "{$dbprefix}plugins",
        'WHERE' => 'plg_name = :name',
        'BIND' => ['name' => 'kj_download_speed_limit'],
    ]);

    $row = $SQL->fetch_array($result);
    $plg_id = (int) ($row['plg_id'] ?? 0);
    $SQL->freeresult($result);

    //a plg_id of 0 would delete the words of the core and of every plugin
    if ($plg_id > 0) {
        $SQL->build([
            'DELETE' => "{$dbprefix}lang",
            'WHERE' => 'plg_id = :plg_id',
            'BIND' => ['plg_id' => $plg_id],
        ]);

        foreach (kj_download_speed_limit_translations() as $lang_id => $words) {
            foreach ($words as $word => $trans) {
                $SQL->build([
                    'INSERT' => 'word, trans, lang_id, plg_id',
                    'INTO' => "{$dbprefix}lang",
                    'VALUES' => ':word, :trans, :lang_id, :plg_id',
                    'BIND' => ['word' => $word, 'trans' => $trans, 'lang_id' => $lang_id, 'plg_id' => $plg_id],
                ]);
            }
        }
    }

    // the field of the setting on the settings of the groups, its place there, and its default value (1.2 made it 0,
    // no limit), the speed of each group is in groups_data and is kept
    foreach (kj_download_speed_limit_configs() as $name => $setting) {
        $SQL->build([
            'UPDATE' => "{$dbprefix}config",
            'SET' => '`option` = :option, display_order = :display_order, value = :value',
            'WHERE' => 'name = :name',
            'BIND' => [
                'option' => $setting['html'],
                'display_order' => $setting['order'],
                'value' => $setting['value'],
                'name' => $name,
            ],
        ]);
    }

    if (version_compare($old_version, '1.2', '<')) {
        kj_download_speed_limit_convert_speeds();

        // the developer and the description that the old versions were installed with,
        // the list of plugins shows them while the plugin is disabled
        $SQL->build([
            'UPDATE' => "{$dbprefix}plugins",
            'SET' => 'plg_author = :author, plg_dsc = :description',
            'WHERE' => 'plg_name = :name',
            'BIND' => [
                'author' => 'Kleeja.net',
                'description' => kleeja_html_encode(
                    $kleeja_plugin['kj_download_speed_limit']['information']['plugin_description']['en'],
                ),
                'name' => 'kj_download_speed_limit',
            ],
        ]);
    }

    // the cached words and settings. They are PHP files, and OPcache would keep running the old ones for a while,
    // or until PHP restarts when it doesn't check the files. Before a file is deleted,
    // OPcache finds a relative path only when the file exists
    $cached = array_merge(glob(PATH . 'cache/data_lang*.php') ?: [], [
        PATH . 'cache/data_config.php',
        PATH . 'cache/data_groups.php',
    ]);

    foreach ($cached as $file) {
        if (file_exists($file)) {
            if (function_exists('opcache_invalidate')) {
                @opcache_invalidate($file, true);
            }

            @unlink($file);
        }
    }
};

// Plugin Uninstallation, function to be called at unistalling
$kleeja_plugin['kj_download_speed_limit']['uninstall'] = function ($plg_id) {
    delete_config(array_keys(kj_download_speed_limit_configs()));

    //a plg_id of 0 would delete the words of the core and of every plugin
    if ((int) $plg_id > 0) {
        foreach (array_keys(kj_download_speed_limit_translations()) as $lang_id) {
            delete_olang(null, $lang_id, (int) $plg_id);
        }
    }
};

// Plugin functions
$kleeja_plugin['kj_download_speed_limit']['functions'] = [
    //the words of the plugin on the settings of the groups, in English for a language that has no translation of them
    'begin_admin_page' => function ($args) {
        $olang = (array) ($args['olang'] ?? []) + kj_download_speed_limit_translations()['en'];

        return compact('olang');
    },

    // a file that do.php sends: a download, an image or a thumbnail, at the speed of the group of the visitor
    'down_go_page' => function ($args) {
        global $config;

        $speed = (float) ($config['kj_download_speed_limit_number'] ?? 0);

        // 0, a negative number or a text is no limit
        if ($speed <= 0) {
            return;
        }

        // while TrottleLimit is defined, do.php pauses after every chunk that it sends,
        // so a chunk of what the speed sends during that pause keeps the download under the speed
        $chunksize = (int) max(
            1,
            min(KJ_DOWNLOAD_SPEED_LIMIT_MAX_CHUNK, round($speed * 1024 * KJ_DOWNLOAD_SPEED_LIMIT_PAUSE)),
        );

        if (!defined('TrottleLimit')) {
            define('TrottleLimit', true);
        }

        return compact('chunksize');
    },

    // the guide of the plugin on the help page of the control panel, its words are in language/help_{code}.php
    'admin_help_guides' => function ($args) {
        $help_guides = $args['help_guides'];
        $words = kj_download_speed_limit_help_words();

        // the name of the plugin is the key, so Kleeja knows that the plugin has its guide, and shows its icon.
        // The setting of the plugin is on the settings of each group, whose help button opens the guide of Kleeja,
        // so it has no 'page', and the guide of the groups links to it
        $help_guides['kj_download_speed_limit'] = [
            'group' => 'plugins',
            'title' => $words['KJ_DOWNLOAD_SPEED_LIMIT_HELP_TITLE'],
            'intro' => $words['KJ_DOWNLOAD_SPEED_LIMIT_HELP_INTRO'],
            'link' => './?cp=g_users',
            // tips and warnings are shown beside the others on wide screens
            'sections' => [
                kj_download_speed_limit_help_section($words, 'features', 'FEATURE'),
                kj_download_speed_limit_help_section($words, 'steps', 'STEP'),
                kj_download_speed_limit_help_section($words, 'faq', 'FAQ'),
                kj_download_speed_limit_help_section($words, 'tips', 'TIP'),
                kj_download_speed_limit_help_section($words, 'warnings', 'WARNING'),
            ],
        ];

        if (isset($help_guides['users'])) {
            $help_guides['users']['sections'][] = [
                'type' => 'text',
                'text' => $words['KJ_DOWNLOAD_SPEED_LIMIT_HELP_NOTE'],
            ];
        }

        return compact('help_guides');
    },
];

/**
 * special functions
 */

if (!function_exists('kj_download_speed_limit_configs')) {
    // the seconds that do.php pauses after each chunk of a file while TrottleLimit is defined
    define('KJ_DOWNLOAD_SPEED_LIMIT_PAUSE', 0.3);
    // the largest chunk, in bytes. do.php reads a whole chunk into memory, so a speed above about 27,000 KB/s
    // is sent at that speed
    define('KJ_DOWNLOAD_SPEED_LIMIT_MAX_CHUNK', 8388608);

    /**
     * the setting of the plugin, with the value that every group starts with (0, no limit), its place on the settings
     * of the groups (after the waiting period before downloads), and its field, which Kleeja gives the class form-control
     * @return array
     */
    function kj_download_speed_limit_configs()
    {
        return [
            'kj_download_speed_limit_number' => [
                'value' => '0',
                'order' => 24,
                'html' =>
                    '<div class="input-group w-100">' .
                    '<input type="number" id="kj_download_speed_limit_number" name="kj_download_speed_limit_number"' .
                    ' value="{con.kj_download_speed_limit_number}" min="0" step="1" inputmode="numeric" required' .
                    ' aria-describedby="kj_download_speed_limit_unit" />' .
                    '<span class="input-group-text" id="kj_download_speed_limit_unit">{olang.KJ_DOWNLOAD_SPEED_LIMIT_UNIT}</span>' .
                    '</div>',
            ],
        ];
    }

    /**
     * versions before 1.2 sent a download in chunks of the saved number of kilobytes, with a pause of 0.3 seconds
     * after each one, so the download ran about 3.3 times faster than the number. 1.2 sends it at the number,
     * and the saved numbers are raised to the speed that the downloads had, 30 becomes 100
     * @return void
     */
    function kj_download_speed_limit_convert_speeds()
    {
        global $SQL, $dbprefix;

        // the speed of each group, read before any of them is changed
        $speeds = [];

        $result = $SQL->build([
            'SELECT' => 'group_id, value',
            'FROM' => "{$dbprefix}groups_data",
            'WHERE' => 'name = :name',
            'BIND' => ['name' => 'kj_download_speed_limit_number'],
        ]);

        while ($row = $SQL->fetch_array($result)) {
            $speeds[$row['group_id']] = $row['value'];
        }

        $SQL->freeresult($result);

        foreach ($speeds as $group_id => $speed) {
            $speed = (float) $speed;

            // 0, a negative number or a text broke the downloads before 1.2, and is no limit now
            if ($speed <= 0) {
                continue;
            }

            $SQL->build([
                'UPDATE' => "{$dbprefix}groups_data",
                'SET' => 'value = :value',
                'WHERE' => 'name = :name AND group_id = :group_id',
                'BIND' => [
                    'value' => (string) max(1, round($speed / KJ_DOWNLOAD_SPEED_LIMIT_PAUSE)),
                    'name' => 'kj_download_speed_limit_number',
                    'group_id' => $group_id,
                ],
            ]);
        }
    }

    /**
     * the words of the guide on the help page, in the language of the admin,
     * a word that the translation misses is shown in English
     * @return array
     */
    function kj_download_speed_limit_help_words()
    {
        global $config;

        $words = (array) require __DIR__ . '/language/help_en.php';
        $language = preg_replace('/[^a-z0-9_-]/i', '', (string) ($config['language'] ?? ''));
        $translation = __DIR__ . "/language/help_{$language}.php";

        if ($language !== '' && $language !== 'en' && file_exists($translation)) {
            // in its own line, Prettier drops the brackets of (require $translation) + $words
            $translated = require $translation;
            $words = (array) $translated + $words;
        }

        return $words;
    }

    /**
     * a section of the guide from its numbered words, like KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_1, .._TIP_2 ..
     * its title, when it has its own, is KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_TITLE
     * @param  array  $words
     * @param  string $type  how Kleeja shows it: features, steps, tips, warnings or faq
     * @param  string $name  the name of its words, KJ_DOWNLOAD_SPEED_LIMIT_HELP_{name}_1
     * @return array
     */
    function kj_download_speed_limit_help_section($words, $type, $name)
    {
        $prefix = 'KJ_DOWNLOAD_SPEED_LIMIT_HELP_' . $name;
        $section = ['type' => $type, 'title' => $words[$prefix . '_TITLE'] ?? '', 'items' => []];

        for ($n = 1; isset($words[$prefix . ($type === 'faq' ? '_Q_' : '_') . $n]); $n++) {
            $section['items'][] =
                $type === 'faq'
                    ? ['q' => $words[$prefix . '_Q_' . $n], 'a' => $words[$prefix . '_A_' . $n] ?? '']
                    : $words[$prefix . '_' . $n];
        }

        return $section;
    }

    /**
     * the words of the plugin, they are added to the language table when it is installed or updated,
     * a <small> in the name of a setting is the hint under it
     * @return array
     */
    function kj_download_speed_limit_translations()
    {
        return [
            'en' => [
                'KJ_DOWNLOAD_SPEED_LIMIT_NUMBER' =>
                    'Download speed limit <small>The highest speed of each download for this group. Set it to 0 for no limit.</small>',
                'KJ_DOWNLOAD_SPEED_LIMIT_UNIT' => 'KB/s',
            ],
            'ar' => [
                'KJ_DOWNLOAD_SPEED_LIMIT_NUMBER' =>
                    'الحد الأقصى لسرعة التحميل <small>أعلى سرعة لكل عملية تحميل في هذه المجموعة. اكتب 0 لإلغاء الحد.</small>',
                'KJ_DOWNLOAD_SPEED_LIMIT_UNIT' => 'كيلوبايت/ثانية',
            ],
        ];
    }
}
