<?php
	include_once '../../include/db_connection.php';
	include_once '../../include/user_group_access.php';

	if (isset($_POST)) {
		$module_id = $_POST['module_id'];
		$submodule_id = $_POST['submodule_id'];

		$sql = "SELECT * FROM aims_submodule WHERE module_id = '$module_id'";

		if ($submodule_id != '') {
			$sql .= " AND parent_submodule_id = '$submodule_id'";
		}
		$query = mysqli_query($con, $sql);

		$html = '<div>
					<ul style="padding:0; margin:0; list-style-type:none;">';

		while ($row = mysqli_fetch_assoc($query)) {
			$submodule_name = $row['submodule'];
			$submodule_display_name = $row['display_name'];
			if ($submodule_access[$submodule_name]['view']) {
				$html .= '	<li onmouseover="stayFocusSubMenu();" onmouseleave="hideSubMenu();">
								<a href="./' . $submodule_name . '">' . $submodule_display_name . '</a>
							</li>';
			}
		}

		$html .= '</div>';

		echo $html;
	}
?>