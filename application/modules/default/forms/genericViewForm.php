<?php

class Default_Form_genericViewForm extends Zend_Dojo_Form {

	public $table = "";

	public function __construct($data, $editable = true) {
		parent::__construct();
		if ( 0 == count($data) )
			return;

		$headings = array_keys($data[0]);
		if ( $editable )
			$headings[] = "Edit";
		$this->table = <<<EOT
			<table id="viewingsTable">
				<thead>
					<tr>
EOT;
		$this->table .= "<th>" . implode("</th><th>", $headings) . "</th>";
		$this->table .=<<<EOT
					</tr>
				</thead>
				<tbody>
EOT;

		foreach ( $data as $row )
			if ( $editable )
				$this->table .= "<tr><td>" . implode("</td><td>", $row) . "</td><td><div>{$this->combobutton($row['id'])}</div></td></tr>";
			else
				$this->table .= "<tr><td>" . implode("</td><td>", $row) . "</td></tr>";

		$this->table .= <<<EOT
				</tbody>
			</table>
EOT;
	}

	public function combobutton($id) {
		$button = <<<EOT
<div dojoType="dijit.form.ComboButton" class="dijitComboButton">
    <span>
        edit
    </span>
    <div dojoType="dijit.Menu">
        <div dojoType="dijit.MenuItem" onClick="editDelete($id, 'edit')" id="edit$id">
            edit
        </div>
        <div dojoType="dijit.MenuItem" onClick="editDelete($id, 'delete')" id="delete$id">
            delete
        </div>
    </div>
</div>
EOT;
		return $button;
	}

	public function __toString() {
		return $this->table;
	}

}