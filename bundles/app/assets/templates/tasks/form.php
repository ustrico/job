<?php $this->layout('app:layout');
$enum = array(
    'state' => array('New','InProgress','Done'),
    'brand' => array('Marya','EdimDoma','Mia','WakeSurf'),
);
$task = array(
    'id' => '',
    'name' => '',
    'description' => '',
    'state' => 'New',
    'date' => date('Y-m-d'),
    'end' => '',
    'brand' => '',
    'items' => ''
);
if (!empty($edit)) {
    if ($edit->id)             $task['id'] = $edit->id;
    if ($edit->name)           $task['name'] = $edit->name;
    if ($edit->description)    $task['description'] = $edit->description;
    if ($edit->state)          $task['state'] = $edit->state;
    if ($edit->date)           $task['date'] = $edit->date;
    if ($edit->brand)          $task['brand'] = $edit->brand;
    if ($edit->items)          $items = unserialize($edit->items);
    $task['end'] = ($edit->end) ? $edit->end : date('Y-m-d');
}
?>

<form class="uk-form uk-form-horizontal" id="taskform" data-id="<?=$task['id']?>">
    <div class="uk-form-row">
        <label class="uk-form-label" for="name">Name</label>
        <div class="uk-form-controls">
            <input type="text" id="name" name="name" value="<?=$task['name']?>">
        </div>
    </div>
    <div class="uk-form-row">
        <span class="uk-form-label">Brand</span>
        <div class="uk-form-controls uk-form-controls-text radio" data-uk-button-radio>
            <?php foreach ($enum['brand'] as $barnd){ ?>
                <label class="uk-button <?=( ($task['brand']==$barnd) ? 'uk-active' : '' )?>">
                    <input type="radio" name="brand" value="<?=$barnd?>" <?=( ($task['brand']==$barnd) ? 'checked' : '' )?>> <?=$barnd?>
                </label>
            <?php } ?>
        </div>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label" for="description">Description</label>
        <div class="uk-form-controls">
            <textarea id="description" name="description" rows="3" ><?=$task['description']?></textarea>
        </div>
    </div>
    <div class="uk-form-row">
        <span class="uk-form-label">State</span>
        <div class="uk-form-controls uk-form-controls-text radio" data-uk-button-radio>
            <label class="uk-button <?=( ($task['state']=='New') ? 'uk-active' : '' )?>"><input type="radio" name="state" value="New" <?=( ($task['state']=='New') ? 'checked' : '' )?>> New</label>
            <label class="uk-button <?=( ($task['state']=='InProgress') ? 'uk-active' : '' )?>"><input type="radio" name="state" value="InProgress" <?=( ($task['state']=='InProgress') ? 'checked' : '' )?>> InProgress</label>
            <label class="uk-button <?=( ($task['state']=='Done') ? 'uk-active' : '' )?>"><input type="radio" name="state" value="Done" <?=( ($task['state']=='Done') ? 'checked' : '' )?>> Done</label>
        </div>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label" for="items">Items</label>
        <div class="uk-form-controls">
            <div id="items">
            <?php
            if (!empty($items)) {
                foreach ($items as $item) {
                    echo '<div class="price">';
                    if ( !empty($item['cat']) ) echo '<div class="cat">' . $item['cat'] . '</div>';
                    echo '<div class="name">';
                    if ( !empty($item['name']) ) echo '<span class="namei">' . $item['name'] . '</span>';
                    if ( !empty($item['price']) ) echo '<div class="cost uk-badge">' . $item['price'] . '</div>';
                    echo '<div class="costtimes">&times;<input type="text" class="times" value="' . ( (!empty($item['times'])) ? $item['times'] : 1 ) . '"> <span class="uk-badge plusminus" data-sign="-1">&minus;</span> <span class="uk-badge plusminus" data-sign="1">+</span></div>';
                    echo '<a class="remove"></a>';
                    echo '</div>';
                    if ( !empty($item['description']) ) echo  '<div class="description">' . $item['description'] . '</div>';
                    echo '</div>';
                }
            }
            ?>
            </div>
        </div>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label" for="date">Date</label>
        <div class="uk-form-controls">
            <input type="date" id="date" name="date" value="<?=$task['date']?>"> Start ... <input type="date" id="end" name="end" value="<?=$task['end']?>"> Finish
        </div>
    </div>
    <div class="uk-form-row">
        <div class="uk-form-controls">
            <input type="submit" id="save" name="save" value="Save" class="uk-button uk-button-primary">
            <div id="progress" class="progress"></div>
        </div>
    </div>
</form>
