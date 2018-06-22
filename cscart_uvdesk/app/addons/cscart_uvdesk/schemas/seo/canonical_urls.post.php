<?php
$rule = array(
    'base_url' => array('fn_seo_filter_current_url' => array("result_ids", "full_render", "filter_id", "view_all", "req_range_id", "features_hash", "subcats", "page", "total", "hint_q")),
    'search' => true
);

foreach (array('manage') as $mode) {
    $schema['cscart_uvdesk'][$mode] = $rule;
}

return $schema;