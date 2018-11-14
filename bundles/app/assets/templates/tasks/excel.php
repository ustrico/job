<?php
$monthprice = 0;
?>
<table border="1">
    <thead>
    <tr>
        <th width="40">N</th>
        <th width="70">Date</th>
        <th width="70">Brand</th>
        <th width="200">Task</th>
        <th width="300">Items</th>
        <th width="70">Status</th>
        <th width="40">Price</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task) {
        $finalprice = 0;
        echo '<tr>';
        echo '<td>' . $task->id . '</td>';
        $date = ($task->date) ? $task->date . ' ' : '';
        if (($task->end) && ($task->end!=$task->date) ) $date .= ' ' . $task->end;
        echo '<td>' . $date . '</td>';
        echo '<td>' . $task->brand . '</td>';
        $name = (($task->name)) ? $task->name : '';
        if (!empty($task->description)) $name .= ': <em style="font-size:10px;color:#666666;display:block;max-height:40px;">' . $task->description . '</em>';
        echo '<td>' . $name . '</td>';
        $taskitems = '';

        if ($task->items) {
            $items = unserialize($task->items);
            foreach ($items as $item) {
                if ( isset($item['cat']) ) $taskitems .= $item['cat'] . ': ';
                if ( isset($item['name']) ) $taskitems .= $item['name'] . ' ';
                if ( isset($item['price']) ) {
                    $taskitems .= $item['price'];
                    $times = ( isset($item['times']) ) ? $item['times'] : 1;
                    $finalprice += $item['price'] * $times;
                }
                if ( isset($item['times']) ) $taskitems .= '×' . $item['times'];
                $taskitems .= '<br>';
            }
        }

        echo '<td>' . $taskitems . '</td>';
        $state = ($task->state) ? $task->state : '';
        echo '<td>' . $state . '</td>';
        echo '<td><b>' . str_replace('.', ',', $finalprice) . '</b></td>';
        echo '</tr>';
        $monthprice += $finalprice;
    }?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?=str_replace('.', ',', $monthprice)?></td>
        </tr>
    </tbody>
</table>