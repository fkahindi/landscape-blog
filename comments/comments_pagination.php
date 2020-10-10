<?php
$page_no = 1;
$no_of_comments_per_view = 5;

$offset = ($page_no - 1)*$no_of_comments_per_view;

$number_of_pages = ceil($total_comments/$no_of_comments_per_view);

$limit=" LIMIT $offset, $no_of_comments_per_view";
?>
