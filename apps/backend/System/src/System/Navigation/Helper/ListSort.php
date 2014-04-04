<?php
namespace TrungDm\SystemDb\Navigation\Helper;
use TrungDm\SystemDb\User\Model as UserModel;
use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class ListSort extends AbstractHelper{
	protected $categorie;
	public function __construct(){

		$categories =new \TrungDm\SystemDb\Navigation\Collection();
		$this->categorie = $categories->getNavigation();
		$app = \TrungDm\Registry::get('Application');

		$sm = $app->getServiceManager();
		$this->getView();

		// echo $this->url("admin/categories",array('action'=>'edit','id'=>1));
	}
	public function __invoke($url){
        $this->_url  = $url;
		$this->getCategories($this->categorie);
	}
	public function getCategories($array, $parent_id = 0)
	{
		  $subcat = false;
		  foreach ($array as $key => $row) {
			  if ($row->getParentId() == $parent_id) {
			  	  $type = ($row->getParentId() == 0)?'parent':"child";
				  if ($subcat === false) {
					  $subcat = true;
					  $class = ($parent_id == 0)?'class="sortable ui-sortable"':"";
					  print "<ol {$class}>\n";
				  }
				  print '<li id="list_'.$row->getId().'">';
				  print '<div>';
				  print '<a href="javascript:void(0)" id="item_'.$row->getId().'" rel="Cookbooks" class="delete">';
				  print	'<img src="/backend/img/delete.png" alt=""  title="Delete"></a>';
				  print '<a href="'.$this->_url->url('admin/navigation',array('action'=>'edit','id'=>$row->getId())).'" class="'.$type.'">'.$row->getName().'</a>';
				  print '</div>';
				  	$this->getCategories($array, $row->getId());
				  print "</li>\n";
			  }
		  }
		  unset($row);
		  if ($subcat === true)
			  print "</ol>\n";
	  }
}