<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 2/18/14
 * Time: 12:27 PM
 * To change this template use File | Settings | File Templates.
 */
namespace System\Helpers\Select;
use TrungDm\SystemDb\User\Model as UserModel;
use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class MenuDropList extends AbstractHelper{
    protected $menutree = array();

    public function __construct(){

    }

    public function __invoke($menutree,$helper,$option=array()){
        $this->menutree = $menutree;
        $this->_url  = $helper;
        $option = array_merge(array(
            'selected'=>false,
            'level'=>0,
            'parent_id'=>0,
            'spacer'=>'---',
            'get'=>array('Id','ParentId','Title')
        ),$option);
        print_r($option);
        $this->getMenuDropList($option['get'],$option['parent_id'],$option['level'],$option['spacer'],$option['selected']);
    }
    public function getMenuDropList($get,$parent_id, $level = 0, $spacer, $selected = false)
    {

        foreach ($this->menutree as $key => $row) {
            //call_user_func(array($row,'get'.$get[0]));
            $id = $row->getId();
            $sel = ( $id== $selected) ? " selected=\"selected\"" : "" ;

            //$parent = ($row->getParentId() == 0)?"":;

            if ($parent_id == $row->getParentId()) {
                print "<option value=\"" .$id . "\"".$sel.">";

                for ($i = 0; $i < $level; $i++){
                    print $spacer;
                }
                //call_user_func(array($row,'get'.$get[2]))
                print $row->getTitle() . "</option>\n";
                $level++;
                    $this->getMenuDropList($get,$id, $level, $spacer, $selected);
                $level--;
            }
     }
   //  unset($row);
    }
}