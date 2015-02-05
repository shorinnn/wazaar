<?php
class MaxPresenter extends Illuminate\Pagination\Presenter {

    public function getActivePageWrapper($text)
    {
        return '<li><a href="" class="active">'.$text.'</a></li>';
    }

    public function getDisabledTextWrapper($text)
    {
        return '<li class="unavailable"><a href="">'.$text.'</a></li>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        if($rel=='prev' || $rel=='next')        return '<li><a class="'.$rel.'" href="'.$url.'">'.$page.'</a></li>';
        else         return '<li><a href="'.$url.'">'.$page.'</a></li>';
    }
    
    public function getPrevious($text = ''){
        return parent::getPrevious($text);
    }
    
    public function getNext($text = '') {
        return parent::getNext($text);
    }

}