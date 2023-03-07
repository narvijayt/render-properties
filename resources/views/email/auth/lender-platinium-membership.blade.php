
@foreach($users as $user)
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Email Template</title>
	<style type="text/css">

		#outlook a {padding:0;}
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
		a img {border:none;display:inline-block;}
		.image_fix {display:block;}
		
		h1, h2, h3, h4, h5, h6 {color: black !important;}

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
			color: red !important; 
		}

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
			color: purple !important; 
		}

		table td {border-collapse: collapse;}

		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }

		a {color: #000;}

		@media only screen and (max-device-width: 480px) {

			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: black; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: orange !important; /* or whatever your want */
				pointer-events: auto;
				cursor: default;
			}
		}


		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: blue; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: orange !important;
				pointer-events: auto;
				cursor: default;
			}
		}

		p {
			margin:0;
			color:#555;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			line-height:160%;
		}
		ul{
			margin:0;
			padding-left:0;
		}
		ul,li {
			margin:0;
			color:#222;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			line-height:160%;
			list-style:none;
			font-weight:normal;
		}
		li{
			margin-bottom:5px;
		}
		a.link2{
			text-decoration:none;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			color:#fff;
			border-radius:4px;
		}
		h2{
			color:#181818;
			font-family:Helvetica, Arial, sans-serif;
			font-size:22px;
			font-weight: normal;
		}

		.bgItem{
			background:#f7991f;
		}
		.bgBody{
			background:#f8f8f8;
		}
		
		.bgContent{
			background:#ffffff;
		}
		
		

	</style>

<script type="colorScheme" class="swatch active">
  {
    "name":"Default",
    "bgBody":"ffffff",
    "link":"f2f2f2",
    "color":"555555",
    "bgItem":"f7991f",
    "title":"181818"
  }
</script>

</head>
<body>
	<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
	<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody'>
		<tr>
			<td>

				<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->

				<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="border-collapse:collapse;">
					<tr>
						<td class='movableContentContainer'>
													
							<div class='movableContent'>
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="750" class="bgContent" style="border-bottom:1px solid #ddd;">
									
									<tr>										
										<td width="250" valign="middle" align="center" style="padding-top:20px; padding-bottom:20px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<a href="{{url('/')}}"><img src="{{asset('/img/logo.png')}}" width="250" alt='Logo'  data-default="placeholder" /></a>
												</div>
											</div>
										</td>
										<td width="250" valign="middle" align="center" style="padding-top:20px; padding-bottom:20px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
												<img src="{{asset('/img/partner-logo.png')}}" width="250" alt='partner-logo'  data-default="placeholder" />
												</div>
											</div>
										</td>
									</tr>									
								</table>
							</div>

							<div class='movableContent'>
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="750" class="bgContent">
									<tr>
										<td width="100%" colspan="3" align="center" style="padding-bottom:40px;padding-top:25px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<h2 style="font-weight:bold;text-align:center;">PLATINUM MEMBERSHIP OFFER</h2>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td width="100">&nbsp;</td>
										<td width="550" align="left" style="padding-bottom:5px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<p >Loan Officer Members,</p>
												</div>
											</div>
										</td>
										<td width="100">&nbsp;</td>
									</tr>
									
									<tr>
										<td width="100">&nbsp;</td>
										<td width="550" align="left" style="padding-bottom:20px; padding-top:5px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<p >Render will be introducing the new Platinum Membership to the public. Before that happens, existing members get the first shot to upgrade and <a target="_blank" style="font-weight:bold;" href="{{url('/platinum-membership-upgrade',[$user->user_id])}}">claim their Zip Code</a>.</p>
												</div>
											</div>
										</td>
										<td width="100">&nbsp;</td>
									</tr>

									<tr>
										<td width="100">&nbsp;</td>
										<td width="550" align="left" style="padding-bottom:20px; padding-top:5px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<p >Our top priority is to offer our members an unbeatable opportunity to expand their business, their network, and their clientele.</p>
												</div>
											</div>
										</td>
										<td width="100">&nbsp;</td>
									</tr>	
									
								</table>
							</div>

							<div class='movableContent'>
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="750" style="border-collapse:collapse;" class="bgContent">
									<tr>
										<td>
											<table cellpadding="0" style="border-collapse:collapse;" cellspacing="0" border="0" align="center" width="550">
												<tr>													
													<td width="400" valign="top">
														<br/>
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" >
																<p style="font-weight:600; color:#094b81; margin-bottom:15px; font-size:16px;">The new Platinum Membership will combine:</p>
																<ul>	


																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> New Lending Tree Partnership</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> SEO</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> Content Marketing</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> Blogs & Podcast</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> Educational Videos & Resources</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> SEM</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> Social Media Marketing</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> Geo-fencing</li>
																</ul>
																
															</div>
														</div>														
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
							
							
							<div class='movableContent'>
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="750" style="border-collapse:collapse;" class="bgContent">
									<tr>
										<td>
											<table cellpadding="0" style="border-collapse:collapse;" cellspacing="0" border="0" align="center" width="550">
												<tr>													
													<td width="400" valign="top" style="padding-top:20px;padding-bottom:20px;">
														
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" >
																<p style="font-weight:600; color:#094b81; margin-bottom:15px; font-size:16px;">To provide our Platinum Members with:</p>
																<ul>										<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> More Traffic</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> More Conversions</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> More Followers</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> More Realtors</li>
																	<li><img src="{{asset('/img/check_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> More Visibility</li>
																	<li><img src="{{asset('/img/heck_icon.png')}}" alt="" width="20" style="margin-right:10px; vertical-align:middle;"/> More Business</li>	
																</ul>
																
															</div>
														</div>														
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
							
							
							<div class='movableContent'>
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="750" class="bgContent">
									<tr>
										<td width="100">&nbsp;</td>
										<td width="550" align="left" style="padding-bottom:5px; padding-top:5px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<p><a href="{{url('/')}}" target="_blank" style="color:#f7991f; text-decoration:none; font-weight:bold;">Render</a> has partnered with <a href="https://www.lendingtree.com/" target="_blank" style="color:#0BA57C; text-decoration:none; font-weight:bold;">Lending Tree</a> to give Platinum Members exclusive access to the largest mortgage lead funnel in the Nation! </p>
												</div>
											</div>
										</td>
										<td width="100">&nbsp;</td>
									</tr>	

									<tr>
										<td width="100">&nbsp;</td>
										<td width="550" align="left" style="padding-bottom:5px; padding-top:5px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<p >Platinum Members have the unique opportunity to be featured on Render's Blog, Podcast, Youtube Channel and Social Media Outlets; Not to mention our weekly email blast to real estate agents. It's time to take your business to the next level. Sign up now and claim your zip code.</p>
												</div>
											</div>
										</td>
										<td width="100">&nbsp;</td>
									</tr>
									
									<tr>
										<td width="100">&nbsp;</td>
										<td width="550" align="center" style="padding-bottom:20px; padding-top:20px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<p >Click below for pricing and early access to the Platinum Membership.</p>
												</div>
											</div>
										</td>
										<td width="100">&nbsp;</td>
									</tr>
									
								</table>
							</div>
							
							
							<div class='movableContent'>
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="750" class="bgContent">
									<tr>
										<td width="100">&nbsp;</td>
										<td width="400" align="center" style="padding-top:25px;padding-bottom:100px;">
											<table cellpadding="0" cellspacing="0" border="0" align="center" width="200" height="50">
												<tr>
													<td bgcolor="#0080e4" align="center" style="border-radius:4px;" width="200" height="50">
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" >
																<a target='_blank' href="{{url('/platinum-membership-upgrade',[$user->user_id])}}" class='link2'>Claim your Zip Code</a>
															</div>
														</div>

													</td>
												</tr>
											</table>
										</td>
										<td width="100">&nbsp;</td>
									</tr>
								</table>
							</div>
							
							
							
							
							
							<div class='movableContent'>
								
<!-- END BODY -->

			</td>
		</tr>
	</table>
	<!-- End of wrapper table -->
</body>
</html>


@endforeach

