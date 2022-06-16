<?php
class PerPage {
	public $perpage;
	
	function __construct($page_row,$function_name) {
		$this->perpage = $page_row;
		$this->function_name = $function_name;
	}
	
	function getAllPageLinks($count) {
		$output = '';
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>0) {
			if($_POST["page"] == 1) 
				$output = $output . '<span class="link first disabled">&#8810;</span><span class="link disabled">&#60;</span>';
			else	
				$output = $output . '<a class="link first" onclick="'.$this->function_name.'(\'' . (1) . '\')" >&#8810;</a><a class="link" onclick="'.$this->function_name.'(\''  . ($_POST["page"]-1) . '\')" >&#60;</a>';
			
			
			if(($_POST["page"]-3)>0) {
				if($_POST["page"] == 1)
					$output = $output . '<span data-role="1" id=1 class="link current  '.$this->function_name.'">1</span>';
				else				
					$output = $output . '<a class="link" onclick="'.$this->function_name.'(\'1\')" >1</a>';
			}
			if(($_POST["page"]-3)>1) {
					$output = $output . '<span class="dot">...</span>';
			}
			
			for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_POST["page"] == $i)
					$output = $output . '<span data-role="'.$i.'" id='.$i.' class="link current '.$this->function_name.'">'.$i.'</span>';
				else				
					$output = $output . '<a class="link" onclick="'.$this->function_name.'(\''  . $i . '\')" >'.$i.'</a>';
			}
			
			if(($pages-($_POST["page"]+2))>1) {
				$output = $output . '<span class="dot">...</span>';
			}
			if(($pages-($_POST["page"]+2))>0) {
				if($_POST["page"] == $pages)
					$output = $output . '<span data-role="'.$i.'" id=' . ($pages) .' class="link current '.$this->function_name.'">' . ($pages) .'</span>';
				else				
					$output = $output . '<a class="link" onclick="'.$this->function_name.'(\'' .  ($pages) .'\')" >' . ($pages) .'</a>';
			}
			
			if($_POST["page"] < $pages)
				$output = $output . '<a  class="link" onclick="'.$this->function_name.'(\''  . ($_POST["page"]+1) . '\')" >></a><a  class="link" onclick="'.$this->function_name.'(\'' . ($pages) . '\')" >&#8811;</a>';
			else				
				$output = $output . '<span class="link disabled">></span><span class="link disabled">&#8811;</span>';
			
			
		}
		return $output;
	}
	function getPrevNext($count) {
		$output = '';
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_POST["page"] == 1) 
				$output = $output . '<span class="link disabled first">Prev</span>';
			else	
				$output = $output . '<a class="link first" onclick="'.$this->function_name.'(\''  . ($_POST["page"]-1) . '\')" >Prev</a>';			
			
			if($_POST["page"] < $pages)
				$output = $output . '<a  class="link" onclick="'.$this->function_name.'(\''  . ($_POST["page"]+1) . '\')" >Next</a>';
			else				
				$output = $output . '<span class="link disabled">Next</span>';
			
			
		}
		return $output;
	}
}
?>