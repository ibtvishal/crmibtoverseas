<?php

$sql=mysql_query("select content from tbl_content where status='1' and id='".$content_id."'");
$get_data=mysql_fetch_assoc($sql);
if($get_data)
{
echo $get_data['content'];

}
else
{
	echo 'Updating..';
}
?>