<?php 

function find_all_subjects(){
    global $connection;
    $sql = "SELECT * FROM subjects ORDER BY position ASC";
    $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function find_all_pages()
{
    global $connection;
    $sql = "SELECT * FROM pages ORDER BY subject_id ASC, position ASC";
    $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

?>