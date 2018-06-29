<div id="osm-admin" class="osm-maintenance wrap">
	<div id="icon-link-manager" class="icon32"><br></div>
	<h2><?php echo __( 'OSM Maintenance', 'osm_maintenance' ); ?></h2>
	
	<form method="POST" action="admin.php?page=osm-maintenance" id="osm-maintenance">
		<h2>Add an IP Address to Whitelist</h2>
		<label for="ip_address">IP Address:</label>
		<input type="text" name="ip_address" id="ip_address" size="20" maxlength="20" />
		<input type="submit" name="osm_submit" id="osm_submit" value="Save IP Address" class="button-primary"  />
	</form>
	
	<div class="ip-list">
		<h2>Whitelisted IP Addresses</h2>
		<ul>
		<?php if (count($ipArray) > 1) { ?>
			<?php foreach($ipArray as $ip) { ?><li>
				<?php if ($ip != "") { ?>
				<li><?=$ip?> | <a href="admin.php?page=osm-maintenance&delete=true&ip=<?=$ip?>" class="remove">Remove</a></li>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		</ul>
	</div>
</div>