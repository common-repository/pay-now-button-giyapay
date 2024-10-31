=== Pay Now Button with GiyaPay ===
Contributors: (this should be a list of wordpress.org userid's)
Tags: payments, paynow, giyapay
Requires at least: 5.3.2
Tested up to: 6.0.2
Requires PHP: 5.6
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin to enable shortcode for GiyaPay Pay Now button.

== Description ==

This plugin will allow you to use shortcodes to configure and display a GiyaPay Pay Now button in your WordPress website.

== Installation ==

You can directly install it from your WordPress dashboard > Plugin's menu

**or**

1. Download the zipped folder from here manually (upper right download button) 
2. Navigate to the *Plugins* menu in your WordPress dashboard
3. Click *Add New*
4. Click *Upload Plugin* then upload the zipped folder

= Setup & Configuration =
*Note: Beforehand, you will need your merchant ID and API key to be provided by GiyaPay after your onboarding process*

After installation, you can configure your GiyaPay plugin by doing the following:
1. On your WordPress dashboard, under the **Settings** menu, click on **GiyaPay Button** submenu
2. Enter your **Merchant ID** and **API Key** in their respective fields
3. Configure your callback URLs. The URLs are where your customers will be redirected upon successful, failed, or cancelled payment. **Note:** *These URLs are pages that your, the merchant, should define on your own.*
4. Make sure to set the plugin mode to **Production** under *Plugin Settings* section, unless you are testing and has access to a sandbox merchant ID and API key

= Usage =
In any page, you can do the following shortcode: `<giyapay description="Sample Description" amount="100" />` where:
* `description` is the item description that would show up on your GiyaPay dashboard as description of the transaction
* `amount` is the amount of the item that customers would pay

*Note: GiyaPay button would show as is wherever you put it in your web page/post. Layouting is currently the merchant's responsibility*

== Changelog ==

= 1.0.1 =
* [FIX] Add time factor for nonce creation

= 1.0.0 =
* [CHORE] Initial launch; Shortcode for GiyaPay Pay Now button
