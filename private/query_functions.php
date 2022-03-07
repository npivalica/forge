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

function update_subject($subject){
    global $connection;

    $sql = "UPDATE subjects SET ";
    $sql .= "menu_name='" . $subject['menu_name'] . "', ";
    $sql .= "position='" . $subject['position'] . "', ";
    $sql .= "visible='" . $subject['visible'] . "' ";
    $sql .= "WHERE id='" . $subject['id'] . "' ";
    $sql .= "LIMIT 1";

    $result = $connection->query($sql);
    if ($result) {
        return true;
    } else {
        exit('Error connecting to database');
    }
}

function delete_subject($id)
{
    global $connection;

    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . $id . "' ";
    $sql .= "LIMIT 1";
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

function find_page_by_id($id)
{
        global $connection;


    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . $id . "'";
    $result =$connection->query($sql);
    $page = ($result)->fetch(PDO::FETCH_ASSOC);;
    return $page;
}

function insert_page($page)
{
    global $connection;

    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content) ";
    $sql .= "VALUES (";
    $sql .= "'" . $page['subject_id'] . "',";
    $sql .= "'" . $page['menu_name'] . "',";
    $sql .= "'" . $page['position'] . "',";
    $sql .= "'" . $page['visible'] . "',";
    $sql .= "'" . $page['content'] . "'";
    $sql .= ")";
    $result =$connection->query($sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        exit('Error connecting to database');
    }
}

function update_page($page)
{
    global $connection;


    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . $page['subject_id'] . "', ";
    $sql .= "menu_name='" . $page['menu_name'] . "', ";
    $sql .= "position='" . $page['position'] . "', ";
    $sql .= "visible='" . $page['visible'] . "', ";
    $sql .= "content='" . $page['content'] . "' ";
    $sql .= "WHERE id='" . $page['id'] . "' ";
    $sql .= "LIMIT 1";

    $result =$connection->query($sql);
    if ($result) {
        return true;
    } else {
        exit('Error connecting to database');
    }
}

function delete_page($id)
{
    global $connection;


    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . $id . "' ";
    $sql .= "LIMIT 1";
    $result =$connection->query($sql);

    if ($result) {
        return true;
    } else {
        exit('Error connecting to database');
    }
}
?>