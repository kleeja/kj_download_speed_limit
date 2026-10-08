<?php
//
// kj_download_speed_limit, its guide on the help page of the control panel
// English
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
//  - a list is numbered: KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_1, KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_2 ... it ends at the first
//    missing number, so an item can be added or removed without touching the code
//  - KJ_DOWNLOAD_SPEED_LIMIT_HELP_{LIST}_TITLE is the title of the list, a list without it takes the title that Kleeja
//    gives its type
//  - questions and answers are KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_1 and KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_1
//  - names in <strong> are written as the control panel shows them, the words of Kleeja are in lang/en/
//

return [
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_TITLE' => 'Download Speed Limit',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_INTRO' =>
        'Set the highest speed at which each group downloads files, to save the bandwidth of your server. For example, give Guests a moderate speed, and let your members download faster.',

    //
    // what the plugin does
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_1' =>
        'Adds <strong>Download speed limit</strong> to <strong>Edit data</strong> of every group, in kilobytes per second. Every group starts at <code>0</code>, so no group has a limit until you set one.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_2' =>
        'Sends every file that Kleeja serves at the speed of the visitor\'s group: downloads, images and thumbnails.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_3' => 'A speed of <code>0</code> removes the limit for that group.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FEATURE_4' =>
        'A new group starts with the speed of the group that you copy its settings from.',

    //
    // how to set the speed of a group
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_TITLE' => 'Set the speed of a group',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_1' => 'Open <strong>Users &amp; Groups</strong>.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_2' => 'Select <strong>Edit data</strong> on the group, for example Guests.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_3' =>
        'Type the speed in <strong>Download speed limit</strong>, in kilobytes per second (1024 KB/s is 1 MB/s), or <code>0</code> for no limit.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_STEP_4' =>
        'Click <strong>Submit</strong>. The new speed applies to the downloads that start after it.',

    //
    // common questions
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_1' => 'Which speed should I choose?',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_1' =>
        'It depends on your server and on the size of your files. At 100 KB/s, a 10 MB file downloads in about 2 minutes, and at 500 KB/s in about 20 seconds. Start with a generous speed, and lower it if your server uses too much bandwidth.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_2' => 'Is the speed for each visitor, or for the whole site?',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_2' =>
        'For each download. A visitor who downloads two files at once gets the speed twice, and so does a download manager that opens several connections to one file.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_3' => 'I set a speed, but downloads are not slower. Why?',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_3' =>
        'The plugin limits only the files that Kleeja sends itself. When <strong>Files URLs form</strong> or <strong>Images URLs form</strong> in <strong>Upload settings</strong> is Direct, your web server sends those files, and no speed applies to them. The same is true when <code>config.php</code> defines <code>MAKE_DOPHP_301_HEADER</code>. Also check that the plugin is enabled, and that you changed the group of the visitor: Guests are the visitors who are not signed in.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_Q_4' => 'After I updated the plugin, the speeds of my groups changed. Why?',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_FAQ_A_4' =>
        'Before version 1.2, the plugin sent files about 3.3 times faster than the number in the field. Version 1.2 sends them at the number, and raised the speeds that you had saved, so that your downloads keep the speed they had: 30 became 100. Lower a number if you want the speed that it showed before.',

    //
    // beside the guide
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_1' =>
        'Give Guests a lower speed than Users. Faster downloads are a good reason to register.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_TIP_2' => 'Leave Admins at <code>0</code>, so that the limit never slows you down.',

    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_WARNING_1' =>
        'Each download keeps one PHP process of your server busy until it ends, and a slow download lasts longer. On a busy site, a very low speed can use up these processes and slow down the whole site.',
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_WARNING_2' =>
        'Images and thumbnails are sent at the speed of the group too, so a very low speed makes the pages that show many of them load slowly.',

    //
    // in the guide of the groups, whose settings the plugin adds to
    //
    'KJ_DOWNLOAD_SPEED_LIMIT_HELP_NOTE' =>
        'The <strong>Download Speed Limit</strong> plugin adds a download speed to <strong>Edit data</strong> of every group. <a href="#help-kj_download_speed_limit">Read its guide</a>.',
];
