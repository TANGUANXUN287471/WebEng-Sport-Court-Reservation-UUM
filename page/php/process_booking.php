<?php

// Include the database connection file
global $conn;
include 'dbconnect.php'; // Update this with your actual connection file

// Retrieve form data
$booking_date = $_POST['booking-date'];
$booking_time = $_POST['booking-time'];
$sport_type = $_POST['sport-type'];
$court_number = $_POST['court-number'];

// TODO: Authenticate the user and obtain the actual user ID dynamically
$user_id = 7; // Replace this with the actual user ID

// Get courtID based on the selected sport type and court number
$sql_court = "SELECT courtID FROM court WHERE sportName = '$sport_type' AND courtNo = $court_number";
$result_court = $conn->query($sql_court);

if ($result_court->num_rows > 0) {
  $row_court = $result_court->fetch_assoc();
  $court_id = $row_court['courtID'];

  // Get slotID based on the selected start time
  $sql_slot = "SELECT slotID FROM timeslot WHERE startTime = '$booking_time'";
  $result_slot = $conn->query($sql_slot);

  if ($result_slot->num_rows > 0) {
    $row_slot = $result_slot->fetch_assoc();
    $slot_id = $row_slot['slotID'];

    // Insert data into the database
    $sql_booking = "INSERT INTO booking (userID, courtID, slotID, bookDate, createDate, bookingStatus)
                        VALUES ($user_id, $court_id, $slot_id, '$booking_date', NOW(), 'Confirmed')";

    if ($conn->query($sql_booking) === TRUE) {
      echo "Booking successful!";
    } else {
      echo "Error: " . $sql_booking . "<br>" . $conn->error;
    }
  } else {
    echo "Error: Unable to determine slotID.";
  }
} else {
  echo "Error: Unable to determine courtID.";
}

// Close the database connection
$conn->close();
?>
