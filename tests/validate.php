<?php
declare(strict_types=1);
// Pokrenite iz bilo kog foldera: php tests/validate.php
$root = dirname(__DIR__);
$languages = ['sr','en','hu','de','es','ru'];
function check(bool $condition, string $message): void {
    if (!$condition) { fwrite(STDERR, "FAIL: $message\n"); exit(1); }
}
function readJson(string $path): array { return json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR); }
$menu = readJson($root.'/data/menu.json');
$ui = readJson($root.'/data/translations.json');
$site = readJson($root.'/data/site.json');
$categories = [];
$ids = [];
$variants = 0;
foreach ($languages as $lang) {
    check(isset($ui[$lang]), "UI language $lang");
    check(array_keys($ui[$lang])===array_keys($ui['sr']), "UI keys $lang");
    foreach ($ui[$lang] as $value) check(is_string($value) && $value!=='', "UI value $lang");
}
foreach ($menu['categories'] as $cat) {
    check(!isset($categories[$cat['id']]), 'Duplicate category');
    check(in_array($cat['group'], ['food','drinks'],true), 'Category group');
    $categories[$cat['id']] = true;
    foreach($languages as $lang) check(!empty($cat['name'][$lang]), 'Category translation');
}
foreach ($menu['items'] as $item) {
    check(preg_match('/^[a-z0-9-]+$/', $item['id'])===1, 'Safe ID');
    check(!isset($ids[$item['id']]), 'Duplicate item');
    $ids[$item['id']]=$item;
    check(isset($categories[$item['category']]), 'Existing category');
    foreach($languages as $lang) {
        check(!empty($item['name'][$lang]), "Name {$item['id']} $lang");
        check(isset($item['description'][$lang]), 'Description translation');
        check(($item['description'][$lang]!=='')===($item['description']['sr']!==''), 'Complete description');
    }
    check(count($item['variants'])>0, 'Price variants');
    foreach($item['variants'] as $variant) {
        check(is_int($variant['price']) && $variant['price']>0, 'Positive integer price');
        check($variant['label']==='' || isset($ui['sr'][$variant['label']]), 'Translated size label');
        check(is_string($variant['volume']), 'Volume');
        $variants++;
    }
}
check($ids['bavaria-draft']['variants']===[['label'=>'','volume'=>'0.25 l','price'=>175],['label'=>'','volume'=>'0.5 l','price'=>350]], 'Bavaria requested prices');
check($site['deliveryPrice']===150, 'Delivery photo price');
check($ids['opera']['variants'][3]['price']===1750, 'Opera photo price (website differs)');
check($ids['pancakes']['variants'][0]['price']===250, 'Pancakes photo price');
$foodCategories = array_values(array_filter($menu['categories'], fn($cat) => $cat['group']==='food'));
check(end($foodCategories)['id']==='extras', 'Extras must be last in food');
$extras = array_values(array_filter($menu['items'], fn($item) => $item['category']==='extras'));
check(count($extras)===19, '19 extras after splitting jam and walnuts');
$expectedExtras = [
    'extra-ham'=>150, 'extra-jam'=>80, 'extra-walnuts'=>80, 'extra-cheese'=>200,
    'extra-mushrooms'=>100, 'extra-kulen'=>150, 'extra-bacon'=>80,
    'extra-olives'=>10, 'extra-egg'=>30, 'extra-hot-pepper'=>20,
    'extra-shoulder'=>200, 'extra-sardine'=>100, 'extra-minced-meat'=>150,
    'extra-corn'=>40, 'extra-seafood'=>150, 'extra-tuna'=>150,
    'extra-onion'=>40, 'extra-oregano'=>20, 'extra-prosciutto'=>300
];
foreach ($expectedExtras as $id=>$price) check($ids[$id]['variants'][0]['price']===$price, "Extra price $id");
check(!isset($ids['extra-jam-walnuts']), 'Combined extra removed');
check($ids['extra-jam']['name']['sr']==='Džem', 'Separate jam extra');
check($ids['extra-walnuts']['name']['sr']==='Orasi', 'Separate walnuts extra');
foreach (['extra-olives','extra-egg','extra-hot-pepper'] as $id) {
    check($ids[$id]['variants'][0]['label']==='piece', "Per-piece extra $id");
}
check($site['currency']==='RSD', 'All prices in dinars');
echo 'PASS: '.count($ids)." items, $variants price variants, ".count($categories)." categories, ".count($languages)." languages.\n";
