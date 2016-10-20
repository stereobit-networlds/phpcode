<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Campaigns</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <!--link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" /-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/style-default.css" rel="stylesheet" id="style_color" />

    <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />

    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="assets/jquery-tags-input/jquery.tagsinput.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" /-->
    <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
    <!--link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" /-->
	
    <!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /-->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onLoad="init()">
   <!-- BEGIN HEADER -->
	<phpdac>frontpage.include_part use /parts/header.php+++metro</phpdac>
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
		<phpdac>frontpage.include_part use /parts/sidebar.php+++metro</phpdac>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
			<phpdac>frontpage.include_part use /parts/pageheader.php+++metro</phpdac>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Campaign</h4>
                            <!--span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span-->
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form method="post" action="#" class="form-horizontal">
							
                            <div class="control-group">
                                <label class="control-label">Subject</label>
                                <div id="edit_subject" class="controls">
                                    <input name="subject" value="<phpdac>fronthtmlpage.nvldac2 use subject+fronthtmlpage.echostr:subject++</phpdac>" type="text" class="span6 " readonly="readonly" />
                                    <!--span class="help-inline">Insert a subject </span-->
                                </div>
                            </div>	
						    <div class="control-group">
                                <label class="control-label"><phpdac>i18nL.translate use from</phpdac></label>
                                <div id="edit_from" class="controls">
                                    <div class="input-icon left">
                                        <i class="icon-envelope"></i>
                                        <input name="from" value="<phpdac>fronthtmlpage.nvldac2 use from+fronthtmlpage.echostr:from++</phpdac>" class=" " type="text" / readonly="readonly">
										<span class="help-inline">
											<i class="icon-user"></i>
											<input name="realm" value="<phpdac>fronthtmlpage.nvldac2 use realm+fronthtmlpage.echostr:realm++</phpdac>" class=" " type="text" readonly="readonly" />
										</span>
                                    </div>
                                </div>
                            </div>	
						    <div class="control-group">
                                <label class="control-label">Settings</label>
                                <div class="controls">
                                    <div class="input-icon left">
                                        <i class="icon-user"></i>
										<input name="user" value="<phpdac>fronthtmlpage.nvldac2 use user+fronthtmlpage.echostr:user++</phpdac>" class=" " type="text" <phpdac>rcbulkmail.disableSettings</phpdac> />
										</span>
										<span class="help-inline">
											<i class="icon-lock"></i>
											<input name="pass" value="<phpdac>fronthtmlpage.nvldac2 use pass+fronthtmlpage.echostr:pass++</phpdac>" class=" " type="text" <phpdac>rcbulkmail.disableSettings</phpdac> />
										</span>
										<span class="help-inline">
											<i class="icon-tasks"></i>
											<input name="server" value="<phpdac>fronthtmlpage.nvldac2 use server+fronthtmlpage.echostr:server++</phpdac>" class=" " type="text" <phpdac>rcbulkmail.disableSettings</phpdac> />
										</span>
                                    </div>
                                </div>
                            </div>								
							<div class="control-group">
                                <label class="control-label">To</label>
                                <div id="editto" class="controls">
									<input name="include" id="tags_1" type="text" class="tags" value="<phpdac>fronthtmlpage.nvldac2 use include+fronthtmlpage.echostr:include++</phpdac>" readonly="readonly" />									
                                </div>
                                <div id="editsend" class="controls">
									<input name="receivers" type="text" value="<phpdac>fronthtmlpage.nvldac2 use bcc+fronthtmlpage.echostr:bcc++</phpdac>" class="span12 " readonly="readonly" />									
                                </div>	
                            </div>	

                            <div class="control-group">
                                <label class="control-label">Scheduled start</label>
                                <div class="controls">
                                    <div class="input-append date" id="dpYears" data-date=""
                                        data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                        <input class="m-ctrl-medium" size="16" type="text" name="schdate" readonly>
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
									<!--input id="dp1" type="text" value="" size="16" class="m-ctrl-medium"-->		
    
                                    <div class="input-append bootstrap-timepicker">
                                        <input id="timepicker4" type="text" name="schtime" class="input-small">
                                        <span class="add-on"> <i class="icon-time"></i></span>
                                    </div>
                                </div>
                            </div>							
							<div id="messages" class="control-group">
								<label class="control-label">Messages</label>
								<div class="controls">
									<select id="messages" multiple="multiple" style="height:60px;width:100%;">
										<phpdac>rcbulkmail.viewMessages</phpdac>
									</select>
								</div>
							</div>	
							
                            <div class="form-actions">
                                <button type="submit" class="<phpdac>fronthtmlpage.nvl use rcbulkmail.sendOk+btn btn-success+btn btn-danger+</phpdac>">Start</button>

								<input type="hidden" name="FormName" value="cpsubsend" />
								<input type="hidden" name="FormAction" value="<phpdac>fronthtmlpage.nvl use rcbulkmail.sendOk+cppreviewcamp+cpsubsend+</phpdac>" />
								<input type="hidden" name="xcid" value="<phpdac>fronthtmlpage.echostr use rcbulkmail.cid</phpdac>">
								<input type="hidden" name="bid" value="<phpdac>fronthtmlpage.echostr use rcbulkmail.batchid</phpdac>">
                            </div>							
						
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>			
            <div class="row-fluid">
                 <div class="span12">
					 <?METRO/INDEX?>
                 </div>
            </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

   <!-- BEGIN FOOTER -->
	<phpdac>frontpage.include_part use /parts/footer.php+++metro</phpdac>
   <!-- END FOOTER -->

   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->

   <script src="js/jquery-1.8.2.min.js"></script>
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <!--script type="text/javascript" src="assets/bootstrap/js/bootstrap-fileupload.js"></script-->
   <script src="js/jquery.blockui.js"></script>

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
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
   <!--script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script reload out of frame-->     
   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>



   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page-->
   <script src="js/form-component.js"></script>
     
  <!-- END JAVASCRIPTS -->

   <script language="javascript" type="text/javascript">
       $(function() {
           $.configureBoxes();
       });
   </script>    

   <!-- e-Enterprise, stereobit.networlds (phpdac5) -->     

</body>
<!-- END BODY -->
</html>