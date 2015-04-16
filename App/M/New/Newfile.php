<?php

class M_New_Newfile extends CModel
{
	public function mm() {
	    $sql = 'select * from tb_admin';
	    $sql = 'delete from `bage_link` where `id`=1';
        $this->db->changeDatabase('BageCms');
        $this->db->query($sql);
        Common_Tool::prePrint($this->db->affectedRows());
		Common_Tool::prePrint($this->db->getLastId());
	}
}