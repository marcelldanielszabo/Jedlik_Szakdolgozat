<?php  
	if (count($errors) > 0)
	{
			echo "<div class=\"error\">";
			foreach ($errors as $error)
			{
				echo "<p style=\"color:red;\">";
				echo $error;
				echo "</p>";
			}
			echo "</div>";
	}
?>
