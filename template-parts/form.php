<form  class="form register-form" method="post">
	<?php ########################Begin of normal fields########################## ?>
	<div class="form-group">
		<div class="input-holder">
			<input  class="form-control" name="name"  type="text"  >				
			<label>Full Name</label>
			<div class="bar"></div>
		</div>
		<div class="tooltip"><i></i><p>Enter your First & Last name here</p></div>			
	</div>
	<div class="form-group">
		<div class="input-holder">
			<input  class="form-control" name="email" type="text"  >				
			<label>Email</label>
			<div class="bar"></div>
		</div>
		<div class="tooltip"><i></i><p>Enter your email</p></div>			
	</div>
	<div class="form-group">
		<div class="input-holder">
			<input  class="form-control datepicker" name="dob" type="text"  >				
			<label>Date Of Birth</label>
			<div class="bar"></div>
		</div>
		<div class="tooltip"><i></i><p>Pickup your date of birth</p></div>			
	</div>
	<div class="form-group">
		<div class="selcet-wrapper">
			<select class="form-control" name="category" >
				<option value="" selected disabled>Select</option>
				<option value="1">10K</option>
				<option value="2">Hal Marathon</option>
				<option value="3">Marathom</option>
			</select>
			<label>Race Category</label>
			<div class="bar"></div>
		</div>
		<div class="tooltip"><i></i><p>Select one of 3 categories (10K, Half Marathon, Marathon)</p></div>
	</div>
	<div class="button-wrapper">
		<div class="new-button blackish">
			<div class="new-button-inner ">REGISTER</div>
		</div>
	</div>
	<input type="hidden" name="c_age">
</form>