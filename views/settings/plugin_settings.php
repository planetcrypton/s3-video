<script type="text/javascript">
	jQuery(function() {
			jQuery("#pluginSettings").validate({
				errorLabelContainer: jQuery("#validationError"),
				messages: {
					amazon_access_key: {
					    required: 'Please enter an Amazon API access key<br>'
					},			
			
					amazon_secret_access_key: {
					    required: 'Please enter an Amazon API shared key<br>'
					},      	        
	
					amazon_video_bucket: {
					    required: 'Please enter the name of the bucket your videos are stored in<br>'
					}, 	        	        
			 	}
			});
			
			JT_init();
	
			jQuery(':input[placeholder]').placeholder();
			
			
			// Dis- or enable jwplayer_token element
			// get enebaled when JWplayer is chosen
			// when enabled it must be filled out since the field is required
			var disable_jwplayer_token = function(checkbox){
				if( checkbox.prop('checked') && checkbox.val() == 'jwplayer' ){
					jwplayer_token_el.prop('disabled', false).removeClass('disabled');
				}else{
					jwplayer_token_el.prop('disabled', true).addClass('disabled');
				}
			}
			var jwplayer_token_el = jQuery('#jwplayer_token');
			jQuery('input[name = "video_player"]').change( function(evt){
				disable_jwplayer_token( jQuery(this) )
			});
			disable_jwplayer_token( jQuery('input[name = "video_player"]:checked') );
		
	});	
</script>

<div class="wrap">
	<h2>Plugin Settings</h2>

	<div id="validationError"></div>
	
	<?php if (!empty($successMsg)) { ?>
			<div id="successMsg">
				<?php echo $successMsg; ?>
			</div>
	<?php } ?>
	<form method="POST" id="pluginSettings">	
		<table>
			<tr>
				<td>
					<p>
						<strong>AWS Details:</strong>
					</p>
				</td>

				<td>
				</td>
			</tr>
						
			<tr>
				<td class="heading">
					<em>*</em>
					Access Key ID: 
				</td>

				<td>
					<input type="text" name="amazon_access_key" class="required" maxlength="21" placeholder="Amazon Access Key" value="<?php echo $pluginSettings['amazon_access_key']; ?>">
				</td>
			</tr>

			<tr>
				<td class="heading">
					<em>*</em>
					Secret Access Key: 
				</td>

				<td>
					<input type="text" name="amazon_secret_access_key" class="required" maxlength="50" placeholder="Secret Access Key" value="<?php echo $pluginSettings['amazon_secret_access_key']; ?>">
				</td>
			</tr>

			<tr>
				<td class="heading">
					<em>*</em>
					Video Bucket: 
				</td>

				<td>
					<input type="text" name="amazon_video_bucket" class="required" maxlength="50" placeholder="Amazon Video Bucket" value="<?php echo $pluginSettings['amazon_video_bucket']; ?>">
				</td>
			</tr>
			
			<tr>
				<td class="heading">
					Video Folder Location (whithin the bucket): 
				</td>

				<td>
					<input type="text" name="amazon_video_folder"  maxlength="50" placeholder="Amazon Video Folder" value="<?php echo $pluginSettings['amazon_video_folder']; ?>">
				</td>
			</tr>
			
            <tr>
                <td class="heading">
                   Fetch prefix:
                </td>

                <td>
                    <input type="text" name="amazon_prefix" placeholder="Prefix"  value="<?php echo $pluginSettings['amazon_prefix']; ?>"> 
                    - <a href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/tips/s3_prefix.html" class="jTip" id="fetchPrefixTip">More Info?</a>
                </td>
            </tr>
            
			<tr>
				<td class="heading">
					S3 Host: 
				</td>

				<td>
					<input type="text" name="amazon_url" placeholder="s3.amazonaws.com"  value="<?php echo $pluginSettings['amazon_url']; ?>">
				</td>
			</tr>

			<tr>
				<td>
					<br>
					<p>
						<strong>General Settings:</strong>
					</p>
				</td>

				<td>
				</td>
			</tr>
			
			<tr>
				<td class="heading">
					<em>*</em>
					# Of Video Results Per Page: 
				</td>

				<td>
					<?php 
						if (empty($pluginSettings['s3_video_page_result_limit'])) {
							$pluginSettings['s3_video_page_result_limit'] = 15;
						}
					?>
					<input type="text" name="page_result_limit" value="<?php echo $pluginSettings['s3_video_page_result_limit']; ?>" class="required">					
				</td>
			</tr>

			<tr>

				<td class="heading">
					Video Player: 
				</td>

				<td>
					<?php
					$checked_html = " checked";
					$flowplayer_checked = "";
					$videojs_checked = "";
					$jwplayer_checked = "";
					
					switch( $pluginSettings['amazon_s3_video_player'] ){
						case "videojs":
							$videojs_checked = $checked_html;
							break;
						case "jwplayer":
							$jwplayer_checked = $checked_html;
							break;
						default:
							$flowplayer_checked = $checked_html;
							break;
					}
					?>
					<input type="radio" name="video_player" value="flowplayer"<?php echo $flowplayer_checked; ?>> Flowplayer 
					- <a href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/tips/flowplayer_info.html" class="jTip" id="flowplayerTip">More Info?</a> 							
					- <a href="http://flowplayer.org/" target="_blank">Player Website</a>
					<br />
					<input type="radio" name="video_player" value="videojs"<?php echo $videojs_checked; ?>> VideoJS 
					- <a href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/tips/videojs_info.html" class="jTip" id="videojsTip">More Info?</a>							
					- <a href="http://videojs.com/" target="_blank">Player Website</a>		
					<br />
					<input type="radio" name="video_player" value="jwplayer"<?php echo $jwplayer_checked; ?>> JWplayer 
					- <a href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/tips/jwplayer_info.html" class="jTip" id="jwplayerTip">More Info?</a>							
					- <a href="http://www.longtailvideo.com/jw-player/" target="_blank">Player Website</a>	
					
					<br>
					<?php /*
					<label for="jwplayer_key"><?php echo _('JW Player Licence Key', 's3video'); ?></label>
					<input type="text" id="jwplayer_key" name="jwplayer_key" value="<?php echo $pluginSettings['amazon_s3_video_jwplayer_key']; ?>">
					*/?>
					<label for="jwplayer_token"><?php echo _('JW Player Cloud Hosted Code / Token', 's3video'); ?></label>
					<input type="text" id="jwplayer_token" name="jwplayer_token" class="required" value="<?php echo $pluginSettings['amazon_s3_video_jwplayer_token']; ?>" disabled>
				</td>
			</tr>			

			<tr>

				<td class="heading">
					Default Player Size: 
				</td>

				<td>
					<?php if ((empty($pluginSettings['amazon_s3_video_playerwidth'])) || (empty($pluginSettings['amazon_s3_video_playerheight']))) { ?>
							Width: <input type="text" name="video_playerwidth" value="530" size="4"> px <a href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/tips/player_dimensions.html" class="playerDimensionsTip" id="three">More Info?</a>
							<br />
							Height: <input type="text" name="video_playerheight" value="330" size="4"> px
					<?php } else { ?>
							Width: <input type="text" name="video_playerwidth" value="<?php echo $pluginSettings['amazon_s3_video_playerwidth']; ?>" size="4"> px -
							<a href="<?php echo WP_PLUGIN_URL; ?>/s3-video/views/tips/player_dimensions.html" class="jTip" id="playerDimensionsTip">More Info?</a>
							<br />
							Height: <input type="text" name="video_playerheight" value="<?php echo $pluginSettings['amazon_s3_video_playerheight']; ?>" size="4"> px							
					<?php } ?>		
				</td>
			</tr>			

			<tr>
				<td>
					<br>
					<p>
						<strong>Single Video Playback:</strong>
					</p>
				</td>

				<td>
				</td>
			</tr>
			
			<tr>
				<td class="heading">
					Autoplay: 
				</td>

				<td>
					<?php if ((empty($pluginSettings['amazon_s3_video_autoplay'])) || ($pluginSettings['amazon_s3_video_autoplay'] ==0)) { ?>
							True<input type="radio" name="video_autoplay" value="1">
							False<input type="radio" name="video_autoplay" value="0" checked>
					<?php } else { ?>	
							True<input type="radio" name="video_autoplay" value="1" checked>
							False<input type="radio" name="video_autoplay" value="0">
					<?php } ?>				
				</td>
			</tr>
			
			<tr>
				<td class="heading">
					Autobuffer: 
				</td>

				<td>
					<?php if ((empty($pluginSettings['amazon_s3_video_autobuffer'])) || ($pluginSettings['amazon_s3_video_autobuffer'] ==0)) { ?>
							True<input type="radio" name="video_autobuffer" value="1">
							False<input type="radio" name="video_autobuffer" value="0" checked>
					<?php } else { ?>	
							True<input type="radio" name="video_autobuffer" value="1" checked>
							False<input type="radio" name="video_autobuffer" value="0">
					<?php } ?>		
				</td>
			</tr>		

			<tr>
				<td>
					<br>
					<p>
						<strong>Video Playlist Playback:</strong>
					</p>
				</td>

				<td>
				</td>
			</tr>
			
			<tr>
				<td class="heading">
					Autoplay: 
				</td>

				<td>
					<?php if ((empty($pluginSettings['amazon_s3_playlist_autoplay'])) || ($pluginSettings['amazon_s3_playlist_autoplay'] == 0)) { ?>
							True<input type="radio" name="playlist_autoplay" value="1">
							False<input type="radio" name="playlist_autoplay" value="0" checked>
					<?php } else { ?>	
							True<input type="radio" name="playlist_autoplay" value="1" checked>
							False<input type="radio" name="playlist_autoplay" value="0">
					<?php } ?>				
				</td>
			</tr>
			
			<tr>
				<td class="heading">
					Autobuffer: 
				</td>

				<td>
					<?php if ((empty($pluginSettings['amazon_s3_playlist_autobuffer'])) || ($pluginSettings['amazon_s3_playlist_autobuffer'] == 0)) { ?>
							True<input type="radio" name="playlist_autobuffer" value="1">
							False<input type="radio" name="playlist_autobuffer" value="0" checked>
					<?php } else { ?>	
							True<input type="radio" name="playlist_autobuffer" value="1" checked>
							False<input type="radio" name="playlist_autobuffer" value="0">
					<?php } ?>		
				</td>
			</tr>		
								
			<tr>
				<td> 
				</td>

				<td>
					<div align="center">
						<input type="submit" value="Save" class="button">
					</div>
				</td>
			</tr>
		</table>
		
	</form>
</div>
