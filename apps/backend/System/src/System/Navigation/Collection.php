<?php
namespace TrungDm\SystemDb\Navigation;
use TrungDm\System\Db\AbstractTable;
use Zend\Db\Sql\Select;
function isSerialized($str) {
    return ($str == serialize(false) || @unserialize($str) !== false);
}
class Collection extends AbstractTable
{

	protected $name = 'navigation';
    public $listNavigation = array();
    protected $temp_page = array();
	public function init()
    {
        $this->setNavigation();
        $this->setNavigationView();
    }
    public function getNavigation(){
    	return $this->getData("navigations");
    }

    protected function setNavigation()
    {
        $select = $this->select(
            function (Select $select) {
                $select->order('position');
                $select->where('active','1');
            }
        );
        $rows  = $this->fetchAll($select);
        $users = array();
        foreach ($rows as $row) {
            $users[] = Model::fromArray((array) $row);
        }

        $this->setData('navigations', $users);
    }
    public function BuildConifg($array, $parent_id = 0){

        $subcat = false;
        foreach ($array as $key => $row) {
            if ($row->getParentId() == $parent_id) {
                echo  $row->getId()."-".$parent_id;
                $type = ($row->getParentId() == 0)?'parent':"child";
                if($row->getParentId() == 0){
                    $this->listNavigation[$row->getId()] =
                        array(
                            'id' => $row->getId(),
                            'name' => $row->getName(),
                            'icon' => $row->getIcon(),
                            'label' => $row->getLabel(),
                            'route' => $row->getRoute(),
                            'params' => unserialize($row->getParams()),
                            'resource' => $row->getResource(),
                            'pages' => array()
                        );
                }else{
                    if(isset($this->listNavigation[$parent_id])){
                        $this->listNavigation[$parent_id]['pages'][]= array(
                            'id' => $row->getId(),
                            'name' => $row->getName(),
                            'icon' => $row->getIcon(),
                            'label' => $row->getLabel(),
                            'route' => $row->getRoute(),
                            'params' => unserialize($row->getParams()),
                            'resource' => $row->getResource(),
                            'pages' => array()
                        );
                    }
                }
//                if ($subcat === false) {
//
//                }
               // print '<li id="list_'.$row->getId().'">';
                    $this->BuildConifg($array, $row->getId());
                //print "</li>\n";
            }
        }
        unset($row);
        if ($subcat === true){

        }
    }
    protected function setNavigationView(){
    	$arr = $this->getNavigation();
    	$_arr = array();
      //  echo unserialize("a:0:{}");
        //echo serialize($_arr);
    	foreach ($arr as $key => $value) {
		 	//echo "<pre>".print_r($value,1)."</pre>";
            if ($value->getParent_id() == 0) {
            $pages = array();
            foreach ($arr as $k => $v) {
                if ($v->getParent_id() == $value->getId()) {
                    $pages[]= array(
                         'id' => $v->getId(),
                         'name' => $v->getName(),
                         'icon' => $v->getIcon(),
                         'label' => $v->getLabel(),
                         'route' => $v->getRoute(),
                         'params' => unserialize($v->getParams()),
                         'resource' => $v->getResource(),
                         'pages' => array()
                     );
                }
            }
    		$_arr[] = 
                array(
                 'id' => $value->getId(),
                 'name' => $value->getName(),
                 'icon' => $value->getIcon(),
                 'label' => $value->getLabel(),
                 'route' => $value->getRoute(),
                 'params' => unserialize($value->getParams()),
                 'resource' => $value->getResource(),
                 'pages' => $pages
                 );
                
		 	//echo $value->getName();
            }
		}
        
		$this->setData('navigations_view', $_arr);
    }
    public function write($object){
        $this->init();

        $config = \TrungDm\Registry::get("Application")->getServiceManager()->get('config');
        $config_navigation = $config['config_layout']['admin'];

        $templateContent   = file_get_contents($config_navigation['navigation']['path_template']);
        $navi_backend = $this->getNavigationView();
        $write =array();
        $error = array();
        foreach ($navi_backend as $key => $value) {
            try {
                 $write[$value['name']] = $value;
                 $object->url()->fromRoute($value['route']);      
            } catch (\Zend\Mvc\Router\Exception\RuntimeException $e) {
                $error[] = $value['route'];
            }
        }
        if (!count($error)) {
            file_put_contents($config_navigation['navigation']['path_active'], sprintf($templateContent, var_export($write,true)));
        }else{
            echo "<pre>".print_r($error,1)."</pre>";
        }
    }
    public function getNavigationView(){
        return $this->getData('navigations_view');
    }
}