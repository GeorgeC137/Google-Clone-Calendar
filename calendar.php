<?php

// Database connection 
include 'connection.php';

$errorMsg = "";
$successMsg = "";
$eventsFromDB = []; // Initialize new array to hold events from the database

# Handle Add Appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $course = trim($_POST['course_name'] ?? '');
    $instructor = trim($_POST['instructor_name'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    // Validate input
    if (empty($course) || empty($instructor) || empty($startDate) || empty($endDate)) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?error=1');
        exit;
    } else {
        // Insert appointment into the database
        $stmt = $conn->prepare("INSERT INTO appointments (course_name, instructor_name, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $course, $instructor, $startDate, $endDate);

        $stmt->execute();

        $stmt->close();

        header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1');

        exit;
    }
}

# Handle Edit Appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id = $_POST['event_id'] ?? null;
    $course = trim($_POST['course_name'] ?? '');
    $instructor = trim($_POST['instructor_name'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    // Validate input
    if (empty($id) || empty($course) || empty($instructor) || empty($startDate) || empty($endDate)) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?error=2');
        exit;
    } else {
        // Update appointment in the database
        $stmt = $conn->prepare("UPDATE appointments SET course_name = ?, instructor_name = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $course, $instructor, $startDate, $endDate, $id);

        $stmt->execute();

        $stmt->close();

        header('Location: ' . $_SERVER['PHP_SELF'] . '?success=2');

        exit;
    }
}

# Handle Delete Appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id = $_POST['event_id'] ?? null;

    // Validate input
    if (empty($id)) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?error=3');
        exit;
    } else {
        // Delete appointment from the database
        $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->bind_param("i", $id);

        $stmt->execute();

        $stmt->close();

        header('Location: ' . $_SERVER['PHP_SELF'] . '?success=3');

        exit;
    }
}

# Success & Error Messages
if (isset($_GET['error'])) {
    $errorCode = $_GET['error'];
    switch ($errorCode) {
        case '1':
            $errorMsg = "‼️ All fields are required for adding an event.";
            break;
        case '2':
            $errorMsg = "‼️ All fields are required for editing an event.";
            break;
        case '3':
            $errorMsg = "‼️ Invalid event ID for deletion.";
            break;
        default:
            $errorMsg = "An unknown error occurred.";
    }
} elseif (isset($_GET['success'])) {
    $successCode = $_GET['success'];
    switch ($successCode) {
        case '1':
            $successMsg = "✅ Appointment added successfully.";
            break;
        case '2':
            $successMsg = "✅ Appointment updated successfully.";
            break;
        case '3':
            $successMsg = "🚮 Appointment deleted successfully.";
            break;
        default:
            $successMsg = "";
    }
}

# Fetch All Appointments from Database & Spread over date range
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $startDate = new DateTime($row['start_date']);
        $endDate = new DateTime($row['end_date']);

        while ($startDate <= $endDate) {
            $eventsFromDB[] = [
                'id' => $row['id'],
                'date' => $startDate->format('Y-m-d'),
                'title' => "{$row['course_name']} - {$row['instructor_name']}",
                'start' => $row['start_date'],
                'end' => $row['end_date']
            ];
            $startDate->modify('+1 day');
        }
    }
}

$conn->close();
// Convert PHP array to JSON for JavaScript consumption
$eventsJson = json_encode($eventsFromDB);

?>