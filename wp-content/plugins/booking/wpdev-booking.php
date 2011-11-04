<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://onlinebookingcalendar.com/demo/
Description: Online reservation and availability checking service for your site.
Version: 3.0
Author: wpdevelop
Author URI: http://onlinebookingcalendar.com/
Tested WordPress Versions: 2.8.3 - 3.2
*/

/*  Copyright 2009, 2010, 2011  www.onlinebookingcalendar.com  (email: info@onlinebookingcalendar.com),

    www.wpdevelop.com - custom wp-plugins development & WordPress solutions.

    This file (and only this file wpdev-booking.php) is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// <editor-fold defaultstate="collapsed" desc=" T O D O : & Changelog lists ">
/*

-------------------------------------------------------
M i n o r   T O D O   List:
-------------------------------------------------------
 *   Posibility to add at the booking bookmark how many days to select in range there.
 *   Different rental lengths for different types of items. For example, Room 1 is only available to rent 1 day at a time and Room 2 is available to rent for either 1, 3 or 7 days.
 *   if the user selects a Friday, Saturday or Sunday, it must be part of at least two days, but they can book single days on Monday, Tuesday, Wednesday and Thursday
 *   Dependence of maximum selection of days from start selection of week day. Its mean that user can select some first day and depends from the the day of week, which was selected, he will be able to select some specific (maximum number of days).
 *  Add labels of payment -  it would be much better if the booking manager displayed who had paid and who hadn't right now every order goes through with no way of identifying this
 * (Maybe at new CRM plugin) Google Calendar integration: it would be nice, someone books inserted into one of Google calendars of administraor, which is used to register all books. This way, it gets synchronized to desktop and iPhone as well
 * Send text messages after booking appointments, send Reminders via email and text messaging, SMS or text message option, to notify you immediately via your cell phone when you get a booking online
 *
 * Field type be created that only accepts numbers (auto-validates as number only) or have REGEX defined by user.
 * Add description inside of input text fields inside of fields as grey text ???
 * set required field phone for free version ???
 * Season filtering by weeks numbers
 *
 * Add checking to the email sending according errors ( it can be when PHP Mail function is not active at the SERVER ) 
 * Set posibility to login with user permission at MultiUser version
 * Id like this [select visitors "1" "2" "3" "4"] to be dynamic. If there is 3 products free, I�d like to see [select visitors "1" "2" "3"] If there is 1 products free, I�d like to see [select visitors "1"] In the popup you can see price and product free so I imagine it�s possible to make selected visitors dynamic
 * Days cost view inside of calendar, unders the days numbers
 * Booking shopping cart. Posibility for user select booking days from diferent booking resources at the site, all these days will be added to the new booking caledar shopping cart and then user can finilize booking and make payment if its needed.
 *
 * 1) 6 possible half day users paying 'X' amount 2) There can be passengers (at a diffierent cost) but they will minus (take a position of) one of the 6 half day users/spots  3) People can also book full days but this will be at a different cost, it will then deduct from two of the 6 users/spots of the half day (the 2 bring one spot frmo the morning and one from the afternoon availability). e.g If someone books for the full day then on that day a morning and afternoon half day spots will be booked/unavailable.
 * Automated email to go out to people a couple of days prior to their reservation yet
 *  Imagine you have several hundred resources. It would be convenient to filter those resources by a simple category. An example would be restaurants and you could filter them by the food type (American, French, Chinese, etc) instead of just having a huge select menu.
 * allow the user to put the 'filters' in order of importance - so you can still have a default standard price for '7 days together' and then a further filter for '7 days in December', which is prioritised.
 * I'm using the form in two steps, also with short codes [visitorbookingediturl] and [visitorbookingcancelurl]. I note that there is no clear difference for the visitor between an action and another, because the only difference is at the end of the second step when he says "Cancel Reservation" Could be an explanation at the beginning where clearly distinguish between the two actions?
 * however it gets confusing for the hotel staff in the booking tables. Is it possible for you to make it display only one table for each group and have them ordered default by date? currently if there is a group of 2 or 5 or 7 or however many it shows each individual guest in the group as their own booking own booking table... this gets very difficult to sort through because the resort typically books larger groups
 * Restaurant tables resrvation - more easy interface
 * Check in/out text fields with popup clandars and not inline calendar
 * to have the opportunity to attach a .pdf document in the "Send payment request to customer" window. In that case we could attach the invoice directly to the email.
 * week view, day view type of claendar
 * pass the selected days on the booking search to booking form,  when you go to the form from the booking search, but not to the form directly
 * option to backup and restore the booking system
 * Fix posibility to make transfear of booking from one resource to other, if new booking resource (with cpapcity = 1 ) have already same booked dates but in different time.
 * Add button "Print" - print details from the booking and from the resource that's being booked and put them on a screen that could be printed.  Customization of print loyout. Exmaple: Thank you [firstname] [lastname] for booking of the [bookingresource].  Please make sure to arrive at least 30 minutes prior to your reservation time in order to guarentee...
 * When adding reservations through the admin panel, posibility to approve it by default instead of pending.
 * Waiting list functionality available where end user can still choose to sign up to be on a waiting list for a course, and if someone cancels, the first person on the waiting list will be notified by email. Upon notification they can choose to accept or reject. If reject then then an email will be sent to next person on the waiting list.
 * ^ Think about this feature: In combination with auto cancell posibility To deactivate the Pending option. If a customer books a particular date interval without paying, the booking request must be transfered for future payment, but must not block the calendar dates. Other visitors must be able to book these dates as long as the intial customer's payment has not come through. set pending days for selection by other visitors, untill admin will not approve them. * Allow pending bookings to be chosen with an explanation that they will be on a waiting list in the event that the original booker cancels.

-------------------------------------------------------
 M a j o r   T O D O   List:
-------------------------------------------------------
 * Popup shortcode form:
 * - Showing 2 or more calendars with one form
 * - Booking search results
 *
 * Authorize . net support
 * Google checkout support
 * 2co payment system 
 * WordPay
 * eway  payment system support
 * Check posibility to include this payment system : https://www.nmi.com/ (its for Panama)
 *
 * Set different times on different days, yet still have them show up on the same calendar
 *  Instead of using a select menu, i'd like to use a list of radio buttons so the user can see all available and unavailable times for that day.
 *
 * Add posibility to send link in "auto" email for payment to visitors, after visitor make booking. (Premium and higher versions)
 * Fix issue with not correct cost at the Paypal button, when advanced cost is not set for custom field, but its setuped for normal fields.
 *
 * Add Lables with Show max visitor in name of room (Hotel Edition, MultiUser)
 * print/email list for i.e cleaning personnel, kitchen personnel etc would be really good to have, almost every resource that can be booked needs some kind of involvement of different persons, so an option to create print/email lists of custom chosen fields from the booking form would add value and make it easier to inform the right people on what’s going on in a given time-range.
 * calendar is booked during a give period I would like to be able have an email or SMS sent out to people when I have an opening.
 * check-in and check-out days visible like in the other booking systems (mark half of day)
 * 
 * posibility to make several bookings for several time slots with capacity > 1
 * search form has to put the dates into the booking calendar
 *
 * Linear Calendar View:
 * -        Month                 June                                           July                                                                                      August
 * -        Ressource         01 02 03 03 05 06 07 08 09 10 11
 * -        Ressource 1       0   0    1   1   1   1    1   1    1    w w
 * -        Ressource 2       0   0    1   1   3   1    5   1    1    w w
 *
 * Make categories for resources? I have like 70 resources, and it would be great if i could split the choices on different pages or categories.
 *
 * Show apprtment name nearly each day, if these days in diferent rooms (Hotel Edition, MultiUser)
 *
 * My Account & Added Extras � We are investigating ways of people (visitors) logging in to see past orders and potentially adding items to the order, like for example booking a spa treatment, or an upgraded food package.
 *
 * Add posibility to select booking resource from select box as a feature of booking calendar - no anymore JS tricks
 * Search results at new seperate page, diferent from search form
 * At the page you are use 2 booking calendars and on booking form. And there cabin#1 is a Main booking resource (required), so if you do not select days at this calendar, such message will show up.
 * Possible for the booking form that is emailed to me when a booking is placed to come from the sender like in contact form 7? I am having a problem with users replying to our admin email!
 *
 * [Jingye Luo]: Enable/Disable Reseting the time of waiting for automatic cancell of booking, if visitor click at the payment link, even if he is do not made successfull payment after this. Its will give additional time for finish of payment, if visitor by some reason is not made it.
 * [Jingye Luo]: Logic for automatically send payment request "if a pending booking has been over x time"
 *
 * [Jocelyn]: How most of these sites handle the availability calendars is to leave the check out date available by default, so each reservation only blocks the calendar up to the day before checkout.
 * [Jocelyn]:  partial booking with the clock is confusing for the user and visually confusing whether or not they can book arrive or depart that day at least for a hotel/rental application. If this functionality exists and I'm unaware or if it might something that could come in other updates I'd be very interested to know.
 * [Jocelyn]:  to have only an availability calendar and just simple date fields with pop up date selectors, some users were unclear they had to select the date from the calendar and others selected the wrong date and were unable unselect it.
 * [Jocelyn]:  When I use the reservation form and a reservation is successfully entered, a message flashes that someone will contact me, etc., but the issue is the calender shows the beginning date with a partial select clock as it should but the second day of my reservation also shows this same icon.
 *
 * [Steve Horler]: Set start day(s) of selection only for specific week days. For exmaple visitor can start selection only from Sat, Mon and Fri
 * [Steve Horler]: Set dependence (posibility) number of selected days from start day of selection. For exmaple: visitor can select only 3 days starting at Fri and Sat, 4 days - Fir, 5 days - Monday, 7 days - Sat
 * Fix coupon creation issue of not showing coupons, when some coupon not have selected "All" resources.
 * [Ben Burnett ]  Currently we have our system set-up so that our clients have to both select the date in the calendar, and also type in the date manually.  I would like it that this text field is powered by the calendar, so that when someone clicks on a start date, that the result is that this start date is written in text form.
 * [FRED]: I have set [start times] and [duration], but when selecting 11pm and going beyond the midnight mark by selecting duration: 2:00, the price turns negative! (it looks like the system tries to book the time from 11pm to 1am the SAME DAY.  By manually selecting both days (the "start day" and the "end day"), the cost is calculated correctly, but now the 'end day' becomes completely unavailable for further booking. This is a big problem and renders the plug-in useless for our purpose. Please advise on how to fix this. Also, I have set my unavailable time as 1:00 - 14:00 with a filter applied to the availability, but it still allows me to book durations that go beyond 1am. Start time: [select starttime "14:00" "15:00" "16:00" "17:00" "18:00" "19:00" "20:00" "21:00" "22:00" "23:00" "0:00"]  Set duration: [select durationtime "1:00" "2:00" "3:00" "4:00" "5:00"]< /p >
 *
 * !!! Set iframes for all help images
 *
 * ! [Steve Wheeler] More complex discount system, which are depends from season and from number of selected days togather. Posiblity to assign seson to each of already setted cost, which depends from number of selected days for reservation
 * [Stefan Rest] able to print out all the rooms, the guest names and the notes on a print out everyday so we know who is checking in and the payments they made
 * Set Approve / Cancellation links inside of email for the administrator
 * Add Print button nearly Cancel button - posibility to print selected bookings.
 * ---------------------------------------------------------------------------------------------------------------------------------------
 *
 * Dashboard: divs - posibility to  show in 2 or 1 collumns; online demo links; OBC news loading
 * Help description according translations at the: Form fields, Search form, Email templates, Thank you message, Cost description, Availability.
 * some graphical show of the activity- stat of the booking? (how many room booked in month , money receive ets? )
 * jQuery 1.6.0 and newer introduces another method: .prop() that replaces many .attr() calls. This was (partially) reverted in jQuery 1.6.1 but some uses of .attr() are not working any more. For example .attr('checked', '') doesn't uncheck checkboxes any more.  Best would be to replace all getting/setting of 'checked', 'selected' and 'disabled' from .attr() to .prop() (using .prop() is also much faster). More information on the jQuery blog: http://blog.jquery.com/2011/05/12/jquery-1-6-1-released/
 * Calculation of additional cost in advanced cost management section - "N/day", which depend from the number of selected days in specific additionl booking calendar(if used more than one calendar in form customization) (Premium Plus, Hotel Edition).
 * Paypal IPN (Instant Payment Notification) support for rechecking if payment was successful or not.
 * Error during updating remarks in BD [F:/wpdev-pro.php|L:2562|V:.2.9|DB:Query was empty]This bug is related to the string not being escaped properly. It happens when I have a '%' sign in the note.


-----------------------------------------------
Change Log and Features for Future Releases :
-----------------------------------------------
= 3.0 =
* Professional / Premium / Premium Plus / Hotel / MultiUser versions features:
 *   (Professional, Premium, Premium Plus, Hotel Edition, MultiUser)
 * Add to the cost settings - "Set cost of booking resource depends from number of selected booking days" posibility to set Season filter condition. {Please note, if you are select some season filter for this cost configuration, its will apply to the days, only if all days are inside of this season filter.}  (Premium Plus, Hotel Edition, MultiUser)
 * Fix issue with creating discount coupons, which based on procents from final booking cost.(Hotel Edition)
 * Fix emails sending, after the resrvation is canceled by visitor, both (if its active at the settings) to the admin and to the person, who made booking. In this case is using "Cancelation" email template. (Professional, Premium, Premium Plus, Hotel Edition, MultiUser)
 * Fix issue with posibility to book resrved time at some 1 day, if was activated range days selection using 2 mouse clicks, and visitor click only 1 time at days. (Premium, Premium Plus, Hotel Edition, MultiUser)
 * Fix issue with coupons creation. The coupons was not displayed, if at least one coupon was not apply to all booking resources. (Hotel Edition)
 * Fix issue of showing Paypal payment form, during payment request, if the Paypal was deactivated in settings ( Premium, Premium Plus, Hotel Edition, MultiUser)
* Features and issue fixings in All versions:
 * Setting number of unavailable days in calendar starting from today.
 * Hide the avilability calendar, after resrvation is done (after click on send button), so will be show thank you message only, or payment form.
 * Fix conflict issue with plugin Tabber-Widget
 * Fix issue of loading correct language during first activation of plugin, if language of site not English. Previosly some sentences was in English saved to DB, now its fixed.


*/
// </editor-fold>


    // Die if direct access to file
    if (   (! isset( $_GET['merchant_return_link'] ) ) && (! isset( $_GET['payed_booking'] ) ) && (!function_exists ('get_option')  )  && (! isset( $_POST['ajax_action'] ) ) ) { 
        die('You do not have permission to direct access to this file !!!');
    }

    // A J A X /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ( ( isset( $_GET['payed_booking'] ) )  || (  isset( $_GET['merchant_return_link']))  || ( isset( $_POST['ajax_action'] ) ) ) { 
        require_once( dirname(__FILE__) . '/../../../wp-load.php' );
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   D e f i n e     S T A T I C              //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (!defined('WP_BK_DEBUG_MODE'))    define('WP_BK_DEBUG_MODE',  false );
    if (!defined('WPDEV_BK_FILE'))       define('WPDEV_BK_FILE',  __FILE__ );

    if (!defined('WP_CONTENT_DIR'))      define('WP_CONTENT_DIR', ABSPATH . 'wp-content');                   // Z:\home\test.wpdevelop.com\www/wp-content
    if (!defined('WP_CONTENT_URL'))      define('WP_CONTENT_URL', site_url() . '/wp-content');    // http://test.wpdevelop.com/wp-content
    if (!defined('WP_PLUGIN_DIR'))       define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');               // Z:\home\test.wpdevelop.com\www/wp-content/plugins
    if (!defined('WP_PLUGIN_URL'))       define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');               // http://test.wpdevelop.com/wp-content/plugins
    if (!defined('WPDEV_BK_PLUGIN_FILENAME'))  define('WPDEV_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );              // menu-compouser.php
    if (!defined('WPDEV_BK_PLUGIN_DIRNAME'))   define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) ); // menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_DIR')) define('WPDEV_BK_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // Z:\home\test.wpdevelop.com\www/wp-content/plugins/menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_URL')) define('WPDEV_BK_PLUGIN_URL', WP_PLUGIN_URL.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // http://test.wpdevelop.com/wp-content/plugins/menu-compouser


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   L O A D   F I L E S                      //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-functions.php')) {     // S u p p o r t    f u n c t i o n s
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-functions.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php'))  {             // C A P T C H A
        require_once(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php' );}

  //  if (file_exists(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php'))   {             // O t h e r
  //      require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-class.php'))           // C L A S S    B o o k i n g
        { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-class.php' ); }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // GET VERSION NUMBER
    $plugin_data = get_file_data_wpdev(  __FILE__ , array( 'Name' => 'Plugin Name', 'PluginURI' => 'Plugin URI', 'Version' => 'Version', 'Description' => 'Description', 'Author' => 'Author', 'AuthorURI' => 'Author URI', 'TextDomain' => 'Text Domain', 'DomainPath' => 'Domain Path' ) , 'plugin' );
    if (!defined('WPDEV_BK_VERSION'))    define('WPDEV_BK_VERSION',   $plugin_data['Version'] );                             // 0.1
            

    //    A J A X     R e s p o n d e r     // RUN if Ajax //
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-ajax.php'))  { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-ajax.php' ); }

    // RUN //
    $wpdev_bk = new wpdev_booking(); 
?>