<?php
	include_once '../../../include/db_connection.php';

	if (isset($_POST['user_group_id'])) {
		$user_group_id = $_POST['user_group_id'];

		$sql = "SELECT
					aims_module.module,
					aims_submodule.submodule,
					aims_module.display_name AS module_display_name,
					aims_submodule.display_name AS submodule_display_name,
					aims_submodule_access.crud
				FROM
					aims_submodule
				JOIN aims_module ON aims_module.id = aims_submodule.module_id
				JOIN aims_submodule_access ON aims_submodule.id = aims_submodule_access.submodule_id
				WHERE aims_submodule_access.user_group_id = '$user_group_id'
				";
		$query = mysqli_query($con, $sql);

		$module_arr = [];

		while ($row = mysqli_fetch_assoc($query)) {
			$module = $row['module'];
			$module_arr[$module]['module_display_name'] = $row['module_display_name'];

			$submodule = $row['submodule'];
			$crud = $row['crud'];
			$module_arr[$module][$submodule] = array(
				'submodule_display_name' => $row['submodule_display_name'],
				'view' => ($crud & 0b1000) ? 1 : 0,
				'add' => ($crud & 0b0100) ? 1 : 0,
				'edit' => ($crud & 0b0010) ? 1 : 0,
				'delete' => ($crud & 0b0001) ? 1 : 0
			);
		}

		$html = '';
		$count = 0;

		foreach ($module_arr as $module_key => $module) {
			$submodule_count = 0;
			$submodules = [];

			foreach ($module as $element_key => $element) {
				if (is_array($element)) {
					$submodules[$element_key] = $element;
					$submodule_count++;
				}
			}
			$html .= '<tr>';
			$html .= '	<td rowspan="' . ($submodule_count + 1) . '">' . ++$count . '</td>';
			$html .= '	<td rowspan="' . ($submodule_count + 1) . '">' . $module['module_display_name'] . '</td>';
			$html .= '</tr>';

			$first_submodule = TRUE;
			foreach ($submodules as $submodule_key => $submodule) {
				$html .= '<tr>';
				$html .= '	<td><input type="hidden" name="module[]" value="' . $module_key .'"><input type="hidden" name="submodule[]" value="' . $submodule_key . '">' . $submodule['submodule_display_name'] . '</td>';
				$html .= '	<td><input type="checkbox" name="submodule_view[]" onclick="toggleCheckbox(this);"' . ($submodule["view"] == 1 ? ' checked' : '') . '></td>';
				$html .= '	<td><input type="checkbox" name="submodule_add[]" onclick="toggleCheckbox(this);"' . ($submodule["add"] == 1 ? ' checked' : '') . '></td>';
				$html .= '	<td><input type="checkbox" name="submodule_edit[]" onclick="toggleCheckbox(this);"' . ($submodule["edit"] == 1 ? ' checked' : '') . '></td>';
				$html .= '	<td><input type="checkbox" name="submodule_delete[]" onclick="toggleCheckbox(this);"' . ($submodule["delete"] == 1 ? ' checked' : '') . '></td>';
				$html .= '</tr>';
			}
		}

		echo $html;
	}
?>