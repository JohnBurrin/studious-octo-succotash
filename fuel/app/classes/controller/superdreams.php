<?php
use \Model\Item;
class Controller_Superdreams extends Controller_Template
{

    public function action_index()
    {
        $count = Model_Item::get_count(422);

        $config = array(
            'pagination_url' => '/superdreams',
            'total_items' => $count,
            'per_page' => 20,
            'show_first' => true,
            'show_last' => true,
            'num_links' => 5,
            // 'uri_segment' => 3,
            // or if you prefer pagination by query string
            'uri_segment'    => 'page',
            );


          // Create a pagination instance named 'mypagination'
        $pagination = Pagination::forge('mypagination',  $config);

        $data['item_data'] = DB::select()
            ->from('items')
            ->where('categoryId', 422)
            ->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->execute()
            ->as_array();

        $data['pagination'] = $pagination;

        $data["subnav"] = array('index'=> 'active' );
        $this->template->link = ['title' => "Parts", 'url' => "/"];
        $this->template->title = 'Ebay &raquo; Superdreams';
        $this->template->content = View::forge('ebay/index2', $data);
    }
}
