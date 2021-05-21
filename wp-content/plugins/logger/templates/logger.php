<?php

global $wpdb;

$table = $wpdb->prefix . 'logger';
$logs = $wpdb->get_results("SELECT * FROM " . $table);

?>

<div>
    <h1> Logs</h1>
    <p><b>Total : <?php echo count($logs); ?></b></p>
    <?php
        foreach ($logs as $log) {
            $line = json_decode(json_encode($log, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
            echo '<span><b>' . $line['type'] . '</b> ' . $line['entity'] . ' has been ' . $line['action'] . ' by ' . $line['user'] . ' on the ' . $line['date'] . ' </span><br>';
        }
    ?>
</div>
<?php
