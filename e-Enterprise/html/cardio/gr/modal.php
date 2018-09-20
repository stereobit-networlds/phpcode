	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<h3 class="white">Επικοινωνία</h3>
				<form name="callform" action="call.php" method="post" class="popup-form">
					<input id="info" type="hidden" name="info" value="info">
					<input name="cperson" type="text" class="form-control form-white" placeholder="Full Name">
					<input name="email" type="text" class="form-control form-white" placeholder="Email Address">
					<div class="dropdown">
						<button id="dLabel" name="dLabel" class="form-control form-white dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Θέμα
						</button>
						<ul class="dropdown-menu animated fadeIn" role="menu" aria-labelledby="dLabel">
							<li class="animated lightSpeedIn"><a href="#" onClick="setInfo('e-Enterprise LP');">e-Enterprise LP</a></li>
							<li class="animated lightSpeedIn"><a href="#" onClick="setInfo('e-Mail marketing');">e-Mail marketing</a></li>
							<li class="animated lightSpeedIn"><a href="#" onClick="setInfo('e-mail ενημέρωσης');">e-mail ενημέρωσης</a></li>
							<li class="animated lightSpeedIn"><a href="#" onClick="setInfo('Τηλεφωνική επικοινωνία');">Τηλεφωνική επικοινωνία</a></li>
						</ul>
					</div>
					<div class="checkbox-holder text-left">
						<img src="index.php?t=captchaimage" alt="captcha"/>
					</div>
					<input name="mycaptcha" type="text" class="form-control form-white" placeholder="Captcha text">
					<button type="submit" class="btn btn-submit">Αποστολή</button>
					<input type="hidden" name="FormAction" value="sendamail">
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<!--a href="#" class="close-link"><i class="icon_close_alt2"></i></a-->
				<h3 class="white">Sign Up</h3>
				<form name="registerform" action="call.php" method="post" class="popup-form">
					<input id="mode" type="hidden" name="mode" value="">
					<input name="fname" type="text" class="form-control form-white" placeholder="Full Name">
					<input name="uname" type="text" class="form-control form-white" placeholder="Email Address">
					<input name="pwd" type="password" class="form-control form-white" placeholder="Your password*">
					<input name="pwd2" type="password" class="form-control form-white" placeholder="Re-type your password">
					<div class="dropdown">
						<button id="dLabel" name="dLabel" class="form-control form-white dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Τομέας
						</button>
						<ul class="dropdown-menu animated fadeIn" role="menu" aria-labelledby="dLabel">
							<li class="animated lightSpeedIn"><a href="#" onClick="setMode(6);">e-Enterprise LP</a></li>
							<li class="animated lightSpeedIn"><a href="#" onClick="setMode(5);">B-Mail Monitor</a></li>
						</ul>
					</div>
					<div class="checkbox-holder text-left">
						<!--div class="checkbox">
							<input type="checkbox" value="None" id="squaredΤwo" name="checkterms" />
							<label for="squaredTwo"><span>Συμφωνώ με τους <strong>Όρους χρήσης</strong></span></label>
						</div-->
						<label for="squaredTwo">* Χρησιμοποιείστε 8 ή περισσότερους χαρακτήρες και αριθμούς</span></label>
					</div>
					<button type="submit" class="btn btn-submit">Αποστολή</button>
					<input type="hidden" name="FormAction" value="shreg">
				</form>
			</div>
		</div>
	</div>	
	<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<!--a href="#" class="close-link"><i class="icon_close_alt2"></i></a-->
				<h3 class="white">Login</h3>
				<form name="loginform" action="call.php" method="post" class="popup-form">
					<input id="info" type="hidden" name="info" value="info">
					<input name="Username" type="text" class="form-control form-white" placeholder="Your email">
					<input name="Password" type="password" class="form-control form-white" placeholder="Your password">
					<div class="checkbox-holder text-left">
						<div class="checkbox">
							<input type="checkbox" value="None" id="squaredThree" name="rempwd" onClick="remPass();"/>
							<label for="squaredThree"><span>Ανάκτηση κωδικού (συμπληρώστε το e-mail)</label>
						</div>
						<phpdac>cmslogin.recaptcha</phpdac>
					</div>
					<button id="sb" type="submit" class="btn btn-submit">Είσοδος</button>
					<input id="fa" type="hidden" name="FormAction" value="dologin">
				</form>
			</div>
		</div>
	</div>	