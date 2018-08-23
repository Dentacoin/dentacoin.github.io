=== reCAPTCHA in WP comments form ===
Author: jmviade
Contributors: jmviade
Tags: reCAPTCHA, comments antispam, antispam, comments reCAPTCHA, antispam protection, google reCAPTCHA, comments form, secure form, security, antispam RTL, RTL Language Support
Requires at least: 4.0.0
Tested up to: 4.7
Stable tag: 0.0.9.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

reCAPTCHA in WP comments form is an ANTISPAM tool that adds a Google reCAPTCHA to the comments form and protects your site from the spam robots threats.

== Description ==

reCAPTCHA in WP comments form plugin is an **ANTISPAM tool** that adds a Google **reCAPTCHA field** inside the comments form of your WP theme when the user is not logged in preventing fraudulent or deceptive comments.

The plugin also **introduces a second verification process** that detects the unauthorized direct accesses by spam robots to the WP comments system and allows you to decide what do you want to do with those comments.

Finally, the plugin has got an optional **forced javascript output mode** that lets you to add a reCAPTCHA field **also in old WP themes** that didn't use the new WP form comments functions but they make a direct output of its own comments form.


= FEATURES LIST =

**Basic Features**

* **All variants** of Google reCAPTCHA field are available
* Two simple steps **Installation Wizard**
* Automatic **default configuration settings** for all plugin components
* Automatic default configuration for reCAPTCHA field
* Configuration settings for Plugin 
* Configuration settings for **ANTISPAM operation**
* Four modes of operation in case of spam robots threats (SPAM, TRASH, DELETE or DIE)
* Visual configuration settings for Google reCAPTCHA: theme, size, type, align, language
* Dynamic comments form sample for viewing configuration settings changes
* Visual Help
* RTL Language support
* Admin Color scheme adapted

**Middle features**

* Forced language option for reCAPTCHA field
* Plugin **blocks the submit button** while reCAPTCHA field is not verified
* Plugin **changes HTML structure of the comments form** to prevent malicious automatic sendings while reCAPTCHA field is not verified
* Plugin also blocks **other elements with `[type=submit]` inside form** in case of a theme customized comments form
* Plugin lets you to write your own **additional CSS for the reCAPTCHA field**
* New **restore default value buttons** in plugin configuration section for helping you in case of changing WP theme, accidental errors, test environtments, etc.

**Advanced features**

* reCAPTCHA **verification process via AJAX before submitting the form**
* **Second security checking process** for preventing any security breach **before saving the comment**
* Optional **Forced javascript output** that allows you to use the plugin with old WP themes that didn't use function `comment_form()`
* Advanced ID's tags settings for using this plugin with WP Themes that creates its own comments form HTML struct
* reCAPTCHA javascript initialization that prevents reCAPTCHA conflicts in case of that other plugins use reCAPTCHA.
* New mínimum CSS styles for recaptcha alignment

= PLUGIN PAGE =

To learn more about the plugin, visit the [Plugin page](http://www.joanmiquelviade.com/plugin/google-recaptcha-in-wp-comments-form/ "Author's plugin page").


== Installation ==
1. Upload reCAPTCHA in WP comments form plugin to your wordpress `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. After the activation, the plugin will begin an Installation Wizard that will help you to get your Google API Keys pair.
4. After the Installation Wizard, simply change the activation switch field of the plugin to ON and a reCAPTCHA field will appears automatically in your comments form.


== Screenshots ==
1. After installation plugin begins a visual two simple steps Installation Wizard that helps you to obtain your Google API Key pair.
2. Simply, one by one COPY each part of the Google reCAPTCHA API Key pair.
3. And PASTE them (Site key and Secret key) in the homonymous fields of the installation Wizard form.
4. Plugin has got a visual interface and an example form that always shows your settings changes.
5. Plugin works automátically however you can configure the reCAPTCHA field completely: size, color, mode, align, language.
6. Example of a comments form with a reCAPTCHA field.
7. Example of a comments form with a reCAPTCHA field inside an old WP theme using the force javascript output mode.
8. Example of a RTL comments form with a reCAPTCHA field.


== Changelog ==
= 0.0.9.0.2 =
* Minor function changes for compatibility with hosting servers with PHP versions minor than 5.4.0
* Improving compatibility module for WP themes with sophisticated HTML struct comments form
* RTL full language support.
* CSS correction for screen `(min-width:: 783px)` in RTL WP admin plugin interfaces
* Update screenshots in WordPress plugin documentation page
* Translations changes

= 0.0.9.0.1 =
* Upload error correction

= 0.0.9 =

* New installation Wizard when you install the plugin from scratch
* Also automatic Installation Wizard launch when no reCAPTCHA API keys detected
* New visual dinamic interface for Google reCAPTCHA settings configuration
* New align reCAPTCHA option
* New reCAPTCHA forced language selector field with native and english languages names
* Add a new method `directly DELETE comment` for treating the comments in case of breaking reCAPTCHA
* New admin notices in case of Google reCAPTCHA API Keys pair error
* Now, plugin incorpores the WordPress Admin Color Schemes in its admin interface
* Improve all help pages including images of all installation steps, configuration screen options, etc.
* Adding two new Help pages for reCAPTCHA Security level and Accessibility issues 
* Installation and Updating plugin routines moved to Tools class
* New Installation Wizard class
* New class for plugin messages and Help screens
* New class for options and settings control
* Change the credit link to `rel=nofollow`
* New restore default values buttons in plugin configuration section
* Improving documentation
* Change reCAPTCHA initialization to 'option=explicit' via javascript function

= 0.0.8.2.1 =

* Minor translations and help pages modifications

= 0.0.8.2 =

* Adding new compatibility mode for all `[type=submit]` elements inside the form
* Forcing blocked mode for all `<input>`, `<button>` or `<a>` submit HTML elements, even without ID attribute
* Trackbacks and Ping messages tested
* Extending help plugin with two more help tabs
* Address links correction
* Optional plugin credits link output
* Your CSS changes are also reflected in the sample form of the settings page
* Some minor text corrections

= 0.0.8.1 =

* Correction: logged users are not spammers
* Translations system correction

= 0.0.8 =

* Add forced javascript output mode
* Add CSS for reCAPTCHA field

= 0.0.7 =

* Update to 1.1.2 version for the Google reCAPTCHA PHP module

= 0.0.6 =

* Introduce metaboxes structure

= 0.0.5 =

* Introduce plugin stats panel

= 0.0.4 =

* Change render mode to data defined instead of explicit
* Introduce Forced language support
* Introduce \"in case of error\" module

= 0.0.3 =

* Test reCAPTCHA modes
* Creating enqueuing script modules

= 0.0.2 =

* Accordion Interface
* Back-End form example sample interface

= 0.0.1 =

* Test version


== Upgrade Notice ==
No upgrade Notices