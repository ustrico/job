<?php
echo '<?xml version="1.0"?>';
echo '<?mso-application progid="Excel.Sheet"?>';
$ret = '';
$monthprice = 0;
?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">
    <Styles>
        <Style ss:ID="bold">
            <Font ss:Bold="1"/>
        </Style>
    </Styles>
    <Worksheet ss:Name="<?=$month?>">
        <Table>
            <Column ss:Width="40"/>
            <Column ss:Width="70"/>
            <Column ss:Width="200"/>
            <Column ss:Width="300"/>
            <Column ss:Width="50"/>
            <Column ss:Width="40"/>
            <Row>
                <Cell ss:StyleID="bold"><Data ss:Type="String">N</Data></Cell>
                <Cell ss:StyleID="bold"><Data ss:Type="String">Date</Data></Cell>
                <Cell ss:StyleID="bold"><Data ss:Type="String">Task</Data></Cell>
                <Cell ss:StyleID="bold"><Data ss:Type="String">Items</Data></Cell>
                <Cell ss:StyleID="bold"><Data ss:Type="String">Status</Data></Cell>
                <Cell ss:StyleID="bold"><Data ss:Type="String">Price</Data></Cell>
            </Row>
<?php foreach ($tasks as $task) {
    $finalprice = 0;
    echo '<Row>';
    echo '<Cell><Data ss:Type="String">' . $task->id . '</Data></Cell>';
    //$date = ($task->date) ? $task->date . ' ' : '';
    $date = '';
    //if (($task->end) && ($task->end!=$task->date) ) $date .= ' ' . $task->end;
    echo '<Cell><Data ss:Type="String">' . $date . '</Data></Cell>';
    $name = (($task->name)) ? $task->name : '';
    //if (!empty($task->description)) $name .= ': ' . $task->description;
    //echo '<Cell><Data ss:Type="String">' . $name . '</Data></Cell>';
    $taskitems = '';
    if ($task->items) {
        $items = unserialize($task->items);
        foreach ($items as $item) {
            if ( !empty($item['cat']) ) $taskitems .= $item['cat'] . ': ';
            if ( !empty($item['name']) ) $taskitems .= $item['name'] . ' ';
            if ( !empty($item['price']) ) {
                $taskitems .= $item['price'];
                $times = ( !empty($item['times']) ) ? $item['times'] : 1;
                $finalprice += $item['price'] * $times;
            }
            if ( !empty($item['times']) ) $taskitems .= '×' . $item['times'];
            $taskitems .= '     ';
        }
    }
    //echo '<Cell><Data ss:Type="String">' . $taskitems . '</Data></Cell>';
    $state = ($task->state) ? $task->state : '';
    //$ret .= '<Cell><Data ss:Type="String">' . $state . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . $finalprice . '</Data></Cell>';
    echo '</Row>';
    $monthprice += $finalprice;
}?>
            <Row>
                <Cell ss:StyleID="bold"><Data ss:Type="String"><?=$monthprice?></Data></Cell>
            </Row>
        </Table>
    </Worksheet>
</Workbook>