<?php 
// SUBJECTS

function find_all_subjects($options=[]){
    global $connection;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM subjects ";
    if($visible){
        $sql.= "WHERE visible = true ";
    }
    $sql.= "ORDER BY position ASC";
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

function find_page_by_id($id, $options = [])
{
    global $connection;

    $visible = $options['visible'] ?? false;


    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . $id . "' ";
    if($visible){
        $sql.= "AND visible=true";
    }
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

function find_pages_by_subject_id($subject_id, $options = [])
{
    global $connection;
    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql.= "WHERE subject_id='" . $subject_id . "' ";
    if($visible){
        $sql.= "AND visible=true ";
    }
    $sql.= "ORDER BY position ASC";
    $result = $connection->query($sql)->fetchAll();
    return $result;
}

// ADMINS
// Find all admins, ordered last_name, first_name
function find_all_admins()
{
    global $connection;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = $connection->query($sql)->fetchAll();
    return $result;
}

function find_admin_by_id($id)
{
    global $connection;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . $id . "' ";
    $sql .= "LIMIT 1";
    $result = $connection->query($sql)->fetch();
    return $result;
}

function find_admin_by_username($username)
{
    global $connection;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . $username . "' ";
    $sql .= "LIMIT 1";
    $result = $connection->query($sql)->fetch();
    return $result;
}

function validate_admin($admin)
{

    if (is_blank($admin['first_name'])) {
        $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
        $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($admin['last_name'])) {
        $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
        $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($admin['email'])) {
        $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], array('max' => 255))) {
        $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
        $errors[] = "Email must be a valid format.";
    }

    if (is_blank($admin['username'])) {
        $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
        $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
        $errors[] = "Username not allowed. Try another.";
    }

    if (is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
    } elseif (!has_length($admin['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
    } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
    } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
    } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
    }

    if (is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
    } elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
    }

    return $errors;
}

function insert_admin($admin)
{
    global $connection;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (:first_name, :last_name, :email, :username, :hashed_password )";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':first_name', $admin['first_name']);
    $stmt->bindParam(':last_name', $admin['last_name']);
    $stmt->bindParam(':email', $admin['email']);
    $stmt->bindParam(':username', $admin['username']);
    $stmt->bindParam(':hashed_password', $hashed_password);

    $result = $stmt->execute();

    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        exit;
    }
}

function update_admin($admin)
{
    global $connection;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name=:first_name, ";
    $sql .= "last_name=:last_name, ";
    $sql .= "email=:email, ";
    $sql .= "hashed_password=:hashed_password,";
    $sql .= "username=:username ";
    $sql .= "WHERE id=:id ";
    $sql .= "LIMIT 1";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':first_name', $admin['first_name']);
    $stmt->bindParam(':last_name', $admin['last_name']);
    $stmt->bindParam(':email', $admin['email']);
    $stmt->bindParam(':username', $admin['username']);
    $stmt->bindParam(':id', $admin['id']);
    $stmt->bindParam(':hashed_password', $hashed_password);

    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        // UPDATE failed
        exit;
    }
}

function delete_admin($admin)
{
    global $connection;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id=:id ";
    $sql .= "LIMIT 1;";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        // DELETE failed
        exit;
    }
}

?>
