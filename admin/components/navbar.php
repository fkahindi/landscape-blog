<?php require_once __DIR__ .'/../../config.php'; ?>
<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header navb-left">	
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="<?php echo BASE_URL ?>index.php" data-toggle="tooltip" data-placement="auto bottom"  title="Click to move to home page">Vipingo Hills Landscapers</a>
		</div>	
		<div class="collapse navbar-collapse" id="myNavbar">
			<div class=" nav navbar-nav navbar-right">
				<span><?php echo $_SESSION['username']?></span><br>
				<a href="<?php echo BASE_URL ?>includes/logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
			</div>
		</div>
	</div>			
</nav>