<?php
	ob_start();
	include_once 'include/db_connection.php';
	include_once 'include/user_group_access.php';

	date_default_timezone_set("Asia/Kuala_Lumpur");
	$datetime = date('Y-m-d H:i:s');
	
	$id = $_SESSION['aims_id'];
	$username = $_SESSION['aims_username'];
	$email = $_SESSION['aims_email'];
	$user_group_id = $_SESSION['aims_user_group_id'];
	if (!isset($id)) {
		header('location: /aims/logout');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="include/icon/favicon.ico">

		<title>Assets Information and Management System</title>

		<script src="include/js/jquery-2.1.3.min.js"></script>
		<script src="include/js/jquery-ui.min.js"></script>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="include/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="include/DataTables/datatables.min.css" />
		<link rel="stylesheet" type="text/css" href="include/css/jquery.mCustomScrollbar.min.css" />
		<!-- sweetalert -->
		<script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>

		<style>
			@font-face {
				font-family: Poppins;
				src: url("http://localhost/aims/include/fonts/Poppins-Regular.otf");
			}

			:root {
				/* dark blue */
				--primary-dark: #211d5a;

                /* light blue */
				--primary-light: #e6f7ff;

				/* dark olive green */
				--primary-info: #556B2F;

				/* orange red */
				--primary-default: #ee3923;

				/* light blue */
				--primary-default2: #e6f7ff	;
				
				--sidebar-width: 200px;
				--header-height: 60px;
				--footer-height: 30px;
			}

			.color-default {
				color: #e6f7ff;
			}

			.color-pending {
				/* Tangerine Orange */
				color: #e6f7ff;
			}

			.color-reserved {
				/* Coral Orange */
				color: #e6f7ff;
			}

			.color-shipment {
				/* Navy Blue */
				color: #e6f7ff;
			}

			.color-on-port {
				/* Olive Green */
				color: #e6f7ff;
			}

			.color-completed {
				/* Seafoam Green */
				color: #e6f7ff;
			}

			.color-incomplete {
				/* Tangerine Orange */
				color: #e6f7ff;
			}

			.color-pending-inspection {
				color: #e6f7ff;
			}

			a,
			a:hover,
			a:focus {
				color: inherit;
				text-decoration: none;
				transition: all 0.3s;
			}

			body {
				background-color: var(--primary-light);
			}

			.modal-backdrop {
				display: none;
			}

			/* ---------------------------------------------------
			SIDEBAR STYLE
		----------------------------------------------------- */

			.wrapper {
				display: flex;
				width: 100%;
			}

			#sidebar {
				width: var(--sidebar-width);
				position: fixed;
				top: 0;
				left: 0;
				padding-bottom: var(--footer-height);
				height: 100%;
				z-index: 100;
				background-color: var(--primary-dark);
				color: #fff;
				transition: all 0.3s;
			}

			#sidebar.active {
				background-color: var(--primary-default);
				margin-left: calc(-1 * var(--sidebar-width));
			}

			.sidebar-header {
				display: flex;
				justify-content: center;
				align-items: center;
				width: var(--sidebar-width);
				height: var(--header-height);
				background-color: var(--primary-dark);
			}

			.sidebar-header img {
				height: 100px; 
				margin-top: 50px; 
			}

			#sidebar ul.components {
				padding: 0;
			}

			#sidebar ul p {
				color: white;
				padding: 10px;
			}

			.svg-icon {
				width: 24px;
				height: 24px;
				fill: white;
				float: left;
			}

			.svg-icon-active {
				width: 24px;
				height: 24px;
				fill: var(--primary-dark);
				float: left;
			}

			#sidebar ul li a, #submenu-container ul li a {
				color: white;
				padding: 0.5em 15px;
				font-size: 0.95rem;
				display: block;
				text-decoration: none;
			}

			#sidebar ul li a:hover, #submenu-container ul li a:hover {
				color: var(--primary-dark);
				background-color: #ee3923;
				text-decoration: none;
				cursor:pointer;
			}

			#sidebar ul li a:hover .svg-icon {
				fill: var(--primary-dark);
			}

			#sidebar ul li.active>a {
				color: var(--primary-dark);
				background-color: var(--primary-light);
			}

			#sidebar ul li.active .svg-icon {
				fill: var(--primary-dark);
			}

			a[data-toggle="collapse"] {
				position: relative;
			}

			.dropdown-toggle::after {
				display: block;
				position: absolute;
				top: 50%;
				right: 20px;
				transform: translateY(-50%);
			}

			ul ul a {
				font-size: 0.95em !important;
				padding-left: 30px !important;
				background-color: var(--primary-dark);
			}

			#sidebar-footer {
				display: flex;
				justify-content: space-around;
				align-items: center;
				position: fixed;
				bottom: 0;
				width: var(--sidebar-width);
				height: var(--footer-height);
				background-color: white;
			}

			.siderbar-footer-svg {
				display: block;
				margin: auto;
			}

			/* SUB MENU */
			#submenu-container {
				position: absolute;
				z-index: 9999;
				left: var(--sidebar-width);
				border: 1px solid #ccc;
				background-color: var(--primary-dark);
				color: #fff;
				padding-left:0;
				overflow: visible;
			}

			ul.list-unstyled.components {
				margin-top: 70px !important;
				margin-left: 20px;
			}


			/* ---------------------------------------------------
			TOP BAR STYLE
		----------------------------------------------------- */
			#topbar {
				display: flex;
				justify-content: space-between;
				align-items: center;
				position: fixed;
				top: 0;
				width: calc(100% - var(--sidebar-width));
				height: var(--header-height);
				background-color: white;
				z-index: 200;
			}

			#topbar.active {
				width: 100%;
			}

			/* ---------------------------------------------------
			CONTENT STYLE
		----------------------------------------------------- */

			#content-box {
				width: calc(100% - var(--sidebar-width));
				min-height: 100vh;
				transition: all 0.3s;
				position: absolute;
				top: 0;
				right: 0;
			}

			#content-box.active {
				width: 100%;
				color: black;
				background-color: var(--primary-light);
			}

			#content {
				position: fixed;
				top: var(--header-height);
				bottom: var(--footer-height);
				width: calc(100% - var(--sidebar-width));
				height: calc(100vh - var(--header-height) - var(--footer-height));
				padding: 20px;
			}

			#content.active {
				width: 100%;
			}

			main, .main {
				display: flex;
				flex-direction: column;
				width: 100%;
				height: 100%;
			}

			form {
				display: flex;
				flex-direction: column;
				height: 100%;
			}

			.card {
				width: 100%;
				height: 100%;
			}

			#content-footer {
				display: flex;
				justify-content: center;
				align-items: center;
				position: fixed;
				bottom: 0;
				width: calc(100% - var(--sidebar-width));
				height: var(--footer-height);
				background-color: var(--primary-dark);
				color: white;
				z-index: 200;
			}

			#content-footer.active {
				width: 100%;
			}

			.context-menu {
				position: absolute;
				left: var(--sidebar-width);
				display: none;
				border: 1px solid #ccc;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				padding: 5px 0;
				padding-left:0;
				overflow: visible;
				z-index:9999;
			}

			li:hover .context-menu {
				display: block;
			}

			.action-button {
				cursor: pointer;
			}

			/*----------------------------------------------------
			MODAL DIALOG
			------------------------------------------------------*/
			/* Center the modal */
			.modal {
				align-items: center;
				justify-content: center;
			}

			.modal-backdrop {
				display: none;
			}

			/* Style for modal content */
			.modal-content {
				max-height: 80vh; /* Set a maximum height for modal-content */
				overflow-y: auto; /* Enable vertical scrolling if content overflows */
			}

			/* Sticky modal header and footer */
			.modal-header {
				position: sticky;
				top: 0;
				background-color: white; /* Add your desired background color */
				z-index: 999; /* Ensure that header and footer stay on top */
			}

			.modal-footer {
				position: sticky;
				bottom: 0;
				background-color: white; /* Add your desired background color */
				z-index: 999; /* Ensure that header and footer stay on top */
			}

			/* ---------------------------------------------------
			TAB CONTENT
		----------------------------------------------------- */

			.tab-content{
				height: 100%;
			}

			.tab-pane{
				height:100%;
			}


			/* ---------------------------------------------------
			MEDIA QUERIES
		----------------------------------------------------- */

			@media (max-width: 768px) {
				#sidebar {
					margin-left: calc(-1 * var(--sidebar-width));
				}

				#sidebar.active {
					margin-left: 0;
				}

				#topbar {
					width: 100%;
				}

				#content-box {
					width: 100%;
				}

				#content-box.active {
					width: calc(100% - var(--sidebar-width));
				}

				#content {
					width: 100%;
				}

				#content.active {
					width: calc(100% - var(--sidebar-width));
				}

				#content-footer {
					width: 100%;
				}
			}
			/* ---------------------------------------------------
			BOOTSTRAP QUERIES
		----------------------------------------------------- */
			.shadow {
				box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.2), 0px 4px 5px 0px rgba(0, 0, 0, 0.14), 0px 1px 10px 0px rgba(0, 0, 0, 0.12);
				transition: box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1);
				/* &:hover {
					box-shadow: 0px 11px 15px -7px rgba(0, 0, 0, 0.2), 0px 24px 38px 3px rgba(0, 0, 0, 0.14), 0px 9px 46px 8px rgba(0, 0, 0, 0.12);
				} */
			}

			.card-body{
				overflow-y:auto;
			}

		/* AIMS CSS */
		<?php include "include/css/aims.css" ?>

		</style>
	</head>

	<body>
		<!-- Sidebar  -->
		<nav id="sidebar">
			<div class="sidebar-header">
				<img src="include/icon/logo/centexs-logo-white.png" style="height: 80px; " />
			</div>

			<ul class="list-unstyled components mt-5">
				<?php
				$sql = "SELECT * FROM aims_module ORDER BY id ASC";
				$query = mysqli_query($con, $sql);

				while ($row = mysqli_fetch_assoc($query)) {
					$module_id = $row['id'];
					$module_name = $row['module'];
					$module_display_name = $row['display_name'];
					$icon = $row['icon'];

					// Check if the module has id = 11
					$isModuleId11 = ($module_id == 11);

					$sql = "SELECT * FROM aims_submodule WHERE module_id = '$module_id'";
					$q = mysqli_query($con, $sql);

					$submodules = [];
					while ($submodule = mysqli_fetch_assoc($q)) {
						$submodule_name = $submodule['submodule'];
						$submodule_modulename = $submodule['module'];
						if ($submodule_access[$submodule_name]['view']) {
							$submodules[] = [
								'name' => $submodule_name,
								'module' => $submodule_modulename,
								'main_module' => $module_name
							];
						}
					}

					// Don't show module if no user access
					if (count($submodules) == 0) {
						continue;
					} else if (count($submodules) == 1) {
						$submodule_name = $submodules[0]['name'];
						?>
						<li class="<?= stristr($page, $submodule_name) ? 'active' : ''; ?>"
							onmouseover="hideSubMenu();"
							<?php if ($isModuleId11) echo 'style="border-bottom: 5px dashed #ffffff;"'; ?>>
							<a href="./<?= $submodule_name; ?>">
								<div style="display: flex; align-items: center;">
									<?php include 'include/icon/' . $icon; ?>
									<span class="ml-3"><?= $module_display_name; ?></span>
								</div>
							</a>
						</li>
					<?php
					} else {
						$submodule_modulename = $submodules[0]['module'];
						$main_modulename = $submodules[0]['main_module'];
						?>
						<li class="<?= stristr($page, $module_name) ? 'active' : ''; ?>"
							onmouseover="showSubMenu(this, '<?= $module_id; ?>', '');"
							<?php if ($isModuleId11) echo 'style="border-bottom: 2px dashed #ffffff;"'; ?>>
							<a>
								<div style="display: flex; align-items: center;">
									<?php include 'include/icon/' . $icon; ?>
									<span class="ml-3"><?= $module_display_name; ?></span>
								</div>
							</a>
						</li>
					<?php
					}
				}
				?>
			</ul>

			<div id="sidebar-footer">
				<a href="./password" title="Change password">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="siderbar-footer-svg">
						<path d="M9 16C9 16.5523 8.55229 17 8 17C7.44772 17 7 16.5523 7 16C7 15.4477 7.44772 15 8 15C8.55229 15 9 15.4477 9 16Z" fill="var(--primary-dark)"/>
						<path d="M13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16Z" fill="var(--primary-dark)"/>
						<path d="M16 17C16.5523 17 17 16.5523 17 16C17 15.4477 16.5523 15 16 15C15.4477 15 15 15.4477 15 16C15 16.5523 15.4477 17 16 17Z" fill="var(--primary-dark)"/>
						<path fill-rule="evenodd" clip-rule="evenodd" fill="var(--primary-dark)" d="M5.25 8V9.30277C5.02317 9.31872 4.80938 9.33948 4.60825 9.36652C3.70814 9.48754 2.95027 9.74643 2.34835 10.3483C1.74643 10.9503 1.48754 11.7081 1.36652 12.6082C1.24996 13.4752 1.24998 14.5775 1.25 15.9451V16.0549C1.24998 17.4225 1.24996 18.5248 1.36652 19.3918C1.48754 20.2919 1.74643 21.0497 2.34835 21.6516C2.95027 22.2536 3.70814 22.5125 4.60825 22.6335C5.47522 22.75 6.57754 22.75 7.94513 22.75H16.0549C17.4225 22.75 18.5248 22.75 19.3918 22.6335C20.2919 22.5125 21.0497 22.2536 21.6517 21.6516C22.2536 21.0497 22.5125 20.2919 22.6335 19.3918C22.75 18.5248 22.75 17.4225 22.75 16.0549V15.9451C22.75 14.5775 22.75 13.4752 22.6335 12.6082C22.5125 11.7081 22.2536 10.9503 21.6517 10.3483C21.0497 9.74643 20.2919 9.48754 19.3918 9.36652C19.1906 9.33948 18.9768 9.31872 18.75 9.30277V8C18.75 4.27208 15.7279 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8ZM12 2.75C9.10051 2.75 6.75 5.10051 6.75 8V9.25344C7.12349 9.24999 7.52152 9.24999 7.94499 9.25H16.0549C16.4783 9.24999 16.8765 9.24999 17.25 9.25344V8C17.25 5.10051 14.8995 2.75 12 2.75ZM4.80812 10.8531C4.07435 10.9518 3.68577 11.1322 3.40901 11.409C3.13225 11.6858 2.9518 12.0743 2.85315 12.8081C2.75159 13.5635 2.75 14.5646 2.75 16C2.75 17.4354 2.75159 18.4365 2.85315 19.1919C2.9518 19.9257 3.13225 20.3142 3.40901 20.591C3.68577 20.8678 4.07435 21.0482 4.80812 21.1469C5.56347 21.2484 6.56459 21.25 8 21.25H16C17.4354 21.25 18.4365 21.2484 19.1919 21.1469C19.9257 21.0482 20.3142 20.8678 20.591 20.591C20.8678 20.3142 21.0482 19.9257 21.1469 19.1919C21.2484 18.4365 21.25 17.4354 21.25 16C21.25 14.5646 21.2484 13.5635 21.1469 12.8081C21.0482 12.0743 20.8678 11.6858 20.591 11.409C20.3142 11.1322 19.9257 10.9518 19.1919 10.8531C18.4365 10.7516 17.4354 10.75 16 10.75H8C6.56459 10.75 5.56347 10.7516 4.80812 10.8531Z"/>
					</svg>
				</a>
				<?php
					// if ($submodule_access['setting']['view'] == 1) {
				?>
						<a href="./setting" title="Setting">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="siderbar-footer-svg">
								<circle cx="12" cy="12" r="3" stroke="var(--primary-dark)" stroke-width="1.5"/>
								<path stroke="var(--primary-dark)" stroke-width="1.5" d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z"/>
							</svg>
						</a>
				<?php
					// }
				?>
			</div>
		</nav>

		<div id="submenu-container" style="display: none;"></div>

		<!-- Page Content -->
		<div id="content-box">
			<!-- Top Bar -->
			<div id="topbar" style="padding: 20px;">
				<div>
					<a id="sidebarCollapse" class="btn mr-2" title="Toggle sidebar" style="background-color: transparent; border: 0; color: var(--primary-dark);">
						<i class="fas fa-bars"></i>
					</a>
					<span>Greetings, <?php echo $username; ?>!&nbsp;&nbsp;</span>
					<span style="font-size:12px">Local time &nbsp;</span>
					<span style="font-size:12px" id="clockbox"></span>
				</div>
				<a title="Logout" href="./logout">
					<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4" stroke="#1976D2" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M10 12H20M20 12L17 9M20 12L17 15" stroke="#1976D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
			</div>

			<div id="content">

				<!-- Modal -->
				<div class="modal fade" id="deleteModal">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"></h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<form id="formDelete">
								<div class="modal-body">
									<div class="form-group">
										Are you confirm to delete this?
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
									<button type="submit" class="btn btn-success" id="deleteBtn">Yes</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php
					include $page;
				?>
			</div>

			<div id="content-footer">
				<strong class="ml-3">Asset Management Information System</strong><i>&nbsp;&nbsp;developed by Softworld Software Sdn Bhd</i>
			</div>
		</div>

		<!-- Bootstrap core JavaScript
================================================== -->
		<script src="./include/js/bootstrap.min.js"></script>
		<script src="./include/DataTables/datatables.min.js"></script>
		<script src="./include/js/jquery.mCustomScrollbar.concat.min.js"></script>

		<script>
			tday = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			tmonth = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

			let is_submenu_showing = false;

			function GetClock() {
				var d = new Date();
				var nday = d.getDay(),
					nmonth = d.getMonth(),
					ndate = d.getDate(),
					nyear = d.getFullYear();
				var nhour = d.getHours(),
					nmin = d.getMinutes(),
					nsec = d.getSeconds(),
					ap;

				if (nhour == 0) {
					ap = " AM";
					nhour = 12;
				} else if (nhour < 12) {
					ap = " AM";
				} else if (nhour == 12) {
					ap = " PM";
				} else if (nhour > 12) {
					ap = " PM";
					nhour -= 12;
				}

				if (nmin <= 9) nmin = "0" + nmin;
				if (nsec <= 9) nsec = "0" + nsec;

				document.getElementById('clockbox').innerHTML = "" + nhour + ":" + nmin + ":" + nsec + ap + " " + tday[nday] + ", " + ndate + " " + tmonth[nmonth] + " " + nyear;
			}

			window.onload = function() {
				GetClock();
				setInterval(GetClock, 1000);

				$("#sidebar").mCustomScrollbar({
					theme: "minimal"
				});

				$('#sidebarCollapse').on('click', function() {
					$('#sidebar, #content-box, #content, #topbar, #content-footer').toggleClass('active');
					$('.collapse.in').toggleClass('in');
				});

				// Hide the submenu if the user is not pointing in the submenu
				setInterval(function() {
					if (!is_submenu_showing) {
						hideSubMenu();
					}
				}, 200000);
			}

			function showSubMenu(e, moduleId, submoduleId) {
				let element = $(e);
				let offset = element.offset();
				let top = offset.top;
				let left = offset.left;
				let width = element.width();
				let height = element.height();
				let right = left + width;
				let bottom = top + height;
				// console.log('top: ' + top);
				// console.log('left: ' + left);
				// console.log('right: ' + right);
				// console.log('bottom: ' + bottom);
				let container = $('#submenu-container');

				$.ajax({
					url: 'module/view/get_submenu_ajax.php',
					type: 'POST',
					data: {
						module_id: moduleId,
						submodule_id: submoduleId
					},
					dataType: 'html',
					success: function(response) {
						// console.log(response);
						container.html(response);

						// Set default top
						container.css('top', top);

						let viewportHeight = $(window).height();
						let documentHeight = $(document).height();
						let containerHeight = container.height();
						let containerBottom = parseInt($(container).css('top')) + containerHeight;
						let footerHeight = $('#content-footer').height();
						// console.log('container bottom: ' + containerBottom);
						// console.log('container height: ' + containerHeight);
						// console.log('viewport height: ' + viewportHeight);
						// console.log('document height: ' + documentHeight);
						// console.log('footer height: ' + footerHeight);

						// Modify top if container hit bottom limit
						let bottomLimit = viewportHeight - footerHeight;
						if (containerBottom >= bottomLimit) {
							container.css('top', bottomLimit - containerHeight);
						}
						container.show();
					},
					error: function(xhr, status, error) {
						console.error("Error sending POST request:", error);
					}
				});
			}

			function hideSubMenu() {
				is_submenu_showing = false;
				$('#submenu-container').hide();
			}

			function stayFocusSubMenu() {
				is_submenu_showing = true;
				$('#submenu-container').show();
			}
		</script>
	</body>
</html>
