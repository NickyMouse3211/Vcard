<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/login/style.css');?>">
<div class='body-login hidden-object' id='form-login'>

    <div class="wrapper-login" id='wraper'>
		<div class="container-login">
			<h1 id='notif'>Welcome</h1>
			
			<form class="form-login">
				<input type="email" class='form-input-login' id='email-login' placeholder="Email Address">
				<input type="password" class='form-input-login' id='password' placeholder="Password">
				<button type="submit" class='form-button-login' id="login-button">Login</button>
			</form>
		</div>
	
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>
<script type="text/javascript" src="<?=base_url('public/js/login/index.js');?>"></script>
<script type="text/javascript">
	$('#login-button').click(function () {
	      $.ajax({
	        type:"POST",
	        cache:false,
	        url:"<?=base_url('sign/sign_in')?>",
	        data: { email : $('#email-login').val() , pass : $('#password').val() } ,    // multiple data sent using ajax
	        success: function (html) {

	          if(html == '0')
	          {
	          		document.getElementById('wraper').className += "-gagal";
	          		document.getElementById('notif').innerHTML = 'Gagal Login';
	          		timedRefresh(5000);
	          }
	          else if(html == '1')
	          {
	          		timedRefresh(5000);
	          }
	        }
	      });
	      return false;
	    });
	function timedRefresh(timeoutPeriod) {
		setTimeout("location.reload(true);",timeoutPeriod);
	}
</script>