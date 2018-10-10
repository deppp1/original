<?php 
//API機能
$acckey = '3e2e5cd74363c280296498b7bffeafab';

//都道府県リスト取得
$file = file_get_contents('http://api.gnavi.co.jp/master/PrefSearchAPI/20150630/?format=json&keyid=3e2e5cd74363c280296498b7bffeafab');
$json = json_decode($file);

//お店のリスト取得
if (isset($_GET['search_word']) && (isset($_GET['pref']))) {
    $search = htmlspecialchars($_GET['search_word']);
    $pref_id = htmlspecialchars($_GET['pref']);
    $rest_url = 'http://api.gnavi.co.jp/RestSearchAPI/20150630/?format=json&keyid=3e2e5cd74363c280296498b7bffeafab&freeword=' . $search . '&pref=' . $pref_id;
} elseif(isset($_GET['search_word'])) {
    $search = htmlspecialchars($_GET['search_word']);
    $rest_url = 'http://api.gnavi.co.jp/RestSearchAPI/20150630/?format=json&keyid=3e2e5cd74363c280296498b7bffeafab&freeword=' . $search;
} elseif(isset($_GET['pref'])) {
    $pref_id = htmlspecialchars($_GET['pref']);
    $rest_url = 'http://api.gnavi.co.jp/RestSearchAPI/20150630/?format=json&keyid=3e2e5cd74363c280296498b7bffeafab&pref=' . $pref_id;
} else {
    $rest_url = 'http://api.gnavi.co.jp/RestSearchAPI/20150630/?format=json&keyid=3e2e5cd74363c280296498b7bffeafab';
}

//ページング機能
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$page = max($page, 1);
$rest_url .= '&offset_page='.$page;

// APIに問い合わせる
$rest_file = file_get_contents($rest_url);
$rest_json = json_decode($rest_file);

//ページング機能
$hit_page = $rest_json->total_hit_count;
$max_page = floor($hit_page/10) + 1;
?>