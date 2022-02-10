<form action="users/savebasicdetails.php" method="post" id="frmuserbasicdetails">
	<span class="usercreatestatus"></span>
	<div class="form-group">
	    <label for="exampleInputEmail1">First Name</label>
	    <input type="firstname" name="firstname" class="form-control" id="firstname" aria-describedby="emailHelp" placeholder="Enter First Name">
	    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
	</div>
	<div class="form-group">
	    <label for="exampleInputEmail1">Last Name</label>
	    <input type="lastname" name="lastname" class="form-control" id="lastname" aria-describedby="emailHelp" placeholder="Enter Last Name">
	    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
	</div>
	<div class="form-group">
	    <label for="exampleInputEmail1">Work Email Address</label>
	    <input type="email" name="emailaddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
	    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input name="password" type="password" class="form-control" id="password" placeholder="Password">
	</div>
</form>