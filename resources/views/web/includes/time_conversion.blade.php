<?php

$remaining_time=$remaining_time/60;
if($remaining_time<60)
			{
				$remaining_time=round($remaining_time). " mins ago";
			}
		else
		{
			$remaining_time=$remaining_time/60;
			if($remaining_time<24)
				{
					$remaining_time=round($remaining_time). " hours ago";  
				}
			else
			{
				$remaining_time=round($remaining_time/24). " days ago";
			}
		}
        echo $remaining_time;
    ?>