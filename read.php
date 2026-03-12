<?php
include 'db.php';
$all_fields = [
    'stud_no' => 'Student No',
    'lastname' => 'Last Name',
    'firstname' => 'First Name',
    'sex' => 'Sex',
    'bdate' => 'Birth Date',
    'age' => 'Age',
    'religion' => 'Religion',
    'talent' => 'Talent'
];
$selected_fields = isset($_GET['fields']) && is_array($_GET['fields']) ? $_GET['fields'] : array_keys($all_fields);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Classmates</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>View Classmates</h2>
        <div class="actions">
            <a href="index.php">Back to Home</a> | <a href="create.php">Add New Record</a>
        </div>

        <form method="GET" action="" class="filter-bar">
            <div>
                <label>Filter by Last Name:</label>
                <input type="text" name="filter_lname" value="<?php echo isset($_GET['filter_lname']) ? htmlspecialchars($_GET['filter_lname']) : ''; ?>">
            </div>
            <div>
                <label>Sort by:</label>
                <select name="sort_field">
                    <option value="stud_no" <?php if (isset($_GET['sort_field']) && $_GET['sort_field'] == 'stud_no') 
echo 'selected'; ?>>Student No</option>
                    <option value="lastname" <?php if (isset($_GET['sort_field']) && $_GET['sort_field'] == 'lastname') 
echo 'selected'; ?>>Last Name</option>
                    <option value="firstname" <?php if (isset($_GET['sort_field']) && $_GET['sort_field'] == 'firstname') 
echo 'selected'; ?>>First Name</option>
                    <option value="age" <?php if (isset($_GET['sort_field']) && $_GET['sort_field'] == 'age') 
echo 'selected'; ?>>Age</option>
                    <option value="religion" <?php if (isset($_GET['sort_field']) && $_GET['sort_field'] == 'religion') 
echo 'selected'; ?>>Religion</option>
                    <option value="talent" <?php if (isset($_GET['sort_field']) && $_GET['sort_field'] == 'talent') 
echo 'selected'; ?>>Talent</option>
                </select>
            </div>
            <div>
                <label>Order:</label>
                <select name="sort_order">
                    <option value="ASC" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'ASC') 
echo 'selected'; ?>>ASC</option>
                    <option value="DESC" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC') 
echo 'selected'; ?>>DESC</option>
                </select>
            </div>
            <div class="checkbox-section">
                <label class="checkbox-section-label">Select Fields:</label>
                <div class="checkbox-group">
                    <?php
                    foreach ($all_fields as $field_key => $field_label) {
                        $checked = in_array($field_key, $selected_fields) ? 'checked' : '';
                        echo "<label class='checkbox-label'>$field_label <input type='checkbox' name='fields[]' value='$field_key' $checked></label>";
                    }
                    ?>
                </div>
            </div>
            <button type="submit" class="apply-btn">Apply</button>
        </form>

        <div class="table-responsive">
            <table>
                <tr>
                    <?php if (in_array('stud_no', $selected_fields)) echo "<th>Student No</th>"; ?>
                    <?php if (in_array('lastname', $selected_fields)) echo "<th>Last Name</th>"; ?>
                    <?php if (in_array('firstname', $selected_fields)) echo "<th>First Name</th>"; ?>
                    <?php if (in_array('sex', $selected_fields)) echo "<th>Sex</th>"; ?>
                    <?php if (in_array('bdate', $selected_fields)) echo "<th>Birth Date</th>"; ?>
                    <?php if (in_array('age', $selected_fields)) echo "<th>Age</th>"; ?>
                    <?php if (in_array('religion', $selected_fields)) echo "<th>Religion</th>"; ?>
                    <?php if (in_array('talent', $selected_fields)) echo "<th>Talent</th>"; ?>
                    <th>Actions</th>
                </tr>
                <?php
$filter_lname = isset($_GET['filter_lname']) ? $conn->real_escape_string($_GET['filter_lname']) : '';
$sort_field = isset($_GET['sort_field']) ? $_GET['sort_field'] : 'stud_no';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

$valid_sort_fields = ['stud_no', 'lastname', 'firstname', 'age', 'religion', 'talent'];
if (!in_array($sort_field, $valid_sort_fields)) {
    $sort_field = 'stud_no';
}
$sort_order = ($sort_order === 'DESC') ? 'DESC' : 'ASC';

$valid_db_fields = array_keys($all_fields);
$sql_select_fields = [];
foreach ($selected_fields as $field) {
    if (in_array($field, $valid_db_fields)) {
        $sql_select_fields[] = $field;
    }
}
// We always need stud_no for Edit/Delete actions
if (!in_array('stud_no', $sql_select_fields)) {
    $sql_select_fields[] = 'stud_no';
}
$select_clause = empty($sql_select_fields) ? '*' : implode(', ', $sql_select_fields);

$sql = "SELECT $select_clause FROM classmates_details WHERE lastname LIKE '%$filter_lname%' ORDER BY $sort_field $sort_order";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        if (in_array('stud_no', $selected_fields)) echo "<td>" . htmlspecialchars($row['stud_no'] ?? '') . "</td>";
        if (in_array('lastname', $selected_fields)) echo "<td>" . htmlspecialchars($row['lastname'] ?? '') . "</td>";
        if (in_array('firstname', $selected_fields)) echo "<td>" . htmlspecialchars($row['firstname'] ?? '') . "</td>";
        if (in_array('sex', $selected_fields)) echo "<td>" . htmlspecialchars($row['sex'] ?? '') . "</td>";
        if (in_array('bdate', $selected_fields)) echo "<td>" . htmlspecialchars($row['bdate'] ?? '') . "</td>";
        if (in_array('age', $selected_fields)) echo "<td>" . htmlspecialchars($row['age'] ?? '') . "</td>";
        if (in_array('religion', $selected_fields)) echo "<td>" . htmlspecialchars($row['religion'] ?? '') . "</td>";
        if (in_array('talent', $selected_fields)) echo "<td>" . htmlspecialchars($row['talent'] ?? '') . "</td>";
        echo "<td>
                <a href='update.php?stud_no=" . urlencode($row['stud_no']) . "'>Edit</a> |
                <a href='delete.php?stud_no=" . urlencode($row['stud_no']) . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
              </td>";
        echo "</tr>";
    }
}
else {
    $colspan = count($selected_fields) + 1;
    echo "<tr><td colspan='$colspan' style='text-align:center;'>No records found</td></tr>";
}
?>
            </table>
        </div>
    </div>
</body>
</html>
