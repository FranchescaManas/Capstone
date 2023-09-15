<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone2/shared/connection.php';

function logout()
{
    $_SESSION = array();
    session_destroy();
    header('location: ../index.php');
    exit;
}

function getUsername()
{
    return $_SESSION['username'];
}
function getRole()
{
    return $_SESSION['role'];
}function insertResponse($role, $formData)
{
    $conn = connection();
    if (is_array($formData['form_id'])) {
        $formID = $formData['form_id'][0];
    } else {
        $formID = $formData['form_id'];
    }
    $userID = $formData['user_id'];
    $responses = $formData['response'];
    $eval_date = $formData['submission_date'];
    $targetID = $formData['target_id'];

    $responseSQL = "INSERT INTO form_response (`form_id`, `user_id`, `question_id`, `response_value`, `response_type`) VALUES ";

    // Handle different question types and their respective response values
    foreach ($responses as $response) {
        $questionID = $response['question_id'];
        $responseValue = $response['response_value'];
        $questionType = $response['question_type'];

        $response = '';

        switch ($questionType) {
            case 'choice':
                $response = json_encode(['value' => $responseValue['selected_choice']]);
                break;
            case 'dropdown':
                $response = json_encode(['value' => $responseValue['selected_option']]);
                break;
            case 'date':
            case 'time':
            case 'textbox':
            case 'paragraph':
                // Format and escape the string
                $response = json_encode(['value' => mysqli_real_escape_string($conn, $responseValue[$questionType . '_response'])]);
                break;
            case 'scale':
                // Encode the value as JSON
                $response = json_encode(['value' => $responseValue['scale_responses']]);
                break;
            default:
                // Handle unknown question types
                break;
        }

        $response = mysqli_real_escape_string($conn, $response);

        // Prepare the SQL statement
        $values[] = "($formID, $userID, $questionID, '$response', '$questionType')";
    }

    $responseSQL .= implode(",", $values);
    // echo $responseSQL;

    if ($conn->query($responseSQL) !== TRUE) {
        echo "Error: " . $responseSQL . "<br>" . $conn->error;
        return; // Return an error indicator
    } else {
        $sql = "INSERT INTO evaluation (`evaluator_id`, `target_id`, `form_id`, `eval_date`)
        VALUES ($userID, $targetID, $formID, '$eval_date')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return; // Return an error indicator
        }

        echo "success";
        $conn->close();
    }
}




function facultyAutofill(){
    $conn = connection();

    $autofillData = array();

    $sql = "SELECT f.faculty_id, f.user_id, u.firstname, u.lastname FROM faculty f LEFT JOIN users u ON f.user_id = u.user_id;
    ";

    $result = $conn->query($sql);

    if($result){
        while($row = $result->fetch_assoc()){
            $fullname = $row['firstname'] . ' '. $row['lastname'];
            $autofillData[$row['faculty_id']] = $fullname;
        }
        return $autofillData;
    }
}
function createForm($role, $formData)
{
    $conn = connection();
    $formID = 0;
    $sectionID = null; // Initialize with null to represent no section
    $section_count = 0;
    foreach ($formData['data'] as $item) {
        if ($item['type'] === 'form-title') {
            $formTitle = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';

            $sql = "INSERT INTO form (`form_name`, `form_description`, `form_type`, `start_date`, `end_date`, `is_open`) 
            VALUES ('$formTitle', 'null', null, null, null, 0)";

            if ($conn->query($sql)) {
                $formID = $conn->insert_id;

                // Insert into form_permission with default values
                $insertPermissionSql = "INSERT INTO form_permission (`user_id`, `role`, `form_id`, `can_access`, `can_modify`)
                 VALUES (0, 'superadmin', '$formID', 1, 1)";

                if (!$conn->query($insertPermissionSql)) {
                    echo "Error: " . $insertPermissionSql . "<br>" . $conn->error;
                }
                // Insert into form_permission with default values
                $insertPageSql = "INSERT INTO form_page (`form_id`,`page_sequence`)
                 VALUES ($formID, 1)";

                if ($conn->query($insertPageSql) === TRUE) {
                    $pageID = $conn->insert_id; // Retrieve the inserted section_id
                } else {
                    echo "Error inserting section: " . $conn->error;
                }
            } else {
                echo "Error inserting form: " . $conn->error;
            }
        } else if ($item['type'] === 'section') {
            $sectionName = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $section_count++;

            $sql = "INSERT INTO form_section (`form_id`, `section_name`, `section_order`, `page_id`) VALUES
            ('$formID', '$sectionName', $section_count, $pageID)";

            if ($conn->query($sql) === TRUE) {
                $sectionID = $conn->insert_id; // Retrieve the inserted section_id
            } else {
                echo "Error inserting section: " . $conn->error;
            }
        } else {
            $question = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $questionType = isset($item['type']) ? mysqli_real_escape_string($conn, $item['type']) : '';
            $options = isset($item['options']) ? json_encode($item['options']) : null;
            $questionOrder = isset($item['order']) ? $item['order'] : 0;

            $sql = "INSERT INTO form_question (`section_id`, `question_text`, `question_type`, `options`, `question_order`, `form_id`, `page_id`)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssiii", $sectionID, $question, $questionType, $options, $questionOrder, $formID, $pageID);

            if ($stmt->execute()) {
                // Query executed successfully
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }

    $conn->close();
}

function deleteForm($formID)
{
    $conn = connection();

    // Delete from form_question table
    $deleteFormPermission = "DELETE FROM form_permission WHERE form_id = '$formID'";
    if ($conn->query($deleteFormPermission) === FALSE) {
        echo "Error deleting from form_question: " . $conn->error;
    }
    // Delete from form_question table
    $deleteFormQuestions = "DELETE FROM form_question WHERE form_id = '$formID'";
    if ($conn->query($deleteFormQuestions) === FALSE) {
        echo "Error deleting from form_question: " . $conn->error;
    }
    // Delete from form_section table
    $deleteFormSections = "DELETE FROM form_section WHERE form_id = '$formID'";
    if ($conn->query($deleteFormSections) === FALSE) {
        echo "Error deleting from form_section: " . $conn->error;
    }


    // Delete from form page
    $deletePage = "DELETE FROM form_page WHERE form_id = '$formID'";
    if ($conn->query($deletePage) === FALSE) {
        echo "Error deleting from form: " . $conn->error;
    }
    // Delete from form table
    $deleteForm = "DELETE FROM form WHERE form_id = '$formID'";
    if ($conn->query($deleteForm) === FALSE) {
        echo "Error deleting from form: " . $conn->error;
    }

    $conn->close();

}
function getFormName($formID)
{
    $conn = connection();

    $sql = "SELECT form_name FROM form where form_id = $formID";

    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $formName = $row['form_name'];
    }


    return $formName;
}


function loadFormData($role, $formID){
    $conn = connection();
    $pageQuery = "SELECT
                fp.page_id,
                fp.page_sequence
            FROM
                form_page fp
            WHERE
                fp.form_id = $formID
            ORDER BY
                fp.page_sequence ASC;";

$sql = "SELECT
            f.form_id,
            f.form_name,
            f.form_description,
            f.form_type,
            f.start_date,
            f.end_date,
            f.is_open,
            fp.page_id,
            fp.page_sequence,
            fq.question_id,
            fq.question_text,
            fq.question_type,
            fq.options,
            fq.question_order,
            fq.form_id AS form_question_form_id,
            fq.section_id,
            fs.section_name,
            fs.section_order
        FROM
            form f
        LEFT JOIN
            form_question fq ON f.form_id = fq.form_id
        LEFT JOIN
            form_section fs ON fq.section_id = fs.section_id
        LEFT JOIN
            form_page fp ON fq.page_id = fp.page_id
        WHERE
            fq.form_id = $formID
        ORDER BY
            fp.page_sequence ASC,
            fs.section_order ASC,
            fq.question_order ASC;";

$sectionQuery = "SELECT
                    fs.section_id,
                    fs.section_name,
                    fs.section_order,
                    fs.page_id
                FROM
                    form_section fs
                WHERE
                    fs.form_id = $formID
                ORDER BY
                    fs.page_id ASC,
                    fs.section_order ASC;";

// Initialize result arrays
$formData = [];
$formData['form_pages'] = [];
$formData['form_questions'] = [];
$formData['form_sections'] = [];

// Execute queries
$pageResult = mysqli_query($conn, $pageQuery);
$sqlResult = mysqli_query($conn, $sql);
$sectionResult = mysqli_query($conn, $sectionQuery);

// Fetch and organize data
while ($pageRow = mysqli_fetch_assoc($pageResult)) {
    $formData['form_pages'][] = [
        'page_id' => $pageRow['page_id'],
        'page_sequence' => $pageRow['page_sequence'],
    ];
}

while ($row = mysqli_fetch_assoc($sqlResult)) {
    $formData['form_name'] = $row['form_name'];
    $formData['form_description'] = $row['form_description'];
    $formData['form_type'] = $row['form_type'];
    $formData['start_date'] = $row['start_date'];
    $formData['end_date'] = $row['end_date'];
    $formData['is_open'] = $row['is_open'];

    $formData['form_questions'][] = [
        'question_id' => $row['question_id'],
        'question_text' => $row['question_text'],
        'question_type' => $row['question_type'],
        'options' => json_decode($row['options'], true),
        'question_order' => $row['question_order'],
        'form_id' => $row['form_question_form_id'],
        'section_id' => $row['section_id'],
        'page_id' => $row['page_id'],
    ];
}

while ($sectionRow = mysqli_fetch_assoc($sectionResult)) {
    $formData['form_sections'][] = [
        'section_id' => $sectionRow['section_id'],
        'section_name' => $sectionRow['section_name'],
        'section_order' => $sectionRow['section_order'],
        'page_id' => $sectionRow['page_id'],
    ];
}

// Convert the data to JSON
$jsonData = json_encode($formData, JSON_PRETTY_PRINT);

// Output the JSON object
echo $jsonData;

// Close the database connection
mysqli_close($conn);
}
function updateForm($formData)
{
    $conn = connection();
    $sectionID = null;
    $section_count = 0;
    $page_count = 0;

    $formID = $formData['formid'];


    print_r($formData);
    foreach ($formData['data'] as $item) {


        if ($item['type'] === 'form-title') {
            $formTitle = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';

            $sql = "UPDATE form SET `form_name` = '$formTitle' WHERE `form_id` = $formID";

            if (!$conn->query($sql)) {
                echo "Error updating form title: " . $conn->error;
            }
            // echo $sql;
        } else if ($item['type'] === 'page') {
            $pageID = isset($item['page']) ? mysqli_real_escape_string($conn, $item['page']) : '';
            $page_count++;
            // Check if the section already exists in the database
            $pageExistsQuery = "SELECT * FROM form_page WHERE `page_id` = " . $pageID;

            $pageExistsResult = $conn->query($pageExistsQuery);

            $pageIDRow = $pageExistsResult->fetch_assoc();
            $currentNumRows = $pageExistsResult->num_rows;
            if ($currentNumRows > 0) {
                // Page already exists, update its sequence
                $updatePageSql = "UPDATE form_page SET `page_sequence` = $page_count WHERE `page_id` = $pageID";
                if ($conn->query($updatePageSql) === TRUE) {
                    // handle success
                } else {
                    echo "Error updating page: " . $conn->error;
                }

                // Retrieve the existing page_id
                $pageID = $pageIDRow['page_id'];
            } else {

                $insertPageSql = "INSERT INTO form_page (`form_id`, `page_sequence`) VALUES
                ($formID, $page_count)";

                if ($conn->query($insertPageSql) === TRUE) {
                    $pageID = $conn->insert_id; // Retrieve the inserted page_id
                } else {
                    echo "Error inserting page: " . $conn->error;
                }
            }
        } else if ($item['type'] === 'section') {
            $sectionName = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $sectionID = isset($item['questionID']) ? $item['questionID'] : ''; // No need to escape integer
            $section_count++;
            // Check if the section already exists in the database
            $sectionExistsQuery = "SELECT section_id FROM form_section WHERE `section_id` = " . $sectionID;

            $sectionExistsResult = $conn->query($sectionExistsQuery);

            $sectionIDRow = $sectionExistsResult->fetch_assoc();
            // $currentSectionRow = $sectionExistsResult -> num_rows;
            if ($sectionExistsResult->num_rows > 0) {
                // Section already exists, update its name
                $updateSectionSql = "UPDATE form_section SET `section_name` = '$sectionName',  `page_id` = $pageID,
                `section_order` = $section_count WHERE `section_id` = " . $sectionID;
                if ($conn->query($updateSectionSql) === TRUE) {
                    // Section updated successfully
                } else {
                    echo "Error updating section: " . $conn->error;
                }

                // Retrieve the existing section_id
                $sectionID = $sectionIDRow['section_id'];
            } else {
                // Section doesn't exist, insert a new section
                // $sect/ion_count++;

                $insertSectionSql = "INSERT INTO form_section (`form_id`, `section_name`, `section_order`, `page_id`) VALUES
                ('$formID', '$sectionName', $section_count, $pageID)";

                if ($conn->query($insertSectionSql) === TRUE) {
                    $sectionID = $conn->insert_id; // Retrieve the inserted section_id
                } else {
                    echo "Error inserting section: " . $conn->error;
                }
            }
        } else {
            $question = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $questionType = isset($item['type']) ? mysqli_real_escape_string($conn, $item['type']) : '';
            $options = isset($item['options']) ? json_encode($item['options']) : null;
            $questionOrder = isset($item['order']) ? $item['order'] : 0;


            $insertQuestionSql = "INSERT INTO form_question (`section_id`, `question_text`, `question_type`, `options`, `question_order`, `form_id`, `page_id`)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

            $updateQuestionSql = "UPDATE form_question 
            SET `question_text` = ?, `question_type` = ?, `options` = ?, `question_order` = ?, `form_id` = ?, `section_id` = ?, `page_id` = ?
            WHERE `question_id` = ?";

            // Check if the question exists in the database
            $questionExistsQuery = "SELECT question_id FROM form_question WHERE question_id = " . $item['questionID'];
            $questionExistsResult = $conn->query($questionExistsQuery);

            if ($questionExistsResult->num_rows > 0) {

                $stmt = $conn->prepare($updateQuestionSql);
                $stmt->bind_param("sssiiiii", $question, $questionType, $options, $questionOrder, $formID, $sectionID, $pageID, $item['questionID']);
            } else {
                // Question doesn't exist, insert it
                $stmt = $conn->prepare($insertQuestionSql);
                $stmt->bind_param("isssiii", $sectionID, $question, $questionType, $options, $questionOrder, $formID, $pageID);
            }

            if ($stmt->execute()) {
                // echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

    }

    $conn->close();
}

function getRoles()
{
    $conn = connection();

    $sql = "SELECT DISTINCT `role` FROM users";

    $result = $conn->query($sql);

    $roles = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row['role'];
        }
        return $roles;
    }

    $conn->close();

    return $roles;
}

function getForms()
{
    $conn = connection();

    $sql = "SELECT `form_id`, `form_name` FROM form";

    $result = $conn->query($sql);

    $forms = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $forms[$row['form_id']] = $row['form_name'];
        }
        return $forms;
    }
    $conn->close();
}

function updatePermission($permissionData)
{
    $conn = connection();
    $formID = $permissionData['formID'];
    $canAccess = $permissionData['can_access'] ? 1 : 0;
    $canModify = $permissionData['can_modify'] ? 1 : 0;
    $respondents = $permissionData['respondents'];

    foreach ($respondents as $respondent) {
        $sql = "SELECT * FROM form_permission WHERE form_id = $formID AND `role` = '$respondent'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Role already has permission entry, so update it
            if($canAccess === 0 && $canModify === 0 ){
                //if access is removed for both, delete from permission table
                $deletePermissionSQL = "DELETE FROM form_permission WHERE form_id = $formID AND `role` = '$respondent'";
                if ($conn->query($deletePermissionSQL) !== TRUE) {
                    echo "Error deleting permission: " . $conn->error;
                }
            }else{
                $updatePermissionSQL = "UPDATE form_permission SET can_access = $canAccess, can_modify = $canModify WHERE form_id = $formID AND `role` = '$respondent'";
                if ($conn->query($updatePermissionSQL) !== TRUE) {
                    echo "Error updating permission: " . $conn->error;
                }
            }

        } 
        else {
            // Role doesn't have permission entry, so insert a new one
            $insertPermissionSQL = "INSERT INTO form_permission (form_id, can_access, can_modify, `role`) VALUES ($formID, $canAccess, $canModify, '$respondent')";
            if ($conn->query($insertPermissionSQL) !== TRUE) {
                echo "Error inserting permission: " . $conn->error;
            }
        }
    }

    // Close the connection
    $conn->close();
}

function formContent($formId, $form, $formMode = 'view')
{
    $formName = $form->getFormName($formId);
    ?>

    <header class="form-response-body">
        <h4 class="form-response-body text-center" id="form-response-name">
            <?php
            if (isset($formName)) {
                echo $formName;
            }
            ?>
        </h4>
    </header>

    <main class='form-response-body'>
        <?php 
        $form->loadFormData($formId); 
        
        if($formMode === 'evaluate'){
            echo '<button id="response-submit" class="rounded">Submit</button>';
        }
        ?>
    </main>

    <?php
}

function studentData(){
    $conn = connection();

    $sql = "SELECT s.user_id, s.student_id, s.year_level, s.course, s.section, u.firstname, u.lastname 
    FROM 
    student s 
    LEFT JOIN
    users u on u.user_id = s.user_id";

    $result = $conn->query($sql);
    return $result;

}
function facultyData(){
    $conn = connection();

    $sql = "SELECT f.faculty_id, f.user_id, f.employment_status, u.email, u.firstname, u.lastname 
    FROM 
    faculty f
    LEFT JOIN
    users u on u.user_id = f.user_id";

    $result = $conn->query($sql);
    return $result;

}

function userData($userID='null'){
    $conn = connection();
    if($userID === 'null'){
        $sql = "SELECT * FROM users";
    }else{
        $sql = "SELECT * FROM users WHERE `user_id` = $userID";
    }

    $result = $conn->query($sql);

    return $result;

}

function userAddUpdate($request){
    // print_r($request);
    $conn = connection();
    $username = $request['username'];
    $firstname = $request['firstname'];
    $lastname = $request['lastname'];
    $email = $request['email'];
    $phone = $request['phone'];
    $pass = $request['password'];
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $role = $request['role'];
    if(isset($request['userID'])){
        $userID = $request['userID'];
    }
    $action = $request['submit'];

    if($action === 'insert user'){

        $sql = "INSERT INTO users (`username`, `password`, `firstname`, `lastname`, `email`, `phone`, `role`)
        VALUES 
        ('$username', '$hashed_password', '$firstname', '$lastname', '$email', $phone, '$role')";
    }else{
        $sql = "UPDATE FROM users SET `username` = '$username', `password` = '$hashed_password', `firstname` = '$firstname',
        `lastname` = $lastname, `email` = '$email', `phone` = '$phone' WHERE `user_id` = $userID";
    }
    $result = $conn->query($sql);


}

function updateSchedule($formData)
{
    print_r($formData);
    $conn = connection();
    $startDate = $formData['startDate'];
    $endDate = $formData['endDate'];

    // Set `is_open` to 0 for all rows in the `form` table
    $sql = "UPDATE form SET `is_open` = 0, `start_date` = null, `end_date` = null";

    if (!$conn->query($sql)) {
        die('Error updating schedule: ' . $conn->error);
    }

    // Loop through the form IDs in $formData and set `is_open` to 1 for each one
    foreach ($formData['formIDs'] as $formID) {
        // Use prepared statements to safely insert dates
        $stmt = $conn->prepare("UPDATE form SET `is_open` = 1, `start_date` = ?, `end_date` = ? WHERE form_id = ?");
        $stmt->bind_param("ssi", $startDate, $endDate, $formID);

        if (!$stmt->execute()) {
            die('Error updating schedule: ' . $stmt->error);
        }

        $stmt->close();
    }

    // Close the database connection
    $conn->close();
 
}

function formSchedules(){
    $conn = connection();

    $sql = "SELECT `form_name`, `start_date`, `end_date` FROM form";

    $result = $conn->query($sql);

    return $result;
}

function certificateAddUpdate($request){
    $conn = connection();

    $action = $request['submit'];
    $id = $request['userID'];
    $title = $request['title'];
    $name = $request['name'];
    $provider = $request['provider'];
    $date = $request['dateCertified'];
    $fileName = basename($_FILES["image"]["name"]); 
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
        
    // Allow certain file formats 
    $allowTypes = array('jpg','png','jpeg','gif'); 
    if(in_array($fileType, $allowTypes)){ 
        $image = $_FILES['image']['tmp_name']; 
        $imgContent = addslashes(file_get_contents($image));
    }


    if($action === 'upload certificate'){
        $sql = "INSERT INTO `certificate` (`title`, `name`, `issued_date`, `issued_by`, `image`, `user_id`)
        VALUES ('$title', '$name', '$date', '$provider', '$imgContent', $id)";
    }else{
        $certid = $request['certID'];
        if(!empty($_FILES['image']['tmp_name'])){
            $sql = "UPDATE `certificate` SET `title` = '$title', `name` = '$name', `issued_date` = '$date', `issued_by` = '$provider', `image` = '$imgContent' WHERE `certificate_id` = $certid";
        }else{
            $sql = "UPDATE `certificate` SET `title` = '$title', `name` = '$name', `issued_date` = '$date', `issued_by` = '$provider' WHERE `certificate_id` = $certid";
        }
    }
    
    if(!$conn->query($sql)){
        die('error uploading certificate ' . $conn->error);
    }
}

function certificateData($userID){
    $conn = connection();

    $sql = "SELECT * FROM `certificate` where user_id = $userID
    ORDER BY `certificate_id` DESC";

    if($result = $conn->query($sql)){
        return $result;
    }
}

function deleteCertificate($request){
    $conn = connection();

    $id = $request['certificateID'];

    $sql = "DELETE FROM `certificate` where `certificate_id` = $id";
    echo $sql;

    $result = $conn->query($sql);

    if(!$result){
        die('Error deleting certificate' . $conn->error);
    }else{
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
        exit;
    }
}

function getCertificate($id){
    $conn = connection();

    $sql = "SELECT * FROM `certificate` where `certificate_id` = $id";

    $result = $conn->query($sql);

    return $result;
}

function submissionMetric(){
    $conn = connection();

    $sql = "SELECT COUNT(*) as count FROM `evaluation`";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    return $row['count'];
}

function formCount(){
    $conn = connection();

    $sql = "SELECT COUNT(*) as count FROM `form`";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    return $row['count'];
}
function getScaleOverall() {
    $conn = connection();

    $sql = "SELECT * FROM `form_response` WHERE `response_type` = 'scale'";
    $result = $conn->query($sql);

    $totalScore = 0;
    $totalResponses = 0;

    while($row = $result->fetch_assoc()) {
        // get all the scale responses from the json "value" key
        $scaleResponses = json_decode($row['response_value'], true)['value'];
        // print_r($scaleResponses);
        //iterate through the nested json array
        foreach($scaleResponses as $scaleResponse) {
            foreach($scaleResponse as $key => $value){
                $totalScore += $value;
                $totalResponses++;
            }
        }
    }

    $averageScore = $totalScore / $totalResponses;
    $averageScore = round($averageScore, 2);
    return $averageScore;
}


function computeForm($formID, $percentage){
    $conn = connection();

    $sql = "SELECT * FROM `form_response` WHERE `response_type` = 'scale' and `form_id` = $formID";
    $result = $conn->query($sql);

    $totalScore = 0;
    $totalResponses = 0;

    while($row = $result->fetch_assoc()) {
        // get all the scale responses from the json "value" key
        $scaleResponses = json_decode($row['response_value'], true)['value'];
        // print_r($scaleResponses);
        //iterate through the nested json array
        foreach($scaleResponses as $scaleResponse) {
            foreach($scaleResponse as $key => $value){
                $totalScore += $value;
                $totalResponses++;
            }
        }
    }

    $averageScore = $totalScore / $totalResponses;
    $averageScore = round($averageScore, 2);
    
    $percentageResult = ($averageScore / 100) * $percentage;

    // Assuming you want to return the percentage result
    return $percentageResult;

}

function userTypes(){
    $conn = connection();
    // create an sql query that will select distinct user roles from user table
    //if user is admin, return the admin_level from admin table based on user_id from usertable
    //else return just the role from user table
    $sql = "SELECT DISTINCT
            CASE 
                WHEN u.role IN ('faculty', 'admin') AND a.user_id IS NOT NULL THEN CONCAT(a.admin_level)
                ELSE u.role
                END AS formatted_user_type,
                u.role AS original_user_role
            FROM users u
            LEFT JOIN admin a ON u.user_id = a.user_id";
    
    $result = $conn->query($sql);
    
}


?>