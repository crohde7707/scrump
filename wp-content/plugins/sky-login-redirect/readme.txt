=== Sky Login Redirect ===
Contributors: skyminds
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DNSC3NVBWR66L
Tags: login, redirect, redirection, sky login redirect
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.4
License: GPLv2 or later

Redirects users to the page they were reading just before logging in.

== Description ==

Sky Login Redirect redirects users to the page they were reading just before logging in.
In case that page is not defined, users are redirected to the homepage.

No configuration necessary. Everything works under the hood. Simply activate the plugin.

More information can be found on [the plugin home page](http://www.skyminds.net/wordpress-plugins/sky-login-redirect/ "Sky Login Redirect Homepage").

== Installation ==

Install and activate the plugin. You're done. No configuration necessary.

== Screenshots ==

None. It works under the hood.

== Changelog ==

= 1.4 =
* New check : attempt to redirect to the referring page even if $redirect_to wasn't explicitly set.

= 1.3 =

* Fixed a regression (thanks Sharonq for reporting).
* Plugin partially rewritten.
* New check with is_ssl().

= 1.2 =
* Fix for the login loop that occured when using the password recovery and when logging straight from the login page (thanks zkagen and salatfresser for reporting).
* Ditch the use of HTTP_HOST for home_url().

= 1.1 =
* Added code to check if $redirect_to is set and make it take precedence.
* Changed plugin URL to its [home page](http://www.skyminds.net/wordpress-plugins/sky-login-redirect/ "Sky Login Redirect Homepage").

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.4 =
Attempt to redirect to the referring page even if $redirect_to wasn't explicitly set.
