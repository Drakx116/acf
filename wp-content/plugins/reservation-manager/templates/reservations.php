<?php

global $wpdb;

$reservationTable = $wpdb->prefix . 'reservation';
$postsTable = $wpdb->prefix . 'posts';

$query2 =
    "SELECT * FROM " . $reservationTable . " " .
    "INNER JOIN " . $postsTable . " " .
    "ON " . $reservationTable . ".reservation = " . $postsTable . ".ID";

$reservations = $wpdb->get_results($query2);

?>

<div>
    <h1> Réservations </h1>
    <p><b>Total : <?php echo count($reservations); ?></b></p>
    <?php
        foreach ($reservations as $reservation) {
            $line = json_decode(json_encode($reservation, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
            $people = ($line['people'] > 1)
                ? 'de ' . $line['people'] . ' personnes'
                : 'd\'une seule personne';

            echo '<span><b>' . $line['email'] . '</b> (' . $line['phone'] . ') a effectué une réservation ' . $people . ' pour l\'évenement : ' . $line['post_title'] . '.</span><br>';
        }
    ?>
</div>
<?php
