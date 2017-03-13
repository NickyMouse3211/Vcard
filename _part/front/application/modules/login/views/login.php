<!-- Profile -->

<div id="profile"> 
 	<!-- About section -->
	<div class="wrap-form-login" style="width:100%; text-align: center; margin: 50px 0;">
        <h3 class="main-heading"><span>Login User</span></h3>
    	<form method="post" class="form-login" id="contactform">
            <p>
                <label for="email">Email</label>
                <input type="text" name="email" class="input" >
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" class="input">
            </p>
            <input type="submit" name="submit" value="Login" class="submit">
        </form>
    </div>
    <!-- /About section -->
</div>        
<!-- /Profile --> 

<!-- Menu -->
<div class="menu">
	<ul class="tabs">
    	<li><a href="#profile" class="tab-profile">Login</a></li>
    	<li><a href="#contact" class="tab-profile">Register</a></li>
    </ul>
</div>
<!-- /Menu -->

<!-- Contact -->
<div id="contact">
    <!-- Contact Form -->
    <div class="contact-form">
        <h3 class="main-heading"><span>Register User</span></h3>
        <div id="contact-status"></div>
        <form method="post" class="form-register" id="contactform">
            <p>
                <label for="link">Your Link For Vcard</label>
                <input type="text" class="input" value="http://Vcard.com/" style="width: 110px;display: inline-block;" disabled>
                <input type="text" name="link" class="input" style="width: 45%;display: inline-block;">
            </p>
            <p>
            	<label for="name">Your Name</label>
            	<input type="text" name="name" class="input" >
            </p>
            <p>
            	<label for="email">Your Email</label>
                <input type="text" name="email" class="input">
            </p>
            <p>
                <label for="password">Your Password</label>
            	<input type="password" name="password" class="input">
            </p>
            <p>
                <label for="c_password">Your Confirmation Password</label>
                <input type="password" name="c_password" class="input">
            </p>
            <input type="submit" name="submit" value="Register" class="submit">
        </form>
    </div>
    <!-- /Contact Form -->
</div>

<script type="text/javascript" charset="utf-8" async defer>
    $(document).on('submit', '.form-login', function(e) {
        var data = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url('login/act_login') ?>',
            type: 'POST',
            dataType: 'json',
            data: data
        })
        .done(function(out) {
            if (out.status) {
                toastr.success(out.msg);
            } else{
                toastr.error(out.msg);
            }
        });
        
        e.preventDefault();
    });

    $(document).on('submit', '.form-register', function(e) {
        var data = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url('login/register') ?>',
            type: 'POST',
            dataType: 'json',
            data: data
        })
        .done(function(out) {
            if (out.status) {
                toastr.success(out.msg);
            } else{
                toastr.error(out.msg);
            }
        });
        
        e.preventDefault();
    });
</script>