CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Installation
 * Known issues
 * Support
 * Sponsorship


INTRODUCTION
------------

This module provides additional printable and HTML e-mailable views of Commerce
Orders. Firstly it setups up a new display on Commerce Orders which you can use 
to customise how elements are displayed. Secondly it provides a rule which will
email the HTML invoice. You have total control over how your invoice will look
through a template.


INSTALLATION
------------

 1. Drop the 'commerce_invoice_receipt' folder into the modules directory
    '/sites/all/modules/'.

 2. In your Drupal site, enable the module under Administration -> Modules
    '?q=/admin/modules'.

 3. Setup new Commerce Order display under Store -> Configuration -> Order
    Settings -> Manage Display '?q=admin/commerce/config/order/display'. Click
    on the 'Invoice/Receipt' tab. Unhide any fields you want to use in your
    invoice.

 4. Setup a rule under Store -> Configuration -> Checkout settings -> Checkout 
    rules '?q=admin/commerce/config/checkout/rules'. Then 'Add a checkout rule',
    you'll find an action called 'Send invoice receipt email' under Commerce
    Order that you can use.

KNOWN ISSUES
------------

 * None


SUPPORT
-------

If the problem is with the module, please file a support request at
http://drupal.org/project/issues/commerce_invoice_receipt


SPONSORSHIP
-----------

This module is currently sponsored by Holy Trinity Brompton 
(http://www.htb.org.uk).