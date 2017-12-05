<!-- ========================================= MAIN ========================================= -->
<main id="authentication" class="inner-bottom-md">
	<div class="container">
		<div class="row">
			
			<div class="col-md-6">
                <?MEDIA-CENTER/INDEX?>
			</div><!-- /.col -->

			<div class="col-md-6">
				<section class="section register inner-left-xs">
					<h2 class="bordered"><phpdac>cms.slocale use _USERREGISTRATION</phpdac></h2>
					<p>
						<phpdac>cms.slocale use _USRPLEASETEXT</phpdac>
					</p>
					
					<!--div class="social-auth-buttons">
						<div class="row">
							<div class="col-md-6">
								<button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-facebook"></i> Sign In with Facebook</button>
							</div>
							<div class="col-md-6">
								<button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-twitter"></i> Sign In with Twitter</button>
							</div>
						</div>
					</div-->					

					<form role="form" class="register-form cf-style-1" method="get" action="signup/"> 
						<!--div class="field-row">
                            <label>Email</label>
                            <input type="text" class="le-input">
                        </div--><!-- /.field-row -->

                        <div class="buttons-holder">
                            <button type="submit" class="le-button huge"><phpdac>cms.slocale use _SIGNUP</phpdac></button>
                        </div><!-- /.buttons-holder -->
					</form>

					<h2 class="semi-bold"><phpdac>cms.slocale use _USRPLEASETEXT</phpdac> :</h2>

					<phpdac>cms.include_part use /parts/empty-message.php+++media-center</phpdac>

				</section><!-- /.register -->

			</div><!-- /.col -->

		</div><!-- /.row -->
	</div><!-- /.container -->
</main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->