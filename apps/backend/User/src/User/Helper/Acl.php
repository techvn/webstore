<?php
namespace User\Helper;
use User\Libs\Acl as UserAcl;
use User\Libs\Model as UserModel;
use User\Libs\Role\Model as RoleModel;
use Zend\View\Helper\AbstractHelper;
class Acl extends AbstractHelper{
    protected $acl;
    protected $roleName;
    public function __construct(UserModel $user){
        $this->acl = $user->getAcl();
        $this->roleName = $user->getRole()->getName();
    }
    public function __invoke(){
        return $this->acl;
    }
    public function getRoleName(){
        return $this->roleName;
    }
}