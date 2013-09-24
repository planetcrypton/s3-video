<?php
$video_dim = array('w'=>640,'h'=>360);
if( isset($_GET['tiny']) )
	$video_dim = array('w'=>550,'h'=>310);
?>
<html>
<head>
	<?php if ((empty($_GET['player'])) || ($_GET['player'] == 'flowplayer')) { ?>
			<?php $player = 'flowplayer'; ?>
    		<script type="text/javascript" src="<?php echo $_GET['base']; ?>js/flowplayer-3.2.12.js"></script>
    <?php } elseif( $_GET['player'] == 'jwplayer' ) {
    		$player = 'jwplayer';
    		if( isset($_GET['jwplayer_token']) && !empty($_GET['jwplayer_token']) ):
    		?>
    		<script src="http://jwpsrv.com/library/<?php echo $_GET['jwplayer_token']; ?>.js"></script>
    		<?php
    		elseif( isset($_GET['jwplayer_key']) && !empty($_GET['jwplayer_key']) ):
    		?>
    		<script type="text/javascript" src="<?php echo $_GET['base']; ?>js/jwplayer/jwplayer.js"></script>
    		<script type="text/javascript">jwplayer.key="<?php echo $_GET['jwplayer_key']; ?>";</script>
    		<?php endif; ?>
     <?php } else { ?>
    		<?php $player = 'videojs'; ?>
    		<link href="<?php echo $_GET['base']; ?>css/video-js.css" rel="stylesheet">
    		<script type="text/javascript" src="<?php echo $_GET['base']; ?>js/video.min.js"></script> 
    		<script>
    			_V_.options.flash.swf = "<?php echo $_GET['base']; ?>/misc/video-js.swf";
  			</script>   
    <?php } ?>
</head> 

<body>
	<div align="center">
		<?php if (!empty($_GET['media'])) { ?>
			<?php if ($player == 'flowplayer' ) { ?>
						<a href="<?php echo $_GET['media']; ?>" style="display:block;width:<?php echo $video_dim['w']; ?>px;height:<?php echo $video_dim['h']; ?>px"  id="video_preview" class="flowplayer"></a> 
						
						<script>
							flowplayer("video_preview", "<?php echo $_GET['base']; ?>misc/flowplayer-3.2.16.swf", {
							    clip:  {
							        autoPlay: false,
							        autoBuffering: true,
							        bufferLength: 5
							    }			
							});
						</script>
			<?php } elseif( $player == 'jwplayer' ) { ?>
				<div id="video_preview" class="jwplayer"></div>
				<script type="text/javascript">
				    jwplayer("video_preview").setup({
				        file: "<?php echo $_GET['media']; ?>",
				        width: <?php echo $video_dim['w']; ?>,
				        height: <?php echo $video_dim['h']; ?>,
				        //bufferlength: '15',
				        autostart: false
				    });
				</script>
			<?php } else { ?>
				<video id="video_preview" class="video-js vjs-default-skin" controls preload="auto" width="<?php echo $video_dim['w']; ?>" height="<?php echo $video_dim['h']; ?>" data-setup="{}">
				  <source src="<?php echo $_GET['media']; ?>" type='video/mp4'>
				</video>			
			<?php } ?>
		<?php } else { ?>
				<p>Media not found</p>
		<?php } ?>	
	</div>
</body>
</html>
