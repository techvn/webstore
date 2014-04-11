<?php
namespace MDS\View\Helper;
use Zend\View\Helper\AbstractHelper;
class isCheck extends AbstractHelper
{
    public function __invoke($is,$icon1="icon-ok-sign",$icon0="icon-minus-sign")
    {
        return ($is)?'<i class="'.$icon1.'"></i>':'<i class="'.$icon0.'"></i>';
    }
}
