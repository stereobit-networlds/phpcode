<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>e-Enterprise Crm</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="stereobit.networlds" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <!--link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" /-->
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
   
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
	
   <!--link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" /-->
   <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    
</head>
<!-- END HEAD -->	

<!-- BEGIN BODY -->
<body style="margin:0;padding:0">
		 <phpdac>crmdashboard.select_timeline use timeline</phpdac>
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=inbox">
                            <i class="icon-user"></i>
                            <div class="info"><phpdac>crmdashboard.inbox</phpdac></div>
                            <div class="status">Inbox</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-olive">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=stats">
                            <i class="icon-tags"></i>
                            <div class="info"><phpdac>crmdashboard.pageview</phpdac></div>
                            <div class="status">Page views</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-brown">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=tasks">
                            <i class="icon-remove-sign"></i>
                            <div class="info"><phpdac>crmdashboard.mailsFailed</phpdac></div>
                            <div class="status">Failed mails</div>
                        </a>
                    </div>					
                    <div class="metro-nav-block nav-block-green double">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=tasks">
                            <i class="icon-eye-open"></i>
                            <div class="info"><phpdac>crmdashboard.mailSent</phpdac></div>
                            <div class="status">Mails sent</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=tasks">
                            <i class="icon-envelope"></i>
                            <div class="info"><phpdac>crmdashboard.mailtoSend</phpdac></div>
                            <div class="status">Mails to send</div>
                        </a>
                    </div>
                </div>
                <div class="metro-nav">
                    <div class="metro-nav-block nav-light-green">
                        <a data-original-title="" href="javascript:sndReqArg('cp.php?t=cpinfo&s=&statsid='+statsid.value,'cpinfo');">
                            <i class="icon-bar-chart"></i>
                            <div class="info"><phpdac>crmdashboard.itemsPurchasedQty</phpdac></div>
                            <div class="status">Purchased Qty</div>
                        </a>
                    </div>				
                    <div class="metro-nav-block nav-light-blue double">
                        <a data-original-title="" href="javascript:sndReqArg('cp.php?t=cpinfo&s=items&statsid='+statsid.value,'cpinfo');">
                            <i class="icon-tasks"></i>
                            <div class="info"><phpdac>crmdashboard.itemsPurchased</phpdac></div>
                            <div class="status">Purchased Items</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=tasks">
                            <i class="icon-comments-alt"></i>
                            <div class="info"><phpdac>crmdashboard.mailClickPath</phpdac></div>
                            <div class="status">Follow up</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-purple">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=transactions">
                            <i class="icon-shopping-cart"></i>
                            <div class="info"><phpdac>crmdashboard.transactions</phpdac></div>
                            <div class="status">Orders</div>
                        </a>
                    </div>					
                    <div class="metro-nav-block nav-block-grey ">
                        <a data-original-title="" href="cpcrm.php?t=cpcrmdetails&iframe=1&id=<phpdac>fronthtmlpage.echostr use id</phpdac>&module=transactions">
                            <i class="icon-external-link"></i>
                            <div class="info"><phpdac>crmdashboard.sales</phpdac> &euro;</div>
                            <div class="status">Sales</div>
                        </a>
                    </div>
                </div>
                <div class="space10"></div>
                <!--END METRO STATES-->
            </div>

            <div class="row-fluid">
                <div class="span6">			
                    <!--BEGIN GENERAL STATISTICS-->
                    <!--div class="widget orange">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> General Statistics </h4>
                         <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                         </span>
                            <div class="update-btn">
                                <a href="javascript:;" class="btn"><i class="icon-repeat"></i> Update</a>
                            </div>
                        </div-->
                        <div class="widget-body">
                            <div class="text-center">
                                <div class="easy-pie-chart">
                                    <div class="percentage success" data-percent="<phpdac>rccontrolpanel.getStats use Diskspace+remainsizepercent</phpdac>"><span><phpdac>rccontrolpanel.getStats use Diskspace+remainsizepercent</phpdac></span>%</div>
                                    <div class="title">Used Space</div>
                                </div>
                                <div class="easy-pie-chart">
                                    <div class="percentage" data-percent="<phpdac>rccontrolpanel.getStats use Diskspace+remainhdpercent</phpdac>"><span><phpdac>rccontrolpanel.getStats use Diskspace+remainhdpercent</phpdac></span>%</div>
                                    <div class="title">HD Usage</div>
                                </div>
                                <div class="easy-pie-chart">
                                    <div class="percentage" data-percent="<phpdac>rccontrolpanel.getStats use Diskspace+remainmxpercent</phpdac>"><span><phpdac>rccontrolpanel.getStats use Diskspace+remainmxpercent</phpdac></span>%</div>
                                    <div class="title">MX Usage</div>
                                </div>
                                <div class="easy-pie-chart">
                                    <div class="percentage" data-percent="<phpdac>rccontrolpanel.getStats use Diskspace+remaindbpercent</phpdac>"><span><phpdac>rccontrolpanel.getStats use Diskspace+remaindbpercent</phpdac></span>%</div>
                                    <div class="title">DB Usage</div>
                                </div>
                            </div>
                        </div>
                    <!--/div-->
				
					
                    <div class="widget purple">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> Items </h4>
                         <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                         </span>
						 <div class="update-btn">
                            <a href="javascript:sndReqArg('cp.php?t=cpchartshow&group=&ai=2&report=statistics&statsid='+statsid.value,'statistics');" class="btn"><i class="icon-repeat"></i> Update</a>
                         </div>
                        </div>
                        <div class="widget-body">
                            <div class="text-center">
                                <div id="statistics"></div>
                            </div>
                        </div>
                    </div>	
					<div class="widget red">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> Categories </h4>
                         <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                         </span>
						 <div class="update-btn">
                            <a href="javascript:sndReqArg('cp.php?t=cpchartshow&group=&ai=1&report=statisticscat&statsid='+statsid.value,'statisticscat');" class="btn"><i class="icon-repeat"></i> Update</a>
                         </div>
                        </div>
                        <div class="widget-body">
                            <div class="text-center">
                                <div id="statisticscat"></div>
                            </div>
                        </div>
                    </div>		
                    <!--END GENERAL STATISTICS-->
                </div>
                <div class="span6">
                    <!--BEGIN GENERAL STATISTICS-->
                    <div class="widget purple">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> General Statistics </h4>
                         <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                         </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="text-center">
                                    <div class="sparkline">
                                        <div id="metro-sparkline-type1"></div>
                                        <div class="sparkline-tittle">Server Load</div>
                                    </div>
                                    <div class="sparkline">
                                        <div id="metro-sparkline-type2"></div>
                                        <div class="sparkline-tittle">Network Load</div>
                                    </div>
                                    <div class="sparkline">
                                        <div id="metro-sparkline-type3"></div>
                                        <div class="sparkline-tittle">Visit Load</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="widget yellow">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> Mail Queue </h4>
                         <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                         </span>
						 <div class="update-btn">
                            <a href="javascript:sndReqArg('cp.php?t=cpchartshow&group=&ai=1&report=mailqueue&statsid='+statsid.value,'mailqueue');" class="btn"><i class="icon-repeat"></i> Update</a>
                         </div>
                        </div>
                        <div class="widget-body">
                            <div class="text-center">
                                <div id="mailqueue"></div>
                            </div>
                        </div>
                    </div>					
					<div class="widget green">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> Transactions </h4>
                         <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                         </span>
						 <div class="update-btn">
                            <a href="javascript:sndReqArg('cp.php?t=cpchartshow&group=&ai=2&report=transactions&statsid='+statsid.value,'transactions');" class="btn"><i class="icon-repeat"></i> Update</a>
                         </div>
                        </div>
                        <div class="widget-body">
                            <div class="text-center">
                                <div id="transactions"></div>
                            </div>
                        </div>
                    </div>						
					<!--END GENERAL STATISTICS-->				
                </div>
            </div>
            <div class="row-fluid"> 
				 <!--hpdac>rccontrolpanel._show_charts</phpda-->
				 <INPUT TYPE= "hidden" ID="statsid" VALUE="0" />
            </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->


   <!-- BEGIN JAVASCRIPTS -->
   <script language="JavaScript">
   <phpdac>crmdashboard.javascript</phpdac>   
   </script>
   
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
   <script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <!--script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script-->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>

   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   
   <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
   
   <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script src="assets/chart-master/Chart.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script language="javascript" type="text/javascript">
	   
    //chosen select
    $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
	   
	   
    //daterange picker
    $('#reservation').daterangepicker();

    $('#reportrange').daterangepicker(
        {
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
                'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
            },
            opens: 'left',
            format: 'MM/dd/yyyy',
            separator: ' to ',
            startDate: Date.today().add({ days: -29 }),
            endDate: Date.today(),
            minDate: '01/01/2012',
            maxDate: '12/31/2013',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        },
        function(start, end) {
            $('#reportrange span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
        }
    );

    //Set the initial state of the picker label
    $('#reportrange span').html(Date.today().add({ days: -29 }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));

   </script>  

   <script src="js/easy-pie-chart.js"></script>
   <script src="js/sparkline-chart.js"></script>
   
   <!--script src="js/home-page-calender.js"></script>
   <script src="js/home-chartjs.js"></script-->
	
   <!-- END JAVASCRIPTS --> 
   
   <!-- e-Enterprise, stereobit.networlds (phpdac5) -->     
</body>
<!-- END BODY -->
</html>