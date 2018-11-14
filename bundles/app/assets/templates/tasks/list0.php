<?php $this->layout('app:layout');
$monthprice = 0;
?>

<form class="uk-form" id="periodform">
    <select id="year">
        <option value="0" disabled>Year</option>
        <?php
        $yearlast = $confi['year'];
        $year = date('Y');
        while ($year >= $yearlast) {
            echo '<option value="' . $year . '">' . $year . '</option>';
            $year--;
        } ?>
    </select>
    <select id="month">
        <option value="0" disabled>Month</option>
        <?php
        $months = $confi['months'];
        foreach ($months as $k => $month){
            echo '<option value="' . $k . '">' . $month . '</option>';
        }
        ?>
    </select>
</form>

<?php
echo '<ul id="tasks" class="uk-list uk-list-line">';

foreach ($tasks as $task) {
    $finalprice = 0;
    echo '<li data-id="' . $task->id . '" class="uk-grid task">';
    echo '<div class="id uk-width-1-10"><a href="/tasks/view/' . $task->id . '" data-href="/tasks/view/' . $task->id . '" data-uk-modal>' . $task->id . '</a></div>';
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
        echo '<a href="/tasks/edit/' . $task->id . '"><i class="uk-icon-edit button"></i></a>';
        echo '<span class="finalprice">' . $finalprice . '</span>';
    echo '</div>';
    echo '</li>';
    $monthprice += $finalprice;
}

echo '</ul>';

echo '<h2>' . $monthprice . '</h2>';

?>

<div id="modaltask" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-modal-header">Task</div>
        <div class="uk-modal-body">...</div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
