<h1><?php echo $title; ?></h1>
<div id="navpanel">
<?php foreach ($nav as $link=>&$info): ?>
	<div class="fleft">
		<div class="icon">
			<a href="<?php echo $_base,'/',$module,$link; ?>" title="<?php echo $info['desc']; ?>">
				<img src="<?php echo $_base,$info['imag']; ?>" alt="<?php echo $info['name']; ?>" align="middle" />
				<span><?php echo $info['name']; ?></span>
			</a>
		</div>
	</div>
<?php endforeach; ?>
</div>
