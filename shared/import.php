<?php
include './connection.php';

require_once '../vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


if (isset($_POST['submit'])) { // Check if the form was submitted
    if ($_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
        // Handle the file upload error here
        echo 'File upload error: ' . $_FILES['excel_file']['error'];

    } else {
        $role = $_POST['role'];
        $uploadedFile = $_FILES['excel_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile);

        try{
            

            if($role === 'student'){
        
                importStudent($spreadsheet);
        
            }else if($role === 'faculty'){
                importFaculty($spreadsheet);

            }
        }catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo 'Error loading Excel file: ' . $e->getMessage();
        }

        
        
    
    }

    
}

function importStudent($worksheet) {
    $conn = connection();
    $sheet = $worksheet->getSheet(0);
    $sheet2 = $worksheet->getSheet(1);
    $defaultPass = 'sanBeda123';
    $hashed_password = password_hash($defaultPass, PASSWORD_DEFAULT);

    $rowcount = $sheet->getHighestRow();
    $rowcount2 = $sheet2->getHighestRow();

    $insertUsersSQL = "";
    $insertStudentSQL = "";

    // Create an associative array to store student data and their courses
    $students = [];

    for ($row = 2; $row <= $rowcount; $row++) { // Start from row 1 to skip headers
        $studentNo = $sheet->getCellByColumnAndRow(1, $row)->getValue();
        $firstname = $sheet->getCellByColumnAndRow(2, $row)->getValue();
        $lastname = $sheet->getCellByColumnAndRow(3, $row)->getValue();
        $middlename = $sheet->getCellByColumnAndRow(4, $row)->getValue();
        $program = $sheet->getCellByColumnAndRow(5, $row)->getValue();
        $yr_level = $sheet->getCellByColumnAndRow(6, $row)->getValue();
        $phone = $sheet->getCellByColumnAndRow(7, $row)->getValue();
        $email = $sheet->getCellByColumnAndRow(8, $row)->getValue();
        $section = $sheet->getCellByColumnAndRow(9, $row)->getValue();
    
        $insertUsersSQL = "INSERT INTO users (`username`, `password`, `firstname`, `lastname`, `email`, `phone`, `role`)
            VALUES ('$studentNo', '$hashed_password', '$firstname', '$lastname', '$email', '$phone', 'student');";
    
        if($conn->query($insertUsersSQL)){
            $userID= $conn->insert_id;
        }

        if (!isset($students[$studentNo])) {
            // Initialize the student data if it doesn't exist
            $students[$studentNo] = [
                'student_id' => $studentNo,
                'year_level' => $yr_level,
                'course' => $program,
                'section' => $section,
                'user_id' => $userID,
                'courses' => [], // Initialize the courses array
            ];
        }

        for ($row2 = 1; $row2 <= $rowcount2; $row2++) { // Start from row 1 to skip headers
            $studentID = $sheet2->getCellByColumnAndRow(1, $row2)->getValue();
            if ($studentNo === $studentID) {
                $course_code = $sheet2->getCellByColumnAndRow(2, $row2)->getValue();
                $course_name = $sheet2->getCellByColumnAndRow(3, $row2)->getValue();
                $sched = $sheet2->getCellByColumnAndRow(5, $row2)->getValue();
                $professor = $sheet2->getCellByColumnAndRow(7, $row2)->getValue();
                $faculty_id = $sheet2->getCellByColumnAndRow(8, $row2)->getValue();

                // Add the course data to the student's courses array
                $students[$studentNo]['courses'][] = [
                    'course_code' => $course_code,
                    'course_name' => $course_name,
                    'professor' => $professor,
                    'faculty_id' => $faculty_id,
                    'schedule' => parseSchedule($sched),
                ];
            }
        }
        
    }

    // Iterate through the students and insert data into the database
    foreach ($students as $studentData) {
        $studentID = $studentData['student_id'];
        $yr_level = $studentData['year_level'];
        $program = $studentData['course'];
        $section = $studentData['section'];
        $userID = $studentData['user_id'];
        $courses = $studentData['courses'];

        $insertStudentSQL .= "INSERT INTO student (`student_id`, `year_level`, `course`, `section`, `data`, `user_id`)
            VALUES ('$studentID', '$yr_level', '$program', '$section', '" . json_encode(['courses' => $courses]) . "', $userID);";
        if(!$conn->query($insertStudentSQL)){
            die('Error importing data ' . $conn->error);
        }else{
            $insertStudentSQL = '';
        }
    }

    $conn->close();
    header('Location: ' . $_SERVER["HTTP_REFERER"] );
    exit;

}


function importFaculty($worksheet) {
    $conn = connection();

    $sheet = $worksheet->getSheet(0);
    $sheet2 = $worksheet->getSheet(1);
    $defaultPass = 'sanBedaFaculty123';
    $hashed_password = password_hash($defaultPass, PASSWORD_DEFAULT);

    $rowcount = $sheet->getHighestRow();
    $rowcount2 = $sheet2->getHighestRow();

    $insertUsersSQL = "";
    $insertFacultySQL = "";

    $faculty = [];

    $department = ""; // Initialize department
    $employment_date = ""; // Initialize employment_date

    for ($row = 2; $row <= $rowcount; $row++) {
        $facultyNo = $sheet->getCellByColumnAndRow(1, $row)->getValue();
        $firstname = $sheet->getCellByColumnAndRow(2, $row)->getValue();
        $secondname = $sheet->getCellByColumnAndRow(3, $row)->getValue();
        $lastname = $sheet->getCellByColumnAndRow(4, $row)->getValue();
        $suffix = $sheet->getCellByColumnAndRow(5, $row)->getValue();
        $phone = $sheet->getCellByColumnAndRow(6, $row)->getValue();
        $email = $sheet->getCellByColumnAndRow(7, $row)->getValue();
        $employment_status = $sheet->getCellByColumnAndRow(8, $row)->getValue();
        $department = $sheet->getCellByColumnAndRow(9, $row)->getValue();
        $employment_date = $sheet->getCellByColumnAndRow(10, $row)->getValue();
        // Prepare the user insertion statement
        $insertUsersSQL = "INSERT INTO users (`username`, `password`, `firstname`, `lastname`, `email`, `phone`, `role`)
            VALUES (?, ?, ?, ?, ?, ?, 'faculty');";

        // Bind parameters and execute the prepared statement
        $stmt = $conn->prepare($insertUsersSQL);
        $stmt->bind_param('ssssss', $facultyNo, $hashed_password, $firstname, $lastname, $email, $phone);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $userID = $conn->insert_id;
        } else {
            die('Error inserting user data: ' . $stmt->error);
        }
        $stmt->close();

        if (!isset($faculty[$facultyNo])) {
            // Initialize the faculty data if it doesn't exist
            $faculty[$facultyNo] = [
                'faculty_id' => $facultyNo,
                'employment_status' => $employment_status,
                'user_id' => $userID,
                'employment_date' => $employment_date,
                'department' => $department,
                'courses' => [],
            ];
        }

        for ($row2 = 1; $row2 <= $rowcount2; $row2++) {
            $facultyID = $sheet2->getCellByColumnAndRow(1, $row2)->getValue();
            if ($facultyNo === $facultyID) {
                $course_code = $sheet2->getCellByColumnAndRow(2, $row2)->getValue();
                $section = $sheet2->getCellByColumnAndRow(3, $row2)->getValue();
                $course_name = $sheet2->getCellByColumnAndRow(4, $row2)->getValue();
                $year_level = $sheet2->getCellByColumnAndRow(5, $row2)->getValue();
                $program = $sheet2->getCellByColumnAndRow(6, $row2)->getValue();
                $units = $sheet2->getCellByColumnAndRow(7, $row2)->getValue();
                $sched = $sheet2->getCellByColumnAndRow(8, $row2)->getValue();
                

                // Add course data to the faculty's courses array
                $faculty[$facultyNo]['courses'][] = [
                    'course_code' => $course_code,
                    'course_name' => $course_name,
                    'program' => $program,
                    'year_level' => $year_level,
                    'section' => $section,
                    'schedule' => parseSchedule($sched),
                    'department' => $department,
                    'employment_date' => $employment_date
                ];
            }
        }
    }

    foreach ($faculty as $facultyData) {
        $facultyID = $facultyData['faculty_id'];
        $employment_status = $facultyData['employment_status'];
        $courses = $facultyData['courses'];
        $userID = $facultyData['user_id'];
        $department = $facultyData['department'];
        $employment_date = $facultyData['employment_date'];
        // $department and $employment_date are already defined

        // Encode JSON data
        $data = json_encode(['courses' => $courses]);

        // Prepare the faculty insertion statement
        $insertFacultySQL = "INSERT INTO faculty (`faculty_id`, `employment_status`, `data`, `user_id`, `department`, `employment_date`)
            VALUES (?, ?, ?, ?, ?, ?);";

        // Bind parameters and execute the prepared statement
        $stmt = $conn->prepare($insertFacultySQL);
        $stmt->bind_param('isssss', $facultyID, $employment_status, $data, $userID, $department, $employment_date);
        $stmt->execute();
        // echo $insertFacultySQL
        if (!$stmt->affected_rows > 0) {
            die('Error inserting faculty data: ' . $stmt->error);
        }
        $stmt->close();
    }

    $conn->close();
    header('Location: ' . $_SERVER["HTTP_REFERER"]);
    exit;
}






function parseSchedule($scheduleString) {
    // Define a mapping of day abbreviations to their full names
    $dayMapping = [
        'M' => 'Monday',
        'T' => 'Tuesday',
        'W' => 'Wednesday',
        'TH' => 'Thursday',
        'F' => 'Friday',
        'S' => 'Saturday'
    ];

    // Initialize the result schedule array
    $schedule = [];

    // Split the schedule string by '-' to separate days and time
    $parts = explode(' ', $scheduleString);

    if (count($parts) === 2) {
        $daysAbbreviations = str_split(trim($parts[0]));
        $timeRange = trim($parts[1]);
        $timeParts = explode(' - ', $timeRange);
        // print_r($timeRange);

        foreach ($daysAbbreviations as $dayAbbreviation) {
            // Convert day abbreviation to full name
            $dayFullName = $dayMapping[$dayAbbreviation] ?? $dayAbbreviation;

            if (count($timeParts) === 2) {
                $startTime = $timeParts[0];
                $endTime = $timeParts[1];
                $schedule[$dayFullName] = $startTime . '-' . $endTime;
            }
            $schedule[$dayFullName] = $timeRange;
        }
    }

    return $schedule;
}








?>