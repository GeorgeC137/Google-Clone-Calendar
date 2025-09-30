<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar</title>

    <meta name="description" content="Google Calendar">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Google Calendar Clone 📆</h1>
    </header>

    <!-- Clock -->
    <div class="clock-container">
        <div id="clock">

        </div>
    </div>

    <!-- Calendar -->
    <div class="calendar">
        <div class="nav-btn-container">
            <button class="nav-btn">⏮️</button>
            <h2 class="monthYear" style="margin: 0;"></h2>
            <button class="nav-btn">⏭️</button>
        </div>

        <div class="calendar-grid" id="calendar"></div>
    </div>

    <!-- Modal for Add/Edit/Delete Event -->
    <div class="modal" id="eventModal">
        <div class="modal-content">
            <div class="eventSelectorWrapper">
                <label for="eventSelector">
                    <strong>Select Event:</strong>
                </label>
                <select id="eventSelector">
                    <option disabled selected>Choose Event...</option>
                </select>
            </div>

            <!-- Main Form -->
            <form method="POST" id="eventForm">
                <input type="hidden" id="formAction" name="action" value="add">
                <input type="hidden" name="event_id" id="eventId">

                <label for="courseName">Course Title:</label>
                <input type="text" id="courseName" name="course_name" required>

                <label for="instructorName">Instructor Name:</label>
                <input type="text" id="instructorName" name="instructor_name" required>

                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="start_date" required>

                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="end_date" required>

                <button type="submit">Save</button>
            </form>

            <!-- Delete Form -->
            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="event_id" id="deleteEventId">
                <button type="submit" class="submit_btn">🗑️ Delete</button>
            </form>

            <!-- ❌ Cancel  Modal -->
            <button type="button" class="cancel_btn">❌ Cancel</button>
        </div>
    </div>

    <script src="calendar.js"></script>

</body>

</html>