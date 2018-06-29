=== WP to LinkedIn Auto Publish ===
Contributors: f1logic
Donate link: https://xyzscripts.com/donate/
Tags:  linkedin auto publish, wp to linkedin auto publish, linkedIn publishing, post to linkedIn, linkedin, social media auto publish, social media publishing, social network auto publish, social media, social network, add link to linkedIn
Requires at least: 2.8
Tested up to: 4.9.5
Stable tag: 1.4.7
License: GPLv2 or later

Publish posts automatically to LinkedIn.

== Description ==

A quick look into WP to LinkedIn Auto Publish :

	★ Publish simple text message to LinkedIn 
	★ Publish message to LinkedIn with image
	★ Filter items  to be published based on categories
	★ Filter items to be published based on custom post types
	★ Enable or disable wordpress page publishing
	★ Customizable  message formats for LinkedIn


= WP to LinkedIn Auto Publish Features in Detail =

The WP to LinkedIn Auto Publish lets you publish posts automatically from your blog to LinkedIn. You can publish your posts to LinkedIn as simple text message or as text message with attached image. The plugin supports filtering posts based on  custom post-types as well as categories.

The prominent features of  the WP to LinkedIn Auto Publish plugin are highlighted below.

= Supported Mechanisms =

The various mechanisms of posting to LinkedIn are listed below. 

    Simple text message
    Text message with image
    Share post content with public or your connections

= Filter Settings =

The plugin offers multiple kinds of filters for contents to be published automatically.

    Enable or disable publishing of wordpress pages
    Filter posts to be published based on categories
    Filtering based on custom post types

= Message Format Settings =

The supported post elements which can be published are given below.

    Post title 
    Post description
    Post excerpt
    Permalink
    Blog title
    User nicename
    Post ID
    Post publish date

= About =

WP to LinkedIn Auto Publish is developed and maintained by [XYZScripts](https://xyzscripts.com/ "xyzscripts.com"). For any support, you may [contact us](https://xyzscripts.com/support/ "XYZScripts Support").

★ [WP to LinkedIn Auto Publish User Guide](http://help.xyzscripts.com/docs/linkedin-auto-publish/user-guide/ "WP to LinkedIn Auto Publish User Guide")
★ [WP to LinkedIn Auto Publish FAQ](http://help.xyzscripts.com/docs/linkedin-auto-publish/faq/ "WP to LinkedIn Auto Publish FAQ")

== Installation ==

★ [WP to LinkedIn Auto Publish User Guide](http://help.xyzscripts.com/docs/linkedin-auto-publish/installation/ "WP to LinkedIn Auto Publish User Guide")
★ [WP to LinkedIn Auto Publish FAQ](http://help.xyzscripts.com/docs/linkedin-auto-publish/faq/ "WP to LinkedIn Auto Publish FAQ")

1. Extract `linkedIn-auto-publish.zip` to your `/wp-content/plugins/` directory.
2. In the admin panel under plugins activate WP to LinkedIn Auto Publish.
3. You can configure the settings from WP to LinkedIn Auto Publish menu. (Make sure to Authorize LinkedIn application after saving the settings.)
4. Once these are done, posts should get automatically published based on your filter settings.

If you need any further help, you may contact our [support desk](https://xyzscripts.com/support/ "XYZScripts Support").

== Frequently Asked Questions ==

★ [WP to LinkedIn Auto Publish User Guide](http://help.xyzscripts.com/docs/linkedin-auto-publish/user-guide/ "WP to LinkedIn Auto Publish User Guide")
★ [WP to LinkedIn Auto Publish FAQ](http://help.xyzscripts.com/docs/linkedin-auto-publish/faq/ "WP to LinkedIn Auto Publish FAQ")

= 1. The WP to LinkedIn Auto Publish is not working properly. =

Please check the wordpress version you are using. Make sure it meets the minimum version recommended by us. Make sure all files of the `wp to linkedIn auto publish` plugin are uploaded to the folder `wp-content/plugins/`


= 2. How do I restrict auto publish to certain categories ? =

Yes, you can specify the categories which need to be auto published from settings page.


= 3. Why do I have to create applications in LinkedIn ? =

When you create your own applications, it ensures that the posts to LinkedIn are not shared with any message like "shared via xxx"


= 4. Which  all data fields can I send to social networks ? =

You may use post title, content, excerpt, permalink, blog title, user nicename, post id and post publish date for auto publishing.


= 5. Why do I see SSL related errors in logs ? =

SSL peer verification may not be functioning in your server. Please turn off SSL peer verification in settings of plugin and try again.


= More questions ? =

[Drop a mail](https://xyzscripts.com/support/ "XYZScripts Support") and we shall get back to you with the answers.


== Screenshots ==

1. This is the LinkedIn configuration section.
2. Publishing options while creating a post.

== Changelog ==

= WP to LinkedIn Auto Publish 1.4.7 =
* Plugin name changed to WP to LinkedIn Auto Publish
* Applied wordpress time format in {POST_PUBLISH_DATE}

= WP LinkedIn Auto Publish 1.4.6 =
* Plugin name changed to WP LinkedIn Auto Publish, as per wordpress guidelines

= LinkedIn Auto Publish 1.4.5 =
* Minor bug fixes
* updated UI

= LinkedIn Auto Publish 1.4.4 =
* Added USER_DISPLAY_NAME in message format
* Removed irrelevant configuration related to image posting
* Minor security issues fixed
* Minor bugs fixed

= LinkedIn Auto Publish 1.4.3 =
* Added POST_ID and POST_PUBLISH_DATE in message formats

= LinkedIn Auto Publish 1.4.2 =
* utf-8 decoding issue fixed
* Visual composer compatiblity issue fixed
* Minor bugs fixed
* Nonce added
* Prevented direct access to plugin files
* Data validation updated

= LinkedIn Auto Publish 1.4.1 =
* Fixed custom post types autopublish issue	
* Fixed duplicate autopublish issue

= LinkedIn Auto Publish 1.4 =
* Added option to enable/disable utf-8 decoding before publishing	
* Removed unwanted configuration related to 'future_to_publish' hook
* Postid added in autopublish logs
* Updated auto publish mechanism using transition_post_status hook
* Open graph meta tags will be prefered for linkedin attachments

= LinkedIn Auto Publish 1.3.2 =
* Latest five auto publish logs are maintained
* A few bug fixes

= LinkedIn Auto Publish 1.3.1 =
* Updated Linkedin authorization

= LinkedIn Auto Publish 1.3 =
* Updated Linkedin API
* Auto publish added during quick edit 
* Added option to enable/disable "future_to_publish" hook for handling auto publish of scheduled posts	
* Added options to enable/disable "the_content", "the_excerpt", "the_title" filters on content to be auto-published
* Fixed category display issue

= LinkedIn Auto Publish 1.2 =
* Option to configure auto publish settings while editing posts/pages
* General setting to enable/disable post publishing
* Added auto publish for scheduled post
* Fixed issue related to \" in auto publish

= LinkedIn Auto Publish 1.1.1 =
* Added compatibility with wordpress 3.9.1
* Compatibility with bitly plugin

= LinkedIn Auto Publish 1.1 =
* View logs for last published post
* Option to enable/disable SSL peer verification
* Option to reauthorize the application

= LinkedIn Auto Publish 1.0.2 =
* Bug fixed for &amp;nbsp; in post

= LinkedIn Auto Publish 1.0.1 =
* Default image fetch logic for auto publish updated.

= LinkedIn Auto Publish 1.0 =
* First official launch.

== Upgrade Notice ==

= LinkedIn Auto Publish 1.0.1 =
If you had issues  with default image used for auto publishing, you may apply this upgrade.

= LinkedIn Auto Publish 1.0 =
First official launch.

== More Information ==

★ [WP to LinkedIn Auto Publish User Guide](http://help.xyzscripts.com/docs/linkedin-auto-publish/ "WP to LinkedIn Auto Publish User Guide")
★ [WP to LinkedIn Auto Publish FAQ](http://help.xyzscripts.com/docs/linkedin-auto-publish/faq/ "WP to LinkedIn Auto Publish FAQ")

= Troubleshooting =

Please read the FAQ first if you are having problems.

= Requirements =

    WordPress 3.0+
    PHP 5+ 

= Feedback =

We would like to receive your feedback and suggestions about WP to LinkedIn Auto Publish plugin. You may submit them at our [support desk](https://xyzscripts.com/support/ "XYZScripts Support").
