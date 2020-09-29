<?php
use \Model\Item;

class Controller_Index extends Controller_Template
{
    public function action_index()
    {
        $count = Model_Item::get_count();
        $pageConfig = "home";

        $config = array(
            'pagination_url' => '/',
            'total_items' => $count,
            'per_page' => 21,
            'show_first' => true,
            'show_last' => true,
            'num_links' => 24,
            // 'uri_segment' => 3,
            // or if you prefer pagination by query string
            'uri_segment'    => 'page',
            );

        if (Agent::is_mobiledevice()) {
             $config['num_links'] = 5;
        }

          // Create a pagination instance named 'mypagination'
        $pagination = Pagination::forge('mypagination', $config);

        $data['item_data'] = DB::select()
            ->from(\Config::get('search.table'))
            ->where('categoryId', null)
            ->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->execute()
            ->as_array();

        $data['pagination'] = $pagination;

        $data["subnav"] = array('index'=> 'active' );
        $config = (\Config::get('mapbox'));
        $template = (\Config::get('search.template'));
        $this->template->mapbox_api_key = $config['api_key'];
        $this->template->link = ['title' => $template[$pageConfig]['link']['title'], 'url' =>  $template[$pageConfig]['link']['url']];
        $this->template->title = $template[$pageConfig]['title'];
        $this->template->description = $template[$pageConfig]['description'];
        $this->template->keywords = $template[$pageConfig]['keywords'];
        $this->template->content = View::forge('ebay/index2', $data);
    }
}
