<?php $this->layout('app:layout'); ?>

<form class="uk-form" id="periodform">
        <select id="year">
            <option value="0" disabled>Year</option>
            <?php
            $yearlast = year;
            $year = date('Y');
            while ($year >= $yearlast) {
                $selected = ($fyear==$year) ? 'selected' : '';
                echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                $year--;
            } ?>
    </select>
    <select id="month">
        <option value="0" disabled>Month</option>
        <?php
        $months = explode('|', months);
        foreach ($months as $month){
            $mont = explode('=', $month);
            $selected = ($fmonth==$mont[0]) ? 'selected' : '';
            echo '<option value="' . $mont[0] . '"' . $selected . '>' . $mont[1] . '</option>';
        }
        ?>
    </select>
    <a href="/tasks/excel" class="uk-button" target="_blank">Excel</a>
    <a href="/tasks/excel/price" class="uk-button" target="_blank">Excel1</a>
</form>