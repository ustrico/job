<?php
$tree = array();
foreach ($price as $pric) {
    $tree[$pric->id] = $pric;
}
foreach ($tree as $k => $pric) {
    if ($pric->parentId!=0) {
        if ( empty($tree[$pric->parentId]->children) ){
            $tree[$pric->parentId]->children = array();
        }
        $tree[$pric->parentId]->children[] = $k;
    }
}

$tree1 = $tree;
$priceTree = array();
foreach ($tree1 as $pric) {
    if ($pric->parentId==0) {
        $priceTree[$pric->name] = array(
            'name' => $pric->name
        );
        if ( !empty($pric->children) ) {
            foreach ($pric->children as $child) {
                if ( !empty($tree1[$child]) ){
                    $priceTree[preg_replace("/[^a-zа-яё]+/iu", "", $pric->name . ': ' . $tree1[$child]->name)] = array(
                        'name' => $tree1[$child]->name,
                        'level' => 1,
                        'description' => $tree1[$child]->description,
                        'price' => $tree1[$child]->price,
                        'count' => 0,
                        'priceend' => 0,
                    );
                    if ( !empty($tree1[$child]->children) ){
                        foreach ($tree1[$child]->children as $chil) {
                            if ( !empty($tree1[$chil]) ){
                                $priceTree[preg_replace("/[^a-zа-яё]+/iu", "", $pric->name . ': ' . $tree1[$child]->name . ': ' . $tree1[$chil]->name)] = array(
                                    'name' => $tree1[$chil]->name,
                                    'level' => 2,
                                    'description' => $tree1[$chil]->description,
                                    'price' => $tree1[$chil]->price,
                                    'count' => 0,
                                    'priceend' => 0,
                                );
                                unset($tree1[$chil]);
                            }
                        }
                    }
                    unset($tree1[$child]);
                }
            }
        }
    }
}

$monthprice = 0;

foreach ($tasks as $task) {
    $finalprice = 0;
    if ($task->items) {
        $items = unserialize($task->items);
        foreach ($items as $item) {
            $taskitem = '';
            if ( isset($item['cat']) ) $taskitem .= $item['cat'];
            if ( isset($item['name']) ) $taskitem .= ': ' . $item['name'];
            $taskitem = preg_replace("/[^a-zа-яё]+/iu", "", $taskitem);
            $times = ( isset($item['times']) ) ? $item['times'] : 1;
            if (isset($priceTree[$taskitem])) {
                $priceTree[$taskitem]['count'] += $times;
                if ( isset($item['price']) ) {
                    $priceTree[$taskitem]['priceend'] += $item['price'] * $times;
                    $monthprice += $item['price'] * $times;
                }
            } else {
                if (!isset($priceTree['Прочее'])) {
                    $priceTree['Прочее'] = array(
                        'name' => 'Прочее'
                    );
                }
                $priceTree[$taskitem] = array(
                    'name' => $taskitem,
                    'level' => 1,
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'count' => $times,
                    'priceend' => $item['price'] * $times,
                );
                $monthprice += $item['price'] * $times;
            }
        }
    }
}

?>


<table border="1">
    <thead>
    <tr>
        <th width="100">Category</th>
        <th width="400" colspan="2">Task</th>
        <th width="60">Price</th>
        <th width="60">Count</th>
        <th width="60">Total</th>
    </tr>
    </thead><tbody>
<?php
$catprice = 0;
foreach ($priceTree as $price) {
    if (isset($price['level'])) {
        echo '<tr>';
        for ($i=0; $i<$price['level']; $i++){
            echo '<td></td>';
        }
        echo '<td>' . $price['name'] . ( ( $price['description'] ) ? '<br><em style="color:#666666;font-size:12px;">' . $price['description'] . '</em>' : '' ) . '</td>';
        if ($price['level']==1) {
            echo '<td></td>';
        }
        echo '<td>' . ( ( $price['price'] ) ? str_replace('.', ',', $price['price']) : '' )  . '</td>';
        echo '<td>' . ( ( $price['count'] ) ? str_replace('.', ',', $price['count']) : '' )  . '</td>';
        echo '<td><strong>' . ( ( $price['priceend'] ) ? str_replace('.', ',', $price['priceend']) : '' )  . '</strong></td>';
        $catprice += $price['priceend'];
        echo '</tr>';
    } else {
        if ($catprice){
            echo '<tr><td></td><td></td><td></td><td></td><td></td><td><em style="color:#666666;">' . str_replace('.', ',', $catprice) . '</em></td></tr>';
            $catprice = 0;
        }
        echo '<tr><td><strong>' . $price['name'] . '</strong></td></tr>';
    }

}
if ($catprice){
    echo '<tr><td></td><td></td><td></td><td></td><td></td><td><em style="color:#666666;">' . str_replace('.', ',', $catprice) . '</em></td></tr>';
}
?>
    <tr>
        <td></td><td></td><td></td><td></td><td></td><td><strong><?=str_replace('.', ',', $monthprice)?></strong></td>
    </tr>
</tbody></table>

