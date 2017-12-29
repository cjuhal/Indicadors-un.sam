<?php
/* 
 * checkLogIn.php
 * method: POST
 *
 */
try {
	if (isset($_POST['btnSubmit'])) {
		$auth = new Authentication();

		$user = $_POST['user'];
		$pass = $_POST['pass'];

		if($auth->validar_usuario($user, $pass))
		{
			$auth->iniciar_sesion();
			header("Location: index.php");
		}else
		{
			?>
			<script>
	      msgToast ('<?php echo utf8_decode($auth->response['error']); ?>','', false);
			</script>
			<?php
		}
	}else
	{
		throw new Exception("Error Processing Request", 1);
		
	}
	
} catch (Exception $e) {
	?>
	<script>
	  msgToast ('<?php echo $e->getMessage(); ?>','', false);
	</script>
	<?php
}
?>