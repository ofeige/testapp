<?php

class RenderTable implements \Opf\Template\ViewHelperInterface {
	public function execute($args = array()) {
      if(count($args) == 0) {
         return;
      }

		$table = '<table><tbody>';
		
		foreach ($args as $row) {
			foreach ($row as $key=>$col) {
				if(is_array($col) === true) {
					$col = implode(', ', $col);
				}
				$table .= "<tr><th>{$key}</th><th>{$col}</th></tr>";
			}
		}
		
		$table .= '</tbody></table>';
		
		return $table;
	}
}
