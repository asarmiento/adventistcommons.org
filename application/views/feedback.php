<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-10 col-lg-11">
			<div class="page-header">
				<h1>Feedback</h1>
				<p class="lead">If you have any feedback or encounter any bugs &#128030;, please notify us below. Being very specific will help us reproduce the issue and solve the problem.</p>
			</div>
		</div>
		<div class="col-lg-6">
			<form action="/home/send_feedback" method="post" class="text-left auto-submit">
				<input type="hidden" name="user_id" value="<?php echo $this->ion_auth->logged_in() ? $this->ion_auth->user()->row()->id : ""; ?>">
				<input type="hidden" name="referer" value="<?php echo $_SERVER["HTTP_REFERER"]; ?>">
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo $this->ion_auth->logged_in() ? $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name : ""; ?>">
				</div>
				<div class="form-group">
					<input class="form-control" type="email" placeholder="Email" name="email" value="<?php echo $this->ion_auth->logged_in() ? $this->ion_auth->user()->row()->email : ""; ?>">
				</div>
				<div class="form-group">
					<textarea class="form-control" type="text" placeholder="Message" rows="8" name="message"></textarea>
				</div>
				<button class="btn btn-lg btn-block btn-primary" role="button" type="submit">
					Send Feedback
				</button>
			</form>
		</div>
	</div>
</div>