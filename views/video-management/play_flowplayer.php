
<a href="{videoFile}" style="display:block;width:{videoWidth}px;height:{videoHeight}px"  id="flowplayer_{playerId}"></a> 		
<script>
	flowplayer("flowplayer_{playerId}", '{flowplayerLocation}', {
		log: { level: 'warn' },
		clip:  {
			autoBuffering: {videoAutoBuffer},
			autoPlay: {videoAutoPlay},
			bufferLength: 5			
		},
		{videoPlaylist}
	});
</script>
