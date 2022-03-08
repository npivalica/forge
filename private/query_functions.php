<?php 

// SUBJECTS

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

function validate_subject($subject)
{

    $errors = [];

    // menu_name
    if (is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    }
    elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // position
    $postion_int = (int) $subject['position'];
    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    $visible_str = (string) $subject['visible'];
    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    return $errors;
}


function insert_subject($subject){
    global $connection;

    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO subjects ";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES (";
    $sql .= "'" . $subject['menu_name'] . "',";
    $sql .= "'" . $subject['position'] . "',";
    $sql .= "'" . $subject['visible'] . "'";
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

    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

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
        exit('Error connecting to database') ;
    }
}

// PAGES

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

function validate_page($page)
{
    $errors = [];

    // subject_id
    if (is_blank($page['subject_id'])) {
        $errors[] = "Subject cannot be blank.";
    }

    // menu_name
    if (is_blank($page['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ?? '0';
    if(!has_unique_page_menu_name($page['menu_name'], $current_id)){
        $errors[] = "Menu name must be unique.";
    }

    // position
    $postion_int = (int) $page['position'];
    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    $visible_str = (string) $page['visible'];
    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    // content
    if (is_blank($page['content'])) {
        $errors[] = "Content cannot be blank.";
    }

    return $errors;
}

function insert_page($page)
{
    global $connection;

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

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
        exit('Error connecting to database') ;
    }
}

function update_page($page)
{
    global $connection;

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

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
        exit('Error connecting to database') ;
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
        exit('Error connecting to database') ;
    }
}
?>