<?php

use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManagerStatic as Image;

function uploadMediaTele($file)
{
    $target_url = "https://telegra.ph/upload";
    $file_name_with_full_path = $file;
    if (function_exists('curl_file_create')) { // php 5.5+
        $cFile = curl_file_create($file_name_with_full_path);
    } else { // 
        $cFile = '@' . realpath($file_name_with_full_path);
    }
    $post = array('extra_info' => '123456', 'file_contents' => $cFile);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode(
        $res,
        true
    );
    if (isset($res[0]['src'])) {
        return 'https://telegra.ph' . $res[0]['src'];
    }
}
return [

    // All the sections for the settings page
    'sections' => [
        'app' => [
            'title' => 'General Settings',
            'descriptions' => 'Application general settings.', // (optional)
            'icon' => 'icon icon-cog', // (optional)

            'inputs' => [
                [
                    'name' => 'app_name', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'App Name', // label for input
                    // optional properties
                    'placeholder' => 'Application Name', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'rules' => 'required|min:2|max:20', // validation rules for this input
                    'value' => 'Ari Store', // any default value
                    'hint' => 'You can set the app name here' // help block text for input
                ],
                [
                    'name'  =>  'company_name',
                    'type'  =>  'text',
                    'label' =>  'Company Name',
                    'placeholder' => 'Company name',
                    'class' =>  'form-control',
                    'style' =>  '',
                    'rules' => 'required|min:2|max:20', // validation rules for this input
                    'value' => 'Laskarmedia', // any default value
                    'hint'  =>  'Put your company name here to be included on terms of condition'
                ],
                [
                    'name' => 'description',
                    'type'  =>  'textarea',
                    'label' =>  'Description',
                    'placeholder'   =>  'Description',
                    'class' =>  'form-control',
                    'style' =>  '',
                    'rules' =>  '',
                    'hint'  =>  'Description about your website'
                ],
                [
                    'name'  => 'server_img',
                    'type'  => 'boolean',
                    'label' => 'Server Image to telegra.ph',
                    'hint'  =>  'Upload all images to telegra.ph',
                    'value' => false,
                    'class' => 'w-auto form-control',
                    // optional fields
                    'options' => [
                        '1' => 'Yes',
                        '0' => 'No',
                    ],
                ],
                [
                    'name' => 'logo',
                    'type' => 'image',
                    'label' => 'Upload logo',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    // 'disk' => 'public', // which disk you want to upload
                    'path' => 'app', // path on the disk,
                    'preview_class' => 'thumbnail',
                    'preview_style' => 'height:40px',
                    'mutator'   => function ($value, $key) {
                        $image = request()->file($key);

                        if ($image) {
                            $namaFile = $image->getClientOriginalName();
                            $namaFile = time() . $namaFile;
                            $image->move(public_path() . "/assets/img/settings", $namaFile);
                            $thumbnailPath = URL::to("assets/img/settings/$namaFile");
                            if (setting('server_img')) {
                                $thumbnailPath = uploadMediaTele(public_path() . "/assets/img/settings/$namaFile");
                                unlink(public_path() . "/assets/img/settings/$namaFile");
                            }
                            return $thumbnailPath;
                        }
                    },
                ],
                [
                    'name' => 'favicon',
                    'type' => 'image',
                    'label' => 'Upload Favicon',
                    'hint' => 'Must be an image with size 32x32',
                    'rules' => 'image|max:500',
                    // 'disk' => 'public',
                    // 'path' => 'app',
                    'preview_class' => 'thumbnail',
                    'preview_style' => 'height:40px',
                    'mutator'   => function ($value, $key) {
                        $image = request()->file($key);

                        if ($image) {
                            $namaFile = $image->getClientOriginalName();
                            $namaFile = time() . $namaFile;
                            $image->move(public_path() . "/assets/img/settings", $namaFile);
                            $thumbnailPath = URL::to("assets/img/settings/$namaFile");
                            if (setting('server_img')) {
                                $thumbnailPath = uploadMediaTele(public_path() . "/assets/img/settings/$namaFile");
                                unlink(public_path() . "/assets/img/settings/$namaFile");
                            }
                            return $thumbnailPath;
                        }
                    }
                ],
            ]
        ],
        'g-watermark' => [
            'title' => 'Watermark',
            'descriptions' => 'Watermark settings.', // (optional)
            'icon' => 'icon icon-cog', // (optional)
            'inputs'    => [
                [
                    'name' => 'use_watermark',
                    'type' => 'boolean',
                    'label' => 'Use Watermark',
                    'hint' => 'Use watermark on all images',
                    'value' => false,
                    'class' => 'w-auto form-control',
                    // optional fields
                    'options' => [
                        '1' => 'Yes',
                        '0' => 'No',
                    ],
                ],
                [
                    'name' => 'watermark',
                    'type' => 'image',
                    'label' => 'Upload Watermark',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    // 'disk' => 'public', // which disk you want to upload
                    'path' => 'app', // path on the disk,
                    'preview_class' => 'thumbnail',
                    'preview_style' => 'height:40px',
                    'mutator'   => function ($value, $key) {
                        $image = request()->file($key);

                        if ($image) {
                            $namaFile = $image->getClientOriginalName();
                            $namaFile = time() . $namaFile;
                            $image->move(public_path() . "/assets/img/settings", $namaFile);
                            $thumbnailPath = URL::to("assets/img/settings/$namaFile");
                            if (setting('server_img')) {
                                $thumbnailPath = uploadMediaTele(public_path() . "/assets/img/settings/$namaFile");
                                unlink(public_path() . "/assets/img/settings/$namaFile");
                            }
                            return $thumbnailPath;
                        }
                    },
                ],
                [
                    'name' => 'watermark_position',
                    'type' => 'select',
                    'label' => 'Watermark Position',
                    'hint' => 'Select watermark position',
                    'rules' => 'required',
                    'class' => 'form-control',
                    'style' => '',
                    'options' => [
                        'top-left' => 'Top Left',
                        'top-right' => 'Top Right',
                        'bottom-left' => 'Bottom Left',
                        'bottom-right' => 'Bottom Right',
                        'center' => 'Center',
                    ],
                ],
                [
                    'name' => 'watermark_opacity',
                    'type' => 'number',
                    'label' => 'Watermark Opacity',
                    'hint' => 'Set watermark opacity',
                    'rules' => 'required|numeric|min:0|max:100',
                    'class' => 'form-control',
                    'style' => '',
                    'value' => 50,
                ],
                [
                    'name'  => 'watermark_x',
                    'type'  => 'number',
                    'label' => 'Watermark X',
                    'hint'  => 'Set watermark x',
                    'rules' => 'required|numeric|min:0|max:100',
                    'class' => 'form-control',
                    'style' => '',
                    'value' => 10,
                ],
                [
                    'name' => 'watermark_y',
                    'type' => 'number',
                    'label' => 'Watermark Y',
                    'hint' => 'Set watermark y',
                    'rules' => 'required|numeric|min:0|max:100',
                    'class' => 'form-control',
                    'style' => '',
                    'value' => 10,
                ]
            ]
        ],
        // 'mutasi' => [
        //     'title' => 'Get Mutation BCA',
        //     'descriptions' => 'Get mutation records every 10 minutes.',
        //     'icon' => 'icon icon-credit-card',
        //     'inputs'    => [
        //         [
        //             'name' => 'bca_username',
        //             'type' => 'text',
        //             'label' => 'Username',
        //             'placeholder' => 'Username IBank BCA',
        //         ],
        //         [
        //             'name' => 'bca_password',
        //             'type' => 'text',
        //             'label' => 'Password',
        //             'placeholder' => 'Password IBank BCA',
        //         ]
        //     ]
        // ],
        // 'qris'  => [
        //     'title' => 'QRIS with Bukukas',
        //     'descriptions'  => 'You need to fill token with bukukas token. To login into bukukas, go to Payment gateway menu',
        //     ''
        // ],
        // 'fb_oauth'  => [
        //     'title' => 'Settings Facebook OAUTH',
        //     'descriptions'   => 'Enabling user for login via facebook oauth. For filling these you need to setup you facebook application here https://developers.facebook.com/apps',
        //     'icon'  => 'fab fa-facebook-square indigo accent-4',
        //     'inputs'    => [
        //         [
        //             'name'  => 'fb_id',
        //             'type'  => 'text',
        //             'label' => 'Facebook ID',
        //             'placeholder' => 'Facebook Client ID',
        //         ],
        //         [
        //             'name'  => 'fb_secret',
        //             'type'  => 'text',
        //             'label' => 'Facebook secret',
        //             'placeholder' => 'Facebook Client Secret',
        //         ]
        //     ]
        // ],
        'g-captcha'  => [
            'title' => 'Settings Google ReCaptcha',
            'descriptions'   => 'Get a g-captcha sitekey and secret key here: https://www.google.com/recaptcha/admin#list',
            'icon'  => 'fab fa-google-square indigo accent-4',
            'inputs'    => [
                [
                    'name'  => 'captcha_sitekey',
                    'type'  => 'text',
                    'label' => 'Site Key',
                    'placeholder' => 'Recaptcha Site Key',
                ],
                [
                    'name'  => 'captcha_secret',
                    'type'  => 'text',
                    'label' => 'Secret Key',
                    'placeholder' => 'Recaptcha Secret Key',
                ]
            ]
        ],
        'whatsapp'  => [
            'title' => 'Whatsapp Gateway Setting',
            'descriptions'  => 'Setting a whatsapp gateway host',
            'inputs'    => [
                [
                    'name'  => 'use_whatsapp',
                    'type'  => 'checkbox',
                    'label' => 'Use Whatsapp Gateway',
                    'hint'  => 'Check this if you want to use whatsapp gateway',
                    'value' => 1,
                ],
                [
                    'name'  => 'wahost',
                    'type'  => 'text',
                    'label' => 'Whatsapp Host',
                    'placeholder'   => 'https://ari-wagate.herokuapp.com',
                    'value' => 'https://ari-wagate.herokuapp.com'
                ],
                [
                    'name'  => 'wagroup',
                    'type'  => 'text',
                    'label' => 'Whatsapp Group',
                    'placeholder' => '0-0@g.us',
                    'hint'  => 'Sent notification to group. To get id, go to whatsapp gateway'
                ]
            ]
        ],
        'autoorder' => [
            'title' => 'Auto Order API URL',
            'descriptions'  => 'Backend auto order api url',
            'inputs'    => [
                [
                    'name'  => 'autoapi',
                    'type'  => 'text',
                    'label' => 'Auto API URL',
                    'placeholder' => 'http://xxx',
                    'value' => "https://ari-smile.herokuapp.com"
                ]
            ]
        ],
        'anticaptcha' => [
            'title' => "Anti Captcha",
            'descriptions' => "Avoid captcha for auto order bot",
            'inputs' => [
                [
                    'name'  => '2captcha',
                    'type'  => 'text',
                    'label' => '2Captcha Apikey',
                    'placeholder' => 'Apikey',
                ],
                [
                    'name'  => 'anticaptcha',
                    'type'  => 'text',
                    'label' => 'Anti-captcha Apikey',
                    'placeholder' => 'Apikey',
                ]
            ]
        ]
        // 'email' => [
        //     'title' => 'Email Settings',
        //     'descriptions' => 'How app email will be sent.',
        //     'icon' => 'fa fa-envelope',

        //     'inputs' => [
        //         [
        //             'name' => 'from_email',
        //             'type' => 'email',
        //             'label' => 'From Email',
        //             'placeholder' => 'Application from email',
        //             'rules' => 'required|email',
        //         ],
        //         [
        //             'name' => 'from_name',
        //             'type' => 'text',
        //             'label' => 'Email from Name',
        //             'placeholder' => 'Email from Name',
        //         ]
        //     ]
        // ]
    ],

    // Setting page url, will be used for get and post request
    'url' => '/admin/settings', //'/settings',

    // Any middleware you want to run on above route
    'middleware' => [],

    // View settings
    'setting_page_view' => 'admin/settings', //'app_settings::settings_page',
    'flash_partial' => 'app_settings::_flash',

    // Setting section class setting
    'section_class' => 'card mb-3 shadow2',
    'section_heading_class' => 'card-header',
    'section_body_class' => 'card-body',

    // Input wrapper and group class setting
    'input_wrapper_class' => 'form-group',
    'input_class' => 'form-control',
    'input_error_class' => 'has-error',
    'input_invalid_class' => 'is-invalid',
    'input_hint_class' => 'form-text text-muted',
    'input_error_feedback_class' => 'text-danger',

    // Submit button
    'submit_btn_text' => 'Save Settings',
    'submit_success_message' => 'Settings has been saved.',

    // Remove any setting which declaration removed later from sections
    'remove_abandoned_settings' => false,

    // Controller to show and handle save setting
    'controller' => '\QCod\AppSettings\Controllers\AppSettingController',

    // settings group
    'setting_group' => function () {
        // return 'user_'.auth()->id();
        return 'default';
    }
];
