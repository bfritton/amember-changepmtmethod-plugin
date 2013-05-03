Simple module for allowing aMember admins to change an invoices payment method (for future payments)

* @author:  Brian Fritton <bfritton@gmail.com>
* @copyright: GNU General Public License, version 3 (GPL-3.0)

Description
===============
This module adds an extra link to the list of recurring invoices next to "Next Rebill Date" and "Stop Recurring" links which shows the invoice's current payment method. Clicking on the payment method name will bring up a dialog box that allows you to type in the identifier of another payment system plugin to swith future payments for the invoice to. For example, if you have both Authorize.net CIM credit card and Offline payment methods, you can switch a user from being an offline-paying customer to being an automatically rebilling credit card customer, or the other way around.

Older payments that are listed for the invoice will still list the payment system and receipt ID's, etc. of the old payment system. When the next future rebill date comes due, you'll see the payment on the new payment system listed. This makes it easy to see when the payment method was changed.

Notes
===============
1. The "Payment Method" link will only display if the invoice is a recurring invoice, just like "Next Rebill Date" and "Stop Recurring" only appear for recurring invoices.

2. The module checks to see if the the user has a credit card on file in their account before changing the payment method if you are changing them to a credit card payment method. You will get an alert saying that the user does not have a credit card on file and that you need to enter one first.

3. If you enter a payment system identifier that is not enabled or does not exist, you will get an alert saying that it didn't change the payment method and you need to enable the new method or check your entry.

4. To find the desired payment method "identifier" that you must type into the dialog box, visit Admin -> Configuration -> Setup/Configuration -> Plugins. Under the "Payment Plugins" heading and dropdown, you will see the enabled payment method plugins under the select boxes with x's to the left of them. The identifier is the word (sometimes hyphenated) that is listed there. For example, the "Authorize.net CIM" payment method's identifier you would type in the change dialog would be "authorize-cim".


Installation
===============
1. FTP the application folder into your aMember root directory. This plugin does not override any existing aMember core files

2. Visit Admin -> Configuration -> Setup/Configuration -> Plugins and in the first select box with the header "Enabled Plugins", select "utilities - A utilities module to make all other modules interact better together" and then click on the Save button. The only thing in this module is the small controller and supporting files that allow you to change the payment method.

3. To see the link, you have to use the custom admin theme that comes along with this module. The only file in this custom admin theme is the file that shows the additional link in the admin user invoices section, nothing else will change about your admin interface. Go to Admin -> Configuration -> Setup/Configuration -> Global and change your "Admin Pages Theme" to "Enhanced" and then click on the Save button.

NOTE: If you already have a custom admin theme, you'll have to place the application/default/themes-admin/enhanced/admin/user-invoices.phtml in your custom theme. Do not switch the theme away from your custom theme if you do this. 99% of people don't have a custom admin theme.

That's it, you're done! Here is a short video showing you how to use the extension: http://bit.ly/16AEJ4R

Feel free to email me with questions - Please put "aMember Payment method change module" in the subject line so you don't get marked as spam.
