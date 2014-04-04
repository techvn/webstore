<?php
namespace User\Helper;
use User\Libs\Acl as UserAcl;
use User\Libs\Model as UserModel;
use User\Libs\Role\Model as RoleModel;
use Zend\View\Helper\AbstractHelper;
class UserSystem extends AbstractHelper{
    protected $user;
    public function __construct(UserModel $user){
       $this->user = $user;
    }
    public function __invoke(){
        return  $this->user;
    }

}