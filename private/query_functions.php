<?php 

function find_all_subjects(){
    global $connection;
    $sql = "SELECT * FROM subjects ORDER BY position ASC";
    $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function find_subject_by_id($id)
{
    global $connection;
    $sql = "SELECT * FROM subjects WHERE id='" . $id . "'";
    $result = $connection->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function insert_subject($menu_name, $position, $visible){
    global $connection;
    $sql = "INSERT INTO subjects ";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES (";
    $sql .= "'" . $menu_name . "',";
    $sql .= "'" . $position . "',";
    $sql .= "'" . $visible . "'";
    $sql .= ")";
    // $result = $connection->prepare($sql);
    // $result->execute();
    $result = $connection->query($sql);

    if ($result) {
        return true;
    } else {
        exit('Error connecting to database');
    }
}

function find_all_pages()
{
    global $connection;
    $sql = "SELECT * FROM pages ORDER BY subject_id ASC, position ASC";
    $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

?>