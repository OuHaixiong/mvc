<?php

class M_New_Newfile extends CModel
{
	public function mm() {
	    $sql = 'select * from tb_adminf';
		$result = $this->db->query($sql, '粗错：');
		Common_Tool::prePrint($result);
	}
}