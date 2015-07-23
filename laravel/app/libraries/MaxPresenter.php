<?php
class MaxPresenter extends Illuminate\Pagination\Presenter {

    public function getActivePageWrapper($text)
    {
        return '<li class="unavailable"><a href="" class="active" data-nofollow="1">'.$text.'</a></li>';
    }

    public function getDisabledTextWrapper($text)
    {
        return '<li class="unavailable"><a href="" data-nofollow="1">'.$text.'</a></li>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        if($rel=='prev' || $rel=='next')        return '<li><a class="'.$rel.'" href="'.$url.'">'.$page.'</a></li>';
        else return '<li><a href="'.$url.'">'.$page.'</a></li>';
    }
    
    public function getPrevious($text = ''){
        $text = trans('pagination.previous');
        $url = $this->paginator->getUrl($this->currentPage - 1);
        if ($this->currentPage <= 1)
        {
                $url = '';
        }
        return $this->getPageLinkWrapper($url, $text, 'prev');
    }
    
    public function getNext($text = '') {
        $text = trans('pagination.next');
        $url = $this->paginator->getUrl($this->currentPage + 1);
        if ($this->currentPage >= $this->lastPage)
        {
                $url = '';
        }
        return $this->getPageLinkWrapper($url, $text, 'next');
    }

}