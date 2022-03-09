<?php 
// PREPARE STATEMENT ZA SQL INJECTIONS
// SUBJECTS

function find_all_subjects(){
    global $connection;
    $sql = "SELECT * FROM subjects ORDER BY position ASC";
    $result = $connection->query($sql)->fetchAll();
    return $result;
    
}

function find_subject_by_id($id)
{
    global $connection;
    $sql = "SELECT * FROM subjects WHERE id='" . $id . "'";
    $result = $connection->query($sql)->fetch();
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
    $sql .= ":menu_name,";
    $sql .= ":position,";
    $sql .= ":visible";
    $sql .= ")";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':menu_name', $subject['menu_name']);
    $stmt->bindParam(':position', $subject['position']);
    $stmt->bindParam(':visible', $subject['visible']);
    $result = $stmt->execute();

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
    $sql .= "menu_name=:menu_name, ";
    $sql .= "position=:position, ";
    $sql .= "visible=:visible ";
    $sql .= "WHERE id=:id ";
    $sql .= "LIMIT 1";

    $stmt= $connection->prepare($sql);
    $stmt->bindParam(':menu_name', $subject['menu_name']);
    $stmt->bindParam(':position', $subject['position']);
    $stmt->bindParam(':visible', $subject['visible']);
    $stmt->bindParam(':id', $subject['id']);

    $result = $stmt->execute();

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
    $sql .= "WHERE id=:id ";
    $sql .= "LIMIT 1";
    $stmt = $connection -> prepare($sql);

    $stmt->bindParam(':id', $id);

    $result = $stmt->execute();

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
    $result = $connection->query($sql)->fetchAll();
    return $result;
}

function find_page_by_id($id)
{
    global $connection;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . $id . "'";
    $result =$connection->query($sql);
    $page = ($result)->fetch();;
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
    $sql .= ":subject_id,";
    $sql .= ":menu_name,";
    $sql .= ":position,";
    $sql .= ":visible,";
    $sql .= ":content";
    $sql .= ")";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':subject_id', $page['subject_id']);
    $stmt->bindParam(':menu_name', $page['menu_name']);
    $stmt->bindParam(':position', $page['position']);
    $stmt->bindParam(':visible', $page['visible']);
    $stmt->bindParam(':content', $page['content']);

    $result = $stmt->execute();
    
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
    $sql .= "subject_id=:subject_id, ";
    $sql .= "menu_name=:menu_name, ";
    $sql .= "position=:position, ";
    $sql .= "visible=:visible, ";
    $sql .= "content=:content ";
    $sql .= "WHERE id=:id ";
    $sql .= "LIMIT 1";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':subject_id', $page['subject_id']);
    $stmt->bindParam(':menu_name', $page['menu_name']);
    $stmt->bindParam(':position', $page['position']);
    $stmt->bindParam(':visible', $page['visible']);
    $stmt->bindParam(':content', $page['content']);
    $stmt->bindParam(':id', $page['id']);

    $result = $stmt->execute();

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
    $sql .= "WHERE id=:id ";
    $sql .= "LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        exit('Error connecting to database') ;
    }
}

function find_pages_by_subject_id($subject_id)
{
    global $connection;

    $sql = "SELECT * FROM pages ";
    $sql.= "WHERE subject_id='" . $subject_id . "' ";
    $sql.= "ORDER BY position ASC";
    $result = $connection->query($sql)->fetchAll();
    return $result;
}
?>