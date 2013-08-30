<div id="player{playerId}">Loading..</div>
<script type="text/javascript">
    jwplayer("player{playerId}").setup({
        file: "{videoFile}",
        image: "{videoStill}",
        width: {videoWidth},
        height: {videoHeight},
        //bufferlength: '15',
        autostart: {videoAutoPlay}
    });
</script>