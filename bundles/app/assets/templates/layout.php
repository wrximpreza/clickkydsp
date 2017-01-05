<?php $this->layout('app:html');?>
<nav class="navbar navbar-default" >
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="/">
                <img src="/web/bundles/image/logo-clickky.svg" alt="logo" class="logo-smart">
                <strong>Clickky</strong>
			</a>
		</div>

		<div class="nav navbar-nav navbar-right">
			<?php if($user): ?>
				<p class="navbar-text">
					<?=$user->email?>
					<a class="navbar-link" href="<?=$this->httpPath(
						'app.action',
						array('processor' => 'auth', 'action' => 'logout')
					)?>"> <span class="glyphicon glyphicon-log-out"></span></a>
				</p>
			<?php else: ?>
				<li><a href="<?=$this->httpPath(
						'app.processor',
						array('processor' => 'auth')
					)?>">Login</a></li>
			<?php endif;?>
		</div>
	</div>
</nav>

<?php $this->childContent(); ?>