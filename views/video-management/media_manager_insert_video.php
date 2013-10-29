<link rel="stylesheet" href="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/s3-video/css/style.css?ver=3.5.1" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/s3-video/css/colorbox.css?ver=3.5.1" type="text/css" media="all" />
<style type="text/css">.tools{display:none;}</style>

<!-- WP 3.5 -->
<!--<script type="text/javascript" src="<?php echo get_bloginfo('url'); ?>/wp-admin/load-scripts.php?c=0&load%5B%5D=jquery,utils&ver=3.5.1"></script>-->
<!-- WP 3.6 -->
<!-- <script type="text/javascript" src="<?php echo get_bloginfo('url'); ?>/wp-admin/load-scripts.php?c=1&amp;load%5B%5D=jquery-core,jquery-migrate,utils,plupload,plupload-html5,plupload-flash,plupload-silverlight,plupload-html4,json2&amp;ver=3.6.1"></script> -->
<!--
Current colorbox plugin uses jQuery.live() method which is deprecated sice Jquery 1.7 and removed since 1.9
Check http://stackoverflow.com/questions/14526033/object-has-no-method-live-jquery
So we can only load newer jQuery version when the colorbox plugin shipped with S3 is updated and vice-versa
-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type='text/javascript' src="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/s3-video/js/jquery.tablesorter.js?ver=1.0"></script>
<script type='text/javascript' src="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/s3-video/js/jquery.paginator.js?ver=1.0"></script>
<script type='text/javascript' src="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/s3-video/js/jquery.colorbox.js?ver=1.0"></script>



<script type="text/javascript">
console.log('jq',jQuery)
jQuery(function() {
	  var awsBucket = '<?php echo $pluginSettings['amazon_video_bucket']; ?>';
	  jQuery("#videoListTable").tablesorter();
	  jQuery("#videoListTable").paginateTable({ rowsPerPage: <?php echo $pluginSettings['s3_video_page_result_limit']; ?>});	  
	  	  
	  jQuery(".insertVideo").click(function(evt) {
			evt.preventDefault();
			var videoName = jQuery(this).attr("title");
			jQuery("#insertVideoName").val(videoName);
			jQuery("#insertVideoForm").submit();
	  });
	  
	  jQuery(".colorBox").colorbox({width:"600", height:"400", top:"70px", iframe:true});
	  
	  jQuery('.tools').show();// makes sure tools aren't clicked before page has loaded
});
</script>

<div class="wrap">

<strong>S3 Videos</strong>

<?php
	if( !isset($pluginSettings['amazon_s3_video_jwplayer_token']) ) $pluginSettings['amazon_s3_video_jwplayer_token'] = ''; // backward compatibily

	if ((!empty($existingVideos)) && (count($existingVideos) > 0)) {
?>
		<table id="videoListTable" class="tablesorter" cellspacing="0" >
			<thead>
				<tr>
					<th>File Name</th>
					<th>File Size</th>
					<th>Created</th>				
					<th>Actions</th>								
				</tr>
			</thead>
			
			<tbody>	
				<?php
					foreach($existingVideos as $existingVideo) {
						$fileExtension = strtolower(pathinfo($existingVideo['name'], PATHINFO_EXTENSION));
						$videoExtensions = array('mp4', 'mov', 'avi', 'flv', 'mpeg', 'mpg', 'wmv', '3gp', 'ogm', 'mkv', 'm4v');
						if (in_array($fileExtension, $videoExtensions)) {
				?>
							<tr>
								<td>
									<?php echo $existingVideo['name']; ?> 
								</td>
								
								<td>
									<?php echo s3_humanReadableBytes($existingVideo['size']); ?>
								</td>
								
								<td>
									<?php echo date('j/n/Y', $existingVideo['time']); ?>
								</td>
													
								<td class="tools">
									<?php
									if($pluginSettings['amazon_s3_video_jwplayer_hosted']=='cloud'){
										$jw_param = "&jwplayer_token=".$pluginSettings['amazon_s3_video_jwplayer_token'];
									}elseif($pluginSettings['amazon_s3_video_jwplayer_hosted']=='local'){
										$jw_param = "&jwplayer_key=".$pluginSettings['amazon_s3_video_jwplayer_key'];
									}else{
										$jw_param = "";
									}
									?>
									<a title="<?php echo $existingVideo['name']; ?>" href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/video-management/preview_video.php?base=<?php echo WP_PLUGIN_URL; ?>/s3-video/&player=<?php echo $pluginSettings['amazon_s3_video_player'] . $jw_param; ?>&media=<?php echo 'http://' . $pluginSettings['amazon_video_bucket'] .'.'.$pluginSettings['amazon_url'] . '/' .urlencode($existingVideo['name']); ?>&tiny=1" class="colorBox">
										Preview
									</a>
									 - 
									<a href="#" title="<?php echo $existingVideo['name']; ?>" class="insertVideo">
										Insert Video
									</a>											
								</td>
							</tr>
				<?php	
						}
					}
				?>
			</tbody>
		</table>
		<?php if (count($existingVideos) > $pluginSettings['s3_video_page_result_limit']) { ?>
        		<div align="center">
        			<div class='pager'>
        		        <a href='#' alt='Previous' class='prevPage'>Prev</a> - 
        		         Page <span class='currentPage'></span> of <span class='totalPages'></span>
        		         - <a href='#' alt='Next' class='nextPage'>Next</a>
        		        <br>
        		       	<span class='pageNumbers'></span>
        	   		</div>
        		</div>
    <?php } ?>
<?php 	
	} else {
?>
		<p>No media found in this bucket.</p>
<?php		
	}
?>

<form method="POST" id="insertVideoForm">
	<input type="hidden" name="insertVideoName" id="insertVideoName" value="" />
</form>

</div>

