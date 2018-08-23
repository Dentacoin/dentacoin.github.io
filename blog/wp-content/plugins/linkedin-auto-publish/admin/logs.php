<?php 
if( !defined('ABSPATH') ){ exit();}
?>
<div >


	<form method="post" name="xyz_smap_logs_form">
		<fieldset
			style="width: 99%; border: 1px solid #F7F7F7; padding: 10px 0px;">
			


<div style="text-align: left;padding-left: 7px;"><h3>Auto Publish Logs</h3></div>
	<span>Last five logs</span>
		   <table class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none;">
				<thead>
					<tr class="xyz_smap_log_tr">
						<th scope="col" width="1%">&nbsp;</th>
						<th scope="col" width="12%">Post Id</th>
						<th scope="col" width="12%">Post Title</th>
						<th scope="col" width="18%">Published On</th>
						<th scope="col" width="15%">Status</th>
					</tr>
					</thead>
					<?php 
					
					$post_ln_logsmain = get_option('xyz_lnap_post_logs' );

				if(is_array($post_ln_logsmain))
                                    {	
					$post_ln_logsmain_array = array();
					foreach ($post_ln_logsmain as $logkey => $logval)
					{
						$post_ln_logsmain_array[]=$logval;
					
					}
					
					if($post_ln_logsmain=='')
					{
						?>
						<tr><td colspan="4" style="padding: 5px;">No logs Found</td></tr>
						<?php
					}
					
					
					if(is_array($post_ln_logsmain_array))
					   {
						for($i=4;$i>=0;$i--)
						{
							if($post_ln_logsmain_array[$i]!='')
							{
								$post_ln_logs=$post_ln_logsmain_array[$i];
								$postid=$post_ln_logs['postid'];
								$acc_type=$post_ln_logs['acc_type'];
								$publishtime=$post_ln_logs['publishtime'];
								if($publishtime!="")
									$publishtime=xyz_lnap_local_date_time('Y/m/d g:i:s A',$publishtime);
								$status=$post_ln_logs['status'];
								
								?>
								<tr>
									<td>&nbsp;</td>
									<td  style="vertical-align: middle !important;padding: 5px;">
									<?php echo esc_html($postid);	?>
									</td>
									<td  style="vertical-align: middle !important;padding: 5px;">
									<?php echo get_the_title($postid);	?>
									</td>
									
									<td style="vertical-align: middle !important;padding: 5px;">
									<?php echo esc_html($publishtime);?>
									</td>
									
									<td style="vertical-align: middle !important;padding: 5px;">
									<?php
									
									
									if($status=="1")
									echo "<span style=\"color:green\">Success</span>";
									else if($status=="0")
									echo '';
									else
									{
										$arrval=unserialize($status);
										foreach ($arrval as $a=>$b)
										echo "<span style=\"color:red\">".$a." : ".$b."</span><br>";
										
									}
									
									?>
									</td>
								</tr>
								<?php  
							}
						}
					}
                                      }?>
				
           </table>
			
		</fieldset>

	</form>

</div>
				