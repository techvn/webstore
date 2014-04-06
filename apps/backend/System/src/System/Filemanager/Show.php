<?php
namespace System\Filemanager;
class Show{
	public $msgs = array();
	  public $showMsg;
	 public  function msgAlert($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgAlert\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgAlert\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgAlert\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }
	   public function msgOk($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgOk\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgOk\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgOk\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }
	   public function msgError($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgError\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgError\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgError\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";	
	  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }
	   public function msgInfo($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgInfo\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgInfo\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgInfo\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";
	  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }
	  public function msgStatus()
	  {
		  $this->showMsg = "<div class=\"msgError\"><span>Error!</span>An error occurred while processing request:<ul class=\"error\">";
		  foreach ($this->msgs as $msg) {
			  $this->showMsg .= "<li>" . $msg . "</li>\n";
		  }
		  $this->showMsg .= "</ul></div>";
		  
		  return $this->showMsg;
	  }	  
}