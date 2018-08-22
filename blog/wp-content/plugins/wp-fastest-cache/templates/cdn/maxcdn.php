<div id="wpfc-modal-maxcdn" style="top: 10.5px; left: 226px; position: absolute; padding: 6px; height: auto; width: 560px; z-index: 10001;">
	<div style="height: 100%; width: 100%; background: none repeat scroll 0% 0% rgb(0, 0, 0); position: absolute; top: 0px; left: 0px; z-index: -1; opacity: 0.5; border-radius: 8px;">
	</div>
	<div style="z-index: 600; border-radius: 3px;">
		<div style="font-family:Verdana,Geneva,Arial,Helvetica,sans-serif;font-size:12px;background: none repeat scroll 0px 0px rgb(255, 161, 0); z-index: 1000; position: relative; padding: 2px; border-bottom: 1px solid rgb(194, 122, 0); height: 35px; border-radius: 3px 3px 0px 0px;">
			<table width="100%" height="100%">
				<tbody>
					<tr>
						<td valign="middle" style="vertical-align: middle; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.5); padding-left: 10px; font-size: 13px; cursor: move;">MaxCDN Settings</td>
						<td width="20" align="center" style="vertical-align: middle;"></td>
						<td width="20" align="center" style="vertical-align: middle; font-family: Arial,Helvetica,sans-serif; color: rgb(170, 170, 170); cursor: default;">
							<div title="Close Window" class="close-wiz"></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="window-content-wrapper" style="padding: 8px;">
			<div style="z-index: 1000; height: auto; position: relative; display: inline-block; width: 100%;" class="window-content">


				<div id="wpfc-wizard-maxcdn" class="wpfc-cdn-pages-container">
					<div wpfc-cdn-page="1" class="wiz-cont">
						<h1>Let's Get Started</h1>		
						<p>Hi! If you don't have a <strong>MaxCDN</strong> account, you can create one. If you already have, please continue...</p>
						<div class="wiz-input-cont" style="text-align:center;">
							<a href="http://tracking.maxcdn.com/c/149801/3982/378" target="_blank">
								<button class="wpfc-green-button">Create a MaxCDN Account</button>
							</a>
					    </div>
					    <p class="wpfc-bottom-note" style="margin-bottom:-10px;"><a target="_blank" href="https://www.maxcdn.com/one/tutorial/implementing-cdn-on-wordpress-with-wp-fastest-cache/">Note: Please read How to Integrate MaxCDN into WP Fastest Cache</a></p>
					</div>
					<div wpfc-cdn-page="2" class="wiz-cont" style="display:none">
						<h1>Enter CDN Url</h1>		
						<p>Please enter your <strong>MaxCDN CDN Url</strong> below to deliver your contents via MaxCDN.</p>
						<div class="wiz-input-cont">
							<label class="mc-input-label" for="cdn-url" style="padding-right: 12px;">CDN Url:</label><input type="text" name="" value="" class="api-key" id="cdn-url">
					    	<div id="cdn-url-loading"></div>
					    	<label class="wiz-error-msg"></label>
					    </div>
					    <div class="wiz-input-cont">
							<label class="mc-input-label" for="origin-url">Origin Url:</label><input type="text" name="" value="" class="api-key" id="origin-url">
					    </div>
					</div>
					<div wpfc-cdn-page="3" class="wiz-cont" style="display:none">
						<h1>File Types</h1>		
						<p>Specify the file types within the to host with the CDN.</p>
						
						<?php include WPFC_MAIN_PATH."templates/cdn/file_types.php"; ?>
					</div>
					<div wpfc-cdn-page="4" class="wiz-cont" style="display:none">
						<?php include WPFC_MAIN_PATH."templates/cdn/specify_sources.php"; ?>
					</div>
					<div wpfc-cdn-page="5" class="wiz-cont" style="display:none">
						<h1>Ready to Go!</h1>
						<p>You're all set! Click the finish button below and that's it.</p>
					</div>
					<div wpfc-cdn-page="6" class="wiz-cont" style="display:none">
						<h1>Integration Ready!</h1>
						<p>Your static contents will be delivered via MaxCDN.</p>
					</div>


					<img class="wiz-bg-img" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAMAAAAL34HQAAAAIVBMVEVMaXHtVS7rUyzuVy/uVi/uWDD////97eP2rID60rnyh0dw+3WeAAAABXRSTlMAYyfQnK57FEkAAAPJSURBVHja5ZzRcuMwCEUDAsvS/3/wPnS27qa1BRIgpstrM8kpXONrWeL1+q2BiHAFIm4HAqBS+D1KIQLchUTfgd7ggtmGSBdbGBkCsSZCyFCap0gymGD6ACP0q94sFDMz+4AtQjmBrUM5gNlAMTOT5dXHdlHAKlVsGyaVNE2VWcLsVGWpMGKfKCuFxMJuASmp5gsJ7BuUkmquU/hTzQifmBNyxVBpuYA5IVccFXNJSSXvE8ickMu3t0/fh8KpmDFPa9BdjsA7gtIJSyQv4k2B+Uo46qrI+wISlvCxjLCT6v5qLFux7sq4N1l3qsfNybpJ102yqk20dvaZdN0l6zzsop3qdN0q67CM2rouXbfKaodtnJp03V+G3RjrqF2erofL0DpdTwlD+d3QPF0PXKS4G7ZALpRbB4d0HV0i+sF9p9pjVYnoB47GI11tXMWh/atxZQSFdzjj0lU0rjQwXajwf4HpAs2TRdzFSBpbeoZVsWgeeH7oEe3fqD+4mIc/3rd61DxaDGtwPv5sb1pxiR5a+/BL2yAbTSouUDzxnMMS1JF2qk7zIqw2+tE+TEbTaV70iD/MxTms8qlrqGVKWlVdZQesc0LxffiJJ8+Fc9IaK36og7qMVdcV38VWkMRYxygXM4pvT1hgovhxlZv05iPHGv+ndULx/cnPg4nix8Kp0gtRjjWh+DateDHWTDOdV/wCVnNUvBjLwD4IPqHGMrAPLJeWGMtF8W0Vy8c+nKtYPvahP7/PQINmOmEfPLAc7YMcK9Q+fD76lGXFmzZTKVasffj08rSseEv7IMaKtQ+fz4mgVXz1VXwRrUEE24drgatksg/XcmDJZB+u9S3KZB+u1UDIZB+utVPMZB++vC8oiezDl3V5SGQfiuydTw22DyR6JWxhH1SKR9H7RAv7oJFWkb19nbAPx4p9INmL/RqseJzcM+JrH4psh020fQDZ/rsdqw8C0QfbBxJuVwy2Dyjb3BlsH0i4uzPYPqBwL2ys4km6GTa2maJ06/D5Ld5/9NsH+vA7urBnpdg7/LDZeuvOU3hl3NRMr5RbwDHhmYfRqQdIWMJ9ZRyfqCn5SrjrPIbkFBmkpIrnkp6cpJRUwVzyU6aRXVVzSD6OS3d0P4pLO1Aghks/5iCCa2r4AqXpDJFc8wM0PPv9ynwWP4GtDUFBn0Kuj4yBZAX0K6TROCJIlypzhZlNbjKdSWQKZQXmMkdtFcxt6twCmOMovHnx+4801E/E803U3PjHKCbFsMyyZbwowj1bKdsmnn6wIQARlb9BRAD7B8T+X/EHj45eHFRJsacAAAAASUVORK5CYII="/>
				</div>
			</div>
		</div>
		<?php include WPFC_MAIN_PATH."templates/buttons.html"; ?>
	</div>
</div>



