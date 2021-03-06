CodeIgniter Gettext
===================

[![Latest Stable Version](https://poser.pugx.org/joel-depiltech/codeigniter-gettext/v/stable.svg)](https://packagist.org/packages/joel-depiltech/codeigniter-gettext)
[![Build Status](https://scrutinizer-ci.com/g/joel-depiltech/codeigniter-gettext/badges/build.png?b=master)](https://scrutinizer-ci.com/g/joel-depiltech/codeigniter-gettext/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/joel-depiltech/codeigniter-gettext/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/joel-depiltech/codeigniter-gettext/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/joel-depiltech/codeigniter-gettext/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/joel-depiltech/codeigniter-gettext/?branch=master)
[![License](https://poser.pugx.org/joel-depiltech/codeigniter-gettext/license)](https://packagist.org/packages/joel-depiltech/codeigniter-gettext)

This is [CodeIgniter](https://codeigniter.com) PHP framework package for dealing with [Gettext](https://www.gnu.org/software/gettext/).

This package is a fork from [Marko Martivović](https://github.com/Marko-M/codeigniter-gettext) library.

Please use [Composer](https://getcomposer.org) to install it and include it as a package in your CodeIgniter application.

Instructions
------------

Please note that following steps assume that you have correctly installed gettext and configured Codeigniter on your server.

1. Use **composer** to install this package

`composer require joel-depiltech/codeigniter-gettext`

2. Add this **package** to auto-load packages array (application/config/autoload.php)

`$autoload['packages'] = array(FCPATH . 'vendor/joel-depiltech/codeigniter-gettext/src');`

or include it with Loader library

`$this->load->add_package_path(FCPATH . 'vendor/joel-depiltech/codeigniter-gettext/src');`

3. Add default **configuration** file to auto-load config array (application/config/autoload.php)

`$autoload['config'] = array('gettext');`

or include it with Loader library

`$this->load->config('gettext');`

4. Add the **library** to auto-load library array (application/config/autoload.php)

`$autoload['library'] = array('gettext');`

or include it with Loader library

`$this->load->library('gettext');`

5. Add the **helper** to auto-load library array (application/config/autoload.php)

`$autoload['helper'] = array('gettext');`

or include it with Loader library

`$this->load->helper('gettext');`

6. Create gettext locales directory according to your `gettext_locale_dir` (application/language/locales by default).
Inside that directory **create `locale_name/LC_MESSAGES` path for each of your locales** and place your .mo files inside.

This is an example how to load Library overwriting default configuration:

```php
<?php
class Your_controller extends CI_Controller
{
   public function __construct()
   {
        parent::__construct();

        $this->load->library(
            'gettext',
            array(
                'gettext_text_domain' => 'my-project',
                'gettext_locale' => 'fr_FR.UTF-8',
                'gettext_locale_dir' => 'language/gettext'
            )
        );
   }
}
?>
```

Issues
------

If you have some issues with this package or is not working properly, please check your [CodeIgniter log](https://www.codeigniter.com/user_guide/general/errors.html#log_message) files. 'INFO' message is just for giving informations about the process, pay attention to 'ERROR' message which help you to resolve your issues.

Submit a [new issue](https://github.com/joel-depiltech/codeigniter-gettext/issues/new) if you can't solve your problem and help us to enhance this package.

Additional Usage
----------------

If you want to use URIs in i18n Style, you can easily add a Post-Controller-Hook like the sample below.
Place the following code inside your application/config/hooks.php.

```php

$hook['post_controller_constructor'] = function()
{
    /**
     * Localisation Strings Windows:
     * @link https://msdn.microsoft.com/en-us/library/cdax410z(v=vs.90).aspx
     * @link https://msdn.microsoft.com/en-us/library/39cwe7zf(v=vs.90).aspx
     * Localisation Strings Unix:
     * Verify that the selected locales are available by running `locale -a`. 
     * 
     * in addition take a look at
     * @link http://avenir.ro/create-cms-using-codeigniter-3/create-multilanguage-site-codeigniter/
     **/

    $locale = Array(
        "de" => Array(
            'de_DE.UTF-8',
            'de_DE@euro',
            'de_DE',
            'german',
            'ger',
            'deu',
            'de'
        ),
        "en" => Array(
            "en_GB.UTF-8",
            "en_GB@euro",
            "en_GB",
            "english",
            "eng",
            "gbr",
            "en"
        )
    );

    $CI = &get_instance();
    $lang = $this->uri->segment(1);
    if(isset($locale[$lang])){
        $getTextConfig = Array( 
            'gettext_catalog_codeset' => 'UTF8',
            'gettext_text_domain' => 'example',
            'gettext_locale_dir' => './language/locale/';
            'gettext_locale' => $locale[$lang]
        );
        $CI->load->library('gettext', $getTextConfig);
    }
    else {
        $CI->load->library('gettext');
    }

};
```
