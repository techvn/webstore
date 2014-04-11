<?php
namespace MDS\View\Helper;
use Zend\View\Helper\AbstractHelper;
class buttonEdit extends AbstractHelper
{
    public function __invoke(array $option = array())
    {
        $_array = array_merge(array(
            'bclass'=>'btn-danger',
            'iclass'=> 'icon-edit'
        ),$option);
        return '<button class="btn '.$_array['bclass'].'"> <i class="'.$_array['iclass'].'"></i></button>';
    }
}