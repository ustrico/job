<?php
if (empty($ajax)) $this->layout('app:layout');

$finalprice = 0;
echo '<div data-id="' . $task->id . '" class="task task-view">';
echo '<div class="id">';
    echo '<a href="/tasks/view/' . $task->id . '" data-href="/tasks/view/' . $task->id . '" data-uk-modal>' . $task->id . '</a>';
    if ($task->brand) echo '<div class="brand Brand' . $task->brand . ' uk-badge"></div>';
echo '</div>';
echo '<div class="date">';
if ($task->date) echo $task->date;
if ($task->end && ($task->end!=$task->date) ) echo '<br>' . $task->end;
echo '</div>';
echo '<div class="name">';
if ($task->name) echo $task->name;
if ($task->description) echo '<div class="description">' . $task->description . '</div>';
echo '</div>';
echo '<div class="items">';
if ($task->items) {
    $items = unserialize($task->items);
    foreach ($items as $item) {
        echo '<div class="price">';
        if ( $item['cat'] ) echo '<div class="cat">' . $item['cat'] . '</div>';
        echo '<div class="name">';
        if ($item['name'] ) echo '<span class="namei">' . $item['name'] . '</span>';
        if ( $item['price'] ) {
            echo '<div class="cost uk-badge">' . $item['price'] . '</div>';
            $times = ( $item['times'] ) ? $item['times'] : 1;
            $finalprice += $item['price'] * $times;
        }
        if ( $item['times'] ) echo '<div class="costtimes">&times; ' . $item['times'] . '</div>';
        echo '</div>';
        if ( $item['description'] ) echo  '<div class="description">' . $item['description'] . '</div>';
        echo '</div>';
    }
}
echo '</div>';
echo '<div class="state">';
if ($task->state) echo '<div class="state ' . $task->state . ' uk-badge">' . $task->state . '</div>';
echo '</div>';
echo '<div class="edit">';
if (!empty($admin)) echo '<a href="/tasks/edit/' . $task->id . '"><i class="uk-icon-edit button"></i></a>';
if ($finalprice) echo '<span class="finalprice">' . $finalprice . '</span>';
echo '</div>';
echo '</div>';