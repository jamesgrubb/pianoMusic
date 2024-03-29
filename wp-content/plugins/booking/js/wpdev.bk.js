    var date_approved = [];
    var date2approve = [];
    var date_admin_blank = [];
    var dates_additional_info = [];
    var is_all_days_available = [];
    var avalaibility_filters = [];
    var is_show_cost_in_tooltips = false;
    var is_show_availability_in_tooltips = false;
    var global_avalaibility_times = [];  
    var wpdev_bk_calendarViewMode = '';    
    var numbb = 0;
    var is_use_visitors_number_for_availability ;
    var timeoutID_of_thank_you_page = null;
    

    // Initialisation
    function init_datepick_cal(bk_type,  date_approved_par, my_num_month, start_day_of_week, start_bk_month  ){

            var cl = document.getElementById('calendar_booking'+ bk_type);if (cl == null) return; // Get calendar instance and exit if its not exist

            date_approved[ bk_type ] = date_approved_par;

            function click_on_cal_td(){
                if(typeof( selectDayPro ) == 'function') {selectDayPro(  bk_type);}
            }

            function selectDay(date) {
                jWPDev('#date_booking' + bk_type).val(date);
                if(typeof( selectDayPro ) == 'function') {selectDayPro( date, bk_type);}
            }

            function hoverDay(value, date){ 

                if(typeof( hoverDayTime ) == 'function') {hoverDayTime(value, date, bk_type);}

                if ( (location.href.indexOf('admin.php?page=booking/wpdev-booking.phpwpdev-booking')==-1) ||
                     (location.href.indexOf('admin.php?page=booking/wpdev-booking.phpwpdev-booking-reservation')>0) )
                { // Do not show it (range) at the main admin page
                    if(typeof( hoverDayPro ) == 'function')  {hoverDayPro(value, date, bk_type);}
                }
                //if(typeof( hoverAdminDay ) == 'function')  { hoverAdminDay(value, date, bk_type); }
             }

            function applyCSStoDays(date ){
                var class_day = (date.getMonth()+1) + '-' + date.getDate() + '-' + date.getFullYear();
    
                var my_test_date = new Date();  //Anxo customizarion
                my_test_date.setFullYear(wpdev_bk_today[0],(wpdev_bk_today[1]-1), wpdev_bk_today[2] ,0,0,0); //Get today           //Anxo customizarion
                if ( (days_between( date, my_test_date)+1) < block_some_dates_from_today ) return [false, 'cal4date-' + class_day +' date_user_unavailable']; //Anxo customizarion
/**/
                if (typeof( is_this_day_available ) == 'function') {
                    var is_day_available = is_this_day_available( date, bk_type);
                    if (! is_day_available) {return [false, 'cal4date-' + class_day +' date_user_unavailable'];}
                }

                // Time availability
                if (typeof( check_global_time_availability ) == 'function') {check_global_time_availability( date, bk_type );}


                // Check availability per day for H.E.
                var reserved_days_count = 1;
                if(typeof(availability_per_day) !== 'undefined')
                if(typeof(availability_per_day[ bk_type ]) !== 'undefined')
                   if(typeof(availability_per_day[ bk_type ][ class_day ]) !== 'undefined') {
                      reserved_days_count = parseInt( availability_per_day[ bk_type ][ class_day ] );}

                // we have 0 available at this day - Only for resources, which have childs
                if (  wpdev_in_array( parent_booking_resources, bk_type ) )
                        if (reserved_days_count <= 0)
                                return [false, 'cal4date-' + class_day +' date2approve date_unavailable_for_all_childs ' + blank_admin_class_day];

                //var class_day_previos = (date.getMonth()+1) + '-' + (date.getDate()-1) + '-' + date.getFullYear();
                var blank_admin_class_day = '';
                if(typeof(date_admin_blank[ bk_type ]) !== 'undefined')
                   if(typeof(date_admin_blank[ bk_type ][ class_day ]) !== 'undefined') {
                  blank_admin_class_day = ' date_admin_blank ';
                }
                var th=0;
                var tm=0;
                var ts=0;
                var time_return_value = false;
                // Select dates which need to approve, its exist only in Admin
                if(typeof(date2approve[ bk_type ]) !== 'undefined')
                   if(typeof(date2approve[ bk_type ][ class_day ]) !== 'undefined') {
                      th = date2approve[ bk_type ][ class_day ][0][3];
                      tm = date2approve[ bk_type ][ class_day ][0][4];
                      ts = date2approve[ bk_type ][ class_day ][0][5];
                      if ( ( th == 0 ) && ( tm == 0 ) && ( ts == 0 ) )
                          return [false, 'cal4date-' + class_day +' date2approve' + blank_admin_class_day]; // Orange
                      else {
                          time_return_value = [true, 'cal4date-' + class_day +' date2approve timespartly']; // Times
                          if(typeof( isDayFullByTime ) == 'function') {
                              if ( isDayFullByTime(bk_type, class_day ) ) return [false, 'cal4date-' + class_day +' date2approve' + blank_admin_class_day]; // Orange
                          }
                      }                          
                   }

                //select Approved dates
                if(typeof(date_approved[ bk_type ]) !== 'undefined')
                  if(typeof(date_approved[ bk_type ][ class_day ]) !== 'undefined') {
                      th = date_approved[ bk_type ][ class_day ][0][3];
                      tm = date_approved[ bk_type ][ class_day ][0][4];
                      ts = date_approved[ bk_type ][ class_day ][0][5];
                      if ( ( th == 0 ) && ( tm == 0 ) && ( ts == 0 ) )
                        return [false, 'cal4date-' + class_day +' date_approved' + blank_admin_class_day]; //Blue or Grey in client
                      else {
                        time_return_value = [true,  'cal4date-' + class_day +' date_approved timespartly']; // Times
                        if(typeof( isDayFullByTime ) == 'function') {
                            if ( isDayFullByTime(bk_type, class_day ) ) return [false, 'cal4date-' + class_day +' date_approved' + blank_admin_class_day]; // Blue or Grey in client
                        }
                      }
                  }


                for (var i=0; i<user_unavilable_days.length;i++) {
                    if (date.getDay()==user_unavilable_days[i])   return [false, 'cal4date-' + class_day +' date_user_unavailable' ];
                }


                if ( time_return_value !== false )  return time_return_value;
                else                                return [true, 'cal4date-' + class_day +' reserved_days_count' + reserved_days_count + ' ' ];
            }

            function changeMonthYear(year, month){ 
                if(typeof( prepare_tooltip ) == 'function') {
                    setTimeout("prepare_tooltip("+bk_type+");",1000);
                }
                if(typeof( prepare_highlight ) == 'function') {
                 setTimeout("prepare_highlight();",1000);
                }
            }
            // Configure and show calendar
            jWPDev('#calendar_booking'+ bk_type).datepick(
                    {beforeShowDay: applyCSStoDays,
                        onSelect: selectDay,
                        onHover:hoverDay,
                        onChangeMonthYear:changeMonthYear,
                        showOn: 'both',
                        multiSelect: multiple_day_selections,
                        numberOfMonths: my_num_month,
                        stepMonths: 1,
                        prevText: '<<',
                        nextText: '>>',
                        dateFormat: 'dd.mm.yy',
                        changeMonth: false, 
                        changeYear: false,
                        minDate: 0, maxDate: booking_max_monthes_in_calendar, //'1Y',
                        showStatus: false,
                        multiSeparator: ', ',
                        closeAtTop: false,
                        firstDay:start_day_of_week,
                        gotoCurrent: false,
                        hideIfNoPrevNext:true,
                        rangeSelect:wpdev_bk_is_dynamic_range_selection,
                        calendarViewMode:wpdev_bk_calendarViewMode,
                        useThemeRoller :false // ui-cupertino.datepick.css
                    }
            );


            if ( start_bk_month != false ) {
                var inst = jWPDev.datepick._getInst(document.getElementById('calendar_booking'+bk_type));
                inst.cursorDate = new Date();
                inst.cursorDate.setFullYear( start_bk_month[0], (start_bk_month[1]-1) ,  1 );
                inst.drawMonth = inst.cursorDate.getMonth();
                inst.drawYear = inst.cursorDate.getFullYear();

                jWPDev.datepick._notifyChange(inst);
                jWPDev.datepick._adjustInstDate(inst);
                jWPDev.datepick._showDate(inst);
                jWPDev.datepick._updateDatepick(inst);
            }




            //jWPDev('td.datepick-days-cell').bind('click', 'selectDayPro');
            if(typeof( prepare_tooltip ) == 'function') {setTimeout("prepare_tooltip("+bk_type+");",1000);}
    }


    //   A D M I N    Highlight dates when mouse over
    function highlightDay(td_class, bk_color){
       //jWPDev('.'+td_class).css({'background-color' : bk_color });
       //jWPDev('.'+td_class + ' a').css({'background-color' : bk_color });

       jWPDev('td a').removeClass('admin_calendar_selection');
       if (bk_color == '#ff0000')
            jWPDev('td.'+td_class + ' a').addClass('admin_calendar_selection');

       jWPDev('td').removeClass('admin_calendar_selection');
       if (bk_color == '#ff0000')
            jWPDev('td.'+td_class + '').addClass('admin_calendar_selection');

       
    }


    // A D M I N    Run this function at Admin side when click at Approve button
    function bookingApprove(is_delete, is_in_approved, user_id, wpdev_active_locale){
        var checkedd = jWPDev(".booking_appr"+is_in_approved+":checked");
        id_for_approve = "";

        // get all IDs
        checkedd.each(function(){
            var id_c = jWPDev(this).attr('id');
            id_c = id_c.substr(13,id_c.length-13)
            id_for_approve += id_c + "|";
        });

        //delete last "|"
        id_for_approve = id_for_approve.substr(0,id_for_approve.length-1);

        var denyreason ;
        if (is_delete ==1) {
            if (is_in_approved==0) {denyreason= jWPDev('#denyreason').val();}
            else                   {denyreason= jWPDev('#cancelreason').val();}
        } else {denyreason = '';}



        if (id_for_approve!='') {

            var wpdev_ajax_path = wpdev_bk_plugin_url+'/' + wpdev_bk_plugin_filename ;

            var ajax_type_action='';
            if (is_delete) {ajax_type_action =  'DELETE_APPROVE';var ajax_bk_message = 'Deleting...';}
            else           {ajax_type_action =  'UPDATE_APPROVE';var ajax_bk_message = 'Updating...';};

            document.getElementById('ajax_working').innerHTML =
            '<div class="info_message ajax_message" id="ajax_message">\n\
                <div style="float:left;">'+ajax_bk_message+'</div> \n\
                <div  style="float:left;width:80px;margin-top:-3px;">\n\
                       <img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif">\n\
                </div>\n\
            </div>';
            
            var is_send_emeils = 1;


            var elm1 = document.getElementById("is_send_email_for_all");
            if (elm1 != null) {is_send_emeils = jWPDev('#is_send_email_for_all').attr('checked' );}
            else {
                    if (is_in_approved==0) {is_send_emeils= jWPDev('#is_send_email_for_pending').attr('checked' );}
                    else                   {is_send_emeils= jWPDev('#is_send_email_for_aproved').attr('checked' );}
            }

            if (is_send_emeils) is_send_emeils = 1;
            else                is_send_emeils = 0;

            if (is_delete == 2 ) is_send_emeils = 0;

            jWPDev.ajax({                                           // Start Ajax Sending
                url: wpdev_ajax_path,
                type:'POST',
                success: function (data, textStatus){if( textStatus == 'success')   jWPDev('#ajax_respond').html( data );},
                error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' http://onlinebookingcalendar.com/faq/#faq-13');}},
                // beforeSend: someFunction,
                data:{
                    ajax_action : ajax_type_action,
                    approved : id_for_approve,
                    is_in_approved : is_in_approved,
                    is_send_emeils : is_send_emeils,
                    denyreason: denyreason,
                    user_id: user_id,
                    wpdev_active_locale:wpdev_active_locale
                }
            });
            return false;
        }
        return true;
    }

    // Send booking Cacel by visitor
    function bookingCancelByVisitor(booking_hash, bk_type){

        
        if (booking_hash!='') {


            document.getElementById('submiting' + bk_type).innerHTML =
                '<div style="height:20px;width:100%;text-align:center;margin:15px auto;"><img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif"><//div>';

            var wpdev_ajax_path = wpdev_bk_plugin_url+'/' + wpdev_bk_plugin_filename ;
            var ajax_type_action='DELETE_BY_VISITOR';
  
            jWPDev.ajax({                                           // Start Ajax Sending
                url: wpdev_ajax_path,
                type:'POST',
                success: function (data, textStatus){if( textStatus == 'success')   jWPDev('#ajax_respond_insert' + bk_type).html( data ) ;},
                error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' http://onlinebookingcalendar.com/faq/#faq-13');}},
                // beforeSend: someFunction,
                data:{
                    ajax_action : ajax_type_action,
                    booking_hash : booking_hash,
                    bk_type : bk_type
                }
            });
            return false;
        }
        return true;
    }

 
    // Scroll to script
    function makeScroll(object_name) {
         var targetOffset = jWPDev( object_name ).offset().top;
         jWPDev('html,body').animate({scrollTop: targetOffset}, 1000);
    }

    //Admin function s for checking all checkbos in one time
    function setCheckBoxInTable(el_stutus, el_class){
         jWPDev('.'+el_class).attr('checked', el_stutus);
    }


    // Set selected days at calendar as UnAvailable
    function setUnavailableSelectedDays( bk_type ){
        var sel_dates = jWPDev('#calendar_booking'+bk_type).datepick('getDate');
        var class_day2;
        for( var i =0; i <sel_dates.length; i++) {
          class_day2 = (sel_dates[i].getMonth()+1) + '-' + sel_dates[i].getDate() + '-' + sel_dates[i].getFullYear();
          date_approved[ bk_type ][ class_day2 ] = [ (sel_dates[i].getMonth()+1) ,  sel_dates[i].getDate(),  sel_dates[i].getFullYear(),0,0,0];
          jWPDev('#calendar_booking'+bk_type+' td.cal4date-'+class_day2).html(sel_dates[i].getDate());
          // jWPDev('#calendar_booking'+bk_type).datepick('refresh');
        }
    }


    // Aftre reservation action is done
    function setReservedSelectedDates( bk_type ){

        if (document.getElementById('calendar_booking'+bk_type) === null )  {
            document.getElementById('submiting' + bk_type).innerHTML = '';
            document.getElementById("booking_form_div"+bk_type).style.display="none";
            makeScroll('#booking_form'+bk_type);
            if (type_of_thank_you_message == 'page') {      // Page
                            //location.href= thank_you_page_URL;
                            timeoutID_of_thank_you_page = setTimeout(function ( ) {location.href= thank_you_page_URL;} ,1000);
            } else {                                        // Message
                            document.getElementById('submiting'+bk_type).innerHTML = '<div class=\"submiting_content\" >'+new_booking_title+'</div>';
                            jWPDev('.submiting_content').fadeOut( new_booking_title_time );
            }
        } else {

                setUnavailableSelectedDays(bk_type);                            // Set days as unavailable
                document.getElementById('date_booking'+bk_type).value = '';     // Set textarea date booking to ''
                document.getElementById('calendar_booking'+bk_type).style.display= 'none';
                
                var is_admin = 0;
                if (location.href.indexOf('booking.php') != -1 ) {is_admin = 1;}
                if (is_admin == 0) {
                    // Get calendar from the html and insert it before form div, which will hide after btn click
                    jWPDev('#calendar_booking'+bk_type).insertBefore("#booking_form_div"+bk_type);
                    document.getElementById("booking_form_div"+bk_type).style.display="none";
                    makeScroll('#calendar_booking'+bk_type);

                    var is_pay_now = false;

                    if ( document.getElementById('paypalbooking_form'+bk_type) != null )
                        if ( document.getElementById('paypalbooking_form'+bk_type).innerHTML != '' ) is_pay_now = true;

                if (! is_pay_now) {
                        if (type_of_thank_you_message == 'page') {      // Page
                            // thank_you_page_URL
                           // location.href= thank_you_page_URL;
                            timeoutID_of_thank_you_page = setTimeout(function ( ) {location.href= thank_you_page_URL;} ,1000);
                        } else {                                        // Message
                            //new_booking_title;
                            //new_booking_title_time;
                            document.getElementById('submiting'+bk_type).innerHTML = '<div class=\"submiting_content\" >'+new_booking_title+'</div>';
                            jWPDev('.submiting_content').fadeOut( new_booking_title_time );
                        }
                    }

                } else {
                    setTimeout(function ( ) {location.reload(true);} ,1000);
                }
        }
    }


        function showErrorMessage( element , errorMessage) {

            jWPDev("[name='"+ element.name +"']")
                    .fadeOut( 350 ).fadeIn( 300 )
                    .fadeOut( 350 ).fadeIn( 400 )
                    .animate( {opacity: 1}, 4000 )
            ;  // mark red border
            jWPDev("[name='"+ element.name +"']")
                    .after('<div class="wpdev-help-message">'+ errorMessage +'</div>'); // Show message
            jWPDev(".wpdev-help-message")
                    .css( {'color' : 'red'} )
                    .animate( {opacity: 1}, 10000 )
                    .fadeOut( 2000 );   // hide message
            element.focus();    // make focus to elemnt
            return;

        }

    // Check fields at form and then send request
    function mybooking_submit( submit_form , bk_type, wpdev_active_locale){


        var count = submit_form.elements.length;
        var formdata = '';
        var inp_value;
        var element;
        var el_type;


        // Serialize form here
        for (i=0; i<count; i++)   {
            element = submit_form.elements[i];
            
            if ( (element.type !=='button') && (element.type !=='hidden') && ( element.name !== ('date_booking' + bk_type) )   ) {           // Skip buttons and hidden element - type


                // Get Element Value
                if (element.type !=='checkbox') {inp_value = element.value;}                      
                else {
                    if (element.value == '') inp_value = element.checked;       // if checkbox so then just check checked
                    else {
                        if (element.checked) inp_value = element.value;
                        else inp_value = '';
                    }
                }


                // Recheck for max num. available visitors selection
                if ( element.name == ('visitors'+bk_type) )
                    if( typeof( is_max_visitors_selection_more_than_available ) == 'function' )
                        if ( is_max_visitors_selection_more_than_available( bk_type, inp_value, element ) )
                            return;



                // Validation Check --- Requred fields
                if ( element.className.indexOf('wpdev-validates-as-required') !== -1 ){             
                    if  ((element.type =='checkbox') && ( inp_value === false))      {showErrorMessage( element , message_verif_requred_for_check_box);return;}
                    if  ( inp_value === '')   {showErrorMessage( element , message_verif_requred);return;}
                }

                // Validation Check --- Email correct filling field
                if ( element.className.indexOf('wpdev-validates-as-email') !== -1 ){                
                    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if(reg.test(inp_value) == false) {showErrorMessage( element , message_verif_emeil);return;}
                }




// if(typeof( write_js_validation ) == 'function') {if (write_js_validation(element, inp_value, bk_type )) return;}


                // Get Form Data
                if ( element.name !== ('captcha_input' + bk_type) ) {
                    if (formdata !=='') formdata +=  '~';                                                // next field element

                    el_type = element.type
                    if ( element.className.indexOf('wpdev-validates-as-email') !== -1 )  el_type='email';
                    if ( element.className.indexOf('wpdev-validates-as-coupon') !== -1 ) el_type='coupon';
                    
                    inp_value = inp_value + '';
                    inp_value = inp_value.replace(new RegExp("\\^",'g'), '&#94;'); // replace registered characters
                    inp_value = inp_value.replace(new RegExp("~",'g'), '&#126;'); // replace registered characters

                    inp_value = inp_value.replace(/"/g, '&#34;'); // replace double quot
                    inp_value = inp_value.replace(/'/g, '&#39;'); // replace single quot

                    formdata += el_type + '^' + element.name + '^' + inp_value ;                    // element attr
                }
            }

        }  // End Fields Loop

        // Recheck Times
        if( typeof( is_this_time_selections_not_available ) == 'function' )
            if ( is_this_time_selections_not_available( bk_type, submit_form.elements ) )
                return;



        //Show message if no selected days
        if (document.getElementById('date_booking' + bk_type).value == '')  {

            if ( document.getElementById('additional_calendars' + bk_type) != null ) { // Checking according additional calendars.

                var id_additional_str = document.getElementById('additional_calendars' + bk_type).value; //Loop have to be here based on , sign
                var id_additional_arr = id_additional_str.split(',');
                var is_all_additional_days_unselected = true;
                for (var ia=0;ia<id_additional_arr.length;ia++) {
                    if (document.getElementById('date_booking' + id_additional_arr[ia] ).value != '' ) {
                        is_all_additional_days_unselected = false;
                    }
                }
                if (is_all_additional_days_unselected) {
                    alert(message_verif_selectdts);
                    return;
                }

            } else {
                alert(message_verif_selectdts);
                return;
            }
        }


        // Cpatch  verify
        var captcha = document.getElementById('wpdev_captcha_challenge_' + bk_type);
        if (captcha != null)  form_submit_send( bk_type, formdata, captcha.value, document.getElementById('captcha_input' + bk_type).value ,wpdev_active_locale);
        else                  form_submit_send( bk_type, formdata, '',            '' ,                                                      wpdev_active_locale);
        return;
    }

    // Gathering params for sending Ajax request and then send it
    function form_submit_send( bk_type, formdata, captcha_chalange, user_captcha ,wpdev_active_locale){

            document.getElementById('submiting' + bk_type).innerHTML = '<div style="height:20px;width:100%;text-align:center;margin:15px auto;"><img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif"><//div>';

            var my_booking_form = '';
            var my_booking_hash = '';
            if (document.getElementById('booking_form_type' + bk_type) != undefined)
                my_booking_form =document.getElementById('booking_form_type' + bk_type).value;

            if (wpdev_bk_edit_id_hash != '') my_booking_hash = wpdev_bk_edit_id_hash;

            var is_send_emeils= jWPDev('#is_send_email_for_new_booking').attr('checked' );
            if (is_send_emeils == undefined) {is_send_emeils =1 ;}            
            if (is_send_emeils) is_send_emeils = 1;
            else                is_send_emeils = 0;

            send_ajax_submit(bk_type,formdata,captcha_chalange,user_captcha,is_send_emeils,my_booking_hash,my_booking_form,wpdev_active_locale   ); // Ajax sending request

            var formdata_additional_arr;
            var formdata_additional;
            var my_form_field;
            var id_additional;
            var id_additional_str;
            var id_additional_arr;
            if (document.getElementById('additional_calendars' + bk_type) != null ) {
                
                id_additional_str = document.getElementById('additional_calendars' + bk_type).value; //Loop have to be here based on , sign
                id_additional_arr = id_additional_str.split(',');

                for (var ia=0;ia<id_additional_arr.length;ia++) {
                    formdata_additional_arr = formdata;
                    formdata_additional = '';
                    id_additional = id_additional_arr[ia];

                   
                    formdata_additional_arr = formdata_additional_arr.split('~');
                    for (var j=0;j<formdata_additional_arr.length;j++) {
                        my_form_field = formdata_additional_arr[j].split('^');
                        if (formdata_additional !=='') formdata_additional +=  '~';

                        if (my_form_field[1].substr( (my_form_field[1].length -2),2)=='[]')
                          my_form_field[1] = my_form_field[1].substr(0, (my_form_field[1].length - (''+bk_type).length ) - 2 ) + id_additional + '[]';
                        else
                          my_form_field[1] = my_form_field[1].substr(0, (my_form_field[1].length - (''+bk_type).length ) ) + id_additional ;


                        formdata_additional += my_form_field[0] + '^' + my_form_field[1] + '^' + my_form_field[2];
                    }


                    if (document.getElementById('date_booking' + id_additional).value != '' ) {
                        setUnavailableSelectedDays(id_additional);                                              // Set selected days unavailable in this calendar
                        jWPDev('#calendar_booking'+id_additional).insertBefore("#booking_form_div"+bk_type);    // Insert calendar before form to do not hide it
                        if (document.getElementById('paypalbooking_form'+id_additional) != null)
                            jWPDev('#paypalbooking_form'+id_additional).insertBefore("#booking_form_div"+bk_type);    // Insert payment form to do not hide it
                        else {
                            jWPDev("#booking_form_div"+bk_type).append('<div id="paypalbooking_form'+id_additional+'" ></div>')
                            jWPDev("#booking_form_div"+bk_type).append('<div id="ajax_respond_insert'+id_additional+'" ></div>')
                        }
                        send_ajax_submit( id_additional ,formdata_additional,captcha_chalange,user_captcha,is_send_emeils,my_booking_hash,my_booking_form ,wpdev_active_locale  );
                    }
                }
            }
    }

    //<![CDATA[
    function send_ajax_submit(bk_type,formdata,captcha_chalange,user_captcha,is_send_emeils,my_booking_hash,my_booking_form  ,wpdev_active_locale ) {
            // Ajax POST here

            var my_bk_res = bk_type;
            if ( document.getElementById('bk_type' + bk_type) != null ) my_bk_res = document.getElementById('bk_type' + bk_type).value;

            jWPDev.ajax({                                           // Start Ajax Sending
                url: wpdev_bk_plugin_url+ '/' + wpdev_bk_plugin_filename,
                type:'POST',
                success: function (data, textStatus){if( textStatus == 'success')   jWPDev('#ajax_respond_insert' + bk_type).html( data ) ;},
                error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' http://onlinebookingcalendar.com/faq/#faq-13');}},
                // beforeSend: someFunction,
                data:{
                    ajax_action : 'INSERT_INTO_TABLE',
                    bktype: my_bk_res ,
                    dates: document.getElementById('date_booking' + bk_type).value ,
                    form: formdata,
                    captcha_chalange:captcha_chalange,
                    captcha_user_input: user_captcha,
                    is_send_emeils : is_send_emeils,
                    my_booking_hash:my_booking_hash,
                    booking_form_type:my_booking_form,
                    wpdev_active_locale:wpdev_active_locale
                }
            });
    }
    //]]>



    // Prepare to show tooltips
    function prepare_tooltip(myParam){   
           var tooltip_day_class_4_show = " .timespartly";
           if (is_show_availability_in_tooltips) {
               if (  wpdev_in_array( parent_booking_resources , myParam ) )
                    tooltip_day_class_4_show = " .datepick-days-cell a";  // each day
           }
           if (is_show_cost_in_tooltips) {
                tooltip_day_class_4_show = " .datepick-days-cell a";  // each day
           }

          // Show tooltip at each day if time availability filter is set
          if(typeof( global_avalaibility_times[myParam]) != "undefined") {
              if (global_avalaibility_times[myParam].length>0)  tooltip_day_class_4_show = " .datepick-days-cell";  // each day
          }
 
          jWPDev("#calendar_booking" + myParam + tooltip_day_class_4_show ).tooltip( { //TODO I am changed here
                          tip:'#demotip'+myParam,
                          predelay:500,
                          delay:0,
                          position:"top center",
                          offset:[2,0],
                          opacity:1
          });
          //    tooltips[myParam] = jWPDev("#calendar_booking" + myParam+ " .timespartly").tooltip( { tip:'#demotip'+myParam, predelay:500, api:true  });
          //    tooltips[myParam].show();
    }

    // Hint labels inside of input boxes
    jWPDev(document).ready( function(){
        
            jWPDev('div.inside_hint').click(function(){
                    jWPDev(this).css('visibility', 'hidden').siblings('.has-inside-hint').focus();
            });

            jWPDev('input.has-inside-hint').blur(function() {
                if ( this.value == '' )
                    jWPDev(this).siblings('.inside_hint').css('visibility', '');
            }).focus(function(){
                    jWPDev(this).siblings('.inside_hint').css('visibility', 'hidden');
            });
    });



function openModalWindow(content_ID){
    //alert('!!!' + content);
    jWPDev('.modal_content_text').attr('style','display:none;');
    document.getElementById( content_ID ).style.display = 'block';
    var buttons = {};//{ "Ok": wpdev_bk_dialog_close };
    jWPDev("#wpdev-bk-dialog").dialog( {
            autoOpen: false,
            width: 700,
            height: 300,
            buttons:buttons,
            draggable:false,
            hide: 'slide',
            resizable: false,
            modal: true,
            title: '<img src="'+wpdev_bk_plugin_url+ '/img/calendar-16x16.png" align="middle" style="margin-top:1px;"> Booking Calendar'
    });
    jWPDev("#wpdev-bk-dialog").dialog("open");
}

function wpdev_bk_dialog_close(){
    jWPDev("#wpdev-bk-dialog").dialog("close");
}

function wpdev_togle_box(boxid){
    if ( jWPDev( '#' + boxid ).hasClass('closed') ) jWPDev('#' + boxid).removeClass('closed');
    else                                            jWPDev('#' + boxid).addClass('closed');
}


//<![CDATA[
function setNumerOfCalendarsAtAdminSide(us_id, cal_count) {

            var ajax_bk_message = 'Updating...';
            
            document.getElementById('ajax_working').innerHTML =
            '<div class="info_message ajax_message" id="ajax_message">\n\
                <div style="float:left;">'+ajax_bk_message+'</div> \n\
                <div  style="float:left;width:80px;margin-top:-3px;">\n\
                       <img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif">\n\
                </div>\n\
            </div>';

            jWPDev.ajax({                                           // Start Ajax Sending
                url: wpdev_bk_plugin_url+ '/' + wpdev_bk_plugin_filename,
                type:'POST',
                success: function (data, textStatus){if( textStatus == 'success')   jWPDev('#ajax_respond').html( data );},
                error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' http://onlinebookingcalendar.com/faq/#faq-13');}},
                // beforeSend: someFunction,
                data:{
                    ajax_action : 'USER_SAVE_OPTION',
                    user_id: us_id ,
                    option: 'ADMIN_CALENDAR_COUNT',
                    count: cal_count,
                    is_reload:1
                }
            });
}
//]]>


//<![CDATA[
function verify_window_opening(us_id,  window_id ){

        var is_closed = 0;

        if (jWPDev('#' + window_id ).hasClass('closed') == true){
            jWPDev('#' + window_id ).removeClass('closed');
        } else {
            jWPDev('#' + window_id ).addClass('closed');
            is_closed = 1;
        }


        jWPDev.ajax({                                           // Start Ajax Sending
                url: wpdev_bk_plugin_url+ '/' + wpdev_bk_plugin_filename,
                type:'POST',
                success: function (data, textStatus){if( textStatus == 'success')   jWPDev('#ajax_respond').html( data );},
                error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' http://onlinebookingcalendar.com/faq/#faq-13');}},
                // beforeSend: someFunction,
                data:{
                    ajax_action : 'USER_SAVE_WINDOW_STATE',
                    user_id: us_id ,
                    window: window_id,
                    is_closed: is_closed
                }
        });

}
//]]>

 function wpdev_in_array (array_here, p_val) {
	for(var i = 0, l = array_here.length; i < l; i++) {
		if(array_here[i] == p_val) {
			return true;
		}
	}
	return false;
}


function days_between(date1, date2) {

    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime()
    var date2_ms = date2.getTime()

    // Calculate the difference in milliseconds
    var difference_ms =  date1_ms - date2_ms;

    // Convert back to days and return
    return Math.round(difference_ms/ONE_DAY)

}

function showwidedates_at_admin_side(){
                                 jWPDev('.short_dates_view').addClass('hide_dates_view');
                                jWPDev('.short_dates_view').removeClass('show_dates_view');
                                jWPDev('.wide_dates_view').addClass('show_dates_view');
                                jWPDev('.wide_dates_view').removeClass('hide_dates_view');
                                jWPDev('#showwidedates').addClass('hide_dates_view');

                                jWPDev('.showwidedates').addClass('hide_dates_view');
                                jWPDev('.showshortdates').addClass('show_dates_view');
                                jWPDev('.showshortdates').removeClass('hide_dates_view');
                                jWPDev('.showwidedates').removeClass('show_dates_view');
}

function showshortdates_at_admin_side(){
                                jWPDev('.wide_dates_view').addClass('hide_dates_view');
                                jWPDev('.wide_dates_view').removeClass('show_dates_view');
                                jWPDev('.short_dates_view').addClass('show_dates_view');
                                jWPDev('.short_dates_view').removeClass('hide_dates_view');

                                jWPDev('.showshortdates').addClass('hide_dates_view');
                                jWPDev('.showwidedates').addClass('show_dates_view');
                                jWPDev('.showwidedates').removeClass('hide_dates_view');
                                jWPDev('.showshortdates').removeClass('show_dates_view');

}