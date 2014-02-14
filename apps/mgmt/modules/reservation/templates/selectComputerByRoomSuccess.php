
<option value=''>- - -</option>
<?php
foreach ($computers as $computer)
{
	echo "<option value='computer-".$computer->getId()."'>".$computer->getName()."</option>\n";
}

