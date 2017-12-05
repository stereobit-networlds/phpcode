<!-- ========================================= MAIN ========================================= -->
<main id="contact-us" class="inner-bottom-md">
	<section class="google-map map-holder">
		<div id="map" class="map center"></div>
		<!--form role="form" class="get-direction">
			<div class="container">
				<div class="row">
					<div class="center-block col-lg-10">
						<div class="input-group">
							<input type="text" class="le-input input-lg form-control" placeholder="Enter Your Starting Point">
							<span class="input-group-btn">
								<button class="btn btn-lg le-button" type="button">Get Directions</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</form-->
	</section>

	<div class="container">
		<div class="row">
			
			<div class="col-md-8">
				<section class="section leave-a-message">
					<h2 class="bordered"><phpdac>i18nL.translate use contactform+RCCONTROLPANEL</phpdac></h2>
					<p><phpdac>cmsrt.nvldac2 use cmsform.msg+cmsrt.echostr:cmsform.msg++</phpdac></p>
                    <?MEDIA-CENTER/INDEX?>
				</section><!-- /.leave-a-message -->
			</div><!-- /.col -->

			<div class="col-md-4">
				<section class="our-store section inner-left-xs">
					<h2 class="bordered"><phpdac>cms.paramload use INDEX+title</phpdac></h2>
					<address>
						<phpdac>cms.paramload use INDEX+address</phpdac> <br/>
						(0030) <phpdac>cms.paramload use INDEX+tel1</phpdac> <br/>
						(0030) <phpdac>cms.paramload use INDEX+tel2</phpdac>
					</address>
					<h3>Hours of Operation</h3>
					<ul class="list-unstyled operation-hours">
						<li class="clearfix">
							<span class="day">Monday:</span>
							<span class="pull-right hours">9am-5pm</span>
						</li>
						<li class="clearfix">
							<span class="day">Tuesday:</span>
							<span class="pull-right hours">9am-5pm</span>
						</li>
						<li class="clearfix">
							<span class="day">Wednesday:</span>
							<span class="pull-right hours">9am-5pm</span>
						</li>
						<li class="clearfix">
							<span class="day">Thursday:</span>
							<span class="pull-right hours">9am-5pm</span>
						</li>
						<li class="clearfix">
							<span class="day">Friday:</span>
							<span class="pull-right hours">9am-5pm</span>
						</li>
						<li class="clearfix">
							<span class="day">Saturday:</span>
							<span class="pull-right hours">9am-2pm</span>
						</li>
						<li class="clearfix">
							<span class="day">Sunday:</span>
							<span class="pull-right hours">Closed</span>
						</li>
					</ul>
					<!--h3>Career</h3>
					<p>If you're interested in employment opportunities at MediaCenter, please contact us: <a href="contact.php"><phpdac>rcserver.paramload use INDEX+e-mail</phpdac></a></p-->
				</section><!-- /.our-store -->
			</div><!-- /.col -->

		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
<!-- ========================================= MAIN : END ========================================= -->