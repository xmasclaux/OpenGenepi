<?php 

echo $startdate."<br>\n";
echo $stopdate."<br>\n";

?>

<div style='margin-top:20px;'>
	<input style="float:right; margin-top:18px;" type="button" id="back-button" value=<?php echo __('Close')?> onclick="$('#event_detail').dialog('close');">
</div>
