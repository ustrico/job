<?php
$monthprice = 0;
echo '<ul id="tasks" class="uk-list uk-list-line">';

foreach ($tasks as $task) {
    $finalprice = 0;
    echo '<li data-id="' . $task->id . '" class="uk-grid task">';
    echo '<div class="id uk-width-1-10">';
        echo '<a href="/tasks/view/' . $task->id . '" data-href="/tasks/view/' . $task->id . '" data-uk-modal>' . $task->id . '</a>';
        if (!empty($task->brand)) echo '<div class="brand Brand' . $task->brand . ' uk-badge"></div>';
    echo '</div>';
    echo '<div class="date uk-width-1-10">';
        if (!empty($task->date)) echo $task->date;
        if (!empty($task->end) && ($task->end!=$task->date) ) echo '<br>' . $task->end;
    echo '</div>';
    echo '<div class="name uk-width-2-10">';
        if (!empty($task->name)) echo $task->name;
        if (!empty($task->description)) echo '<div class="description">' . $task->description . '</div>';
    echo '</div>';
    echo '<div class="items uk-width-4-10">';
        if (!empty($task->items)) {
            $items = unserialize($task->items);
            foreach ($items as $item) {
                echo '<div class="price">';
                if ( !empty($item['cat']) ) echo '<div class="cat">' . $item['cat'] . '</div>';
                echo '<div class="name">';
                if ( !empty($item['name']) ) echo '<span class="namei">' . $item['name'] . '</span>';
                if ( !empty($item['price']) ) {
                    echo '<div class="cost uk-badge">' . $item['price'] . '</div>';
                    $times = ( !empty($item['times']) ) ? $item['times'] : 1;
                    $finalprice += $item['price'] * $times;
                }
                if ( !empty($item['times']) ) echo '<div class="costtimes">&times; ' . $item['times'] . '</div>';
                echo '</div>';
                if ( !empty($item['description']) ) echo  '<div class="description">' . $item['description'] . '</div>';
                echo '</div>';
            }
        }
    echo '</div>';
    echo '<div class="state uk-width-1-10">';
    if (!empty($task->state)) echo '<div class="state ' . $task->state . ' uk-badge">' . $task->state . '</div>';
    echo '</div>';
    echo '<div class="edit uk-width-1-10">';
        if (!empty($admin)) echo '<a href="/tasks/edit/' . $task->id . '"><i class="uk-icon-edit button"></i></a>';
        if ($finalprice) echo '<span class="finalprice">' . $finalprice . '</span>';
    echo '</div>';
    echo '</li>';
    $monthprice += $finalprice;
}

echo '</ul>';

echo '<h2>' . $monthprice . '</h2>';