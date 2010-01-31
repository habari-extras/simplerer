<?php include 'header.php'; ?>
		<div id="content">
			<div id="post-<?php echo $post->id; ?>" class="<?php echo $post->statusname; ?> post">
				<h2 class="title"><a href="<?php echo $post->permalink; ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h2>
				<div class="entry">
					<?php echo $post->content_out; ?>
				</div>
				
				<?php if ( $user->loggedin ) { ?><p class="meta"><a href="<?php URL::out( 'admin', 'page=publish&id=' . $post->id); ?>" title="<?php _e('Edit post'); ?Y"><?php _e('Edit'); ?></a></p><?php } ?>

			</div>
		</div>
<?php include 'footer.php'; ?>