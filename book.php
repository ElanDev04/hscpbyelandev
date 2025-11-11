<?php
// Simple booking handler
// Configure your receiving email here:
$recipient = 'hemadyaproduction@gmail.com';

$errors = [];
$success = false;
$uploadedFilePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $event_type = trim($_POST['event_type'] ?? '');
  $event_date = trim($_POST['event_date'] ?? '');
  $venue = trim($_POST['venue'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $notes = trim($_POST['notes'] ?? '');
  $from_email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

  if (!$event_type) $errors[] = 'Event type is required.';
  if (!$event_date) $errors[] = 'Event date is required.';
  if (!$from_email) $errors[] = 'A valid email is required.';

  // handle poster upload (optional)
  if (!empty($_FILES['poster']) && $_FILES['poster']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['poster'];
    if ($f['error'] !== UPLOAD_ERR_OK) {
      $errors[] = 'Error uploading poster.';
    } else {
      $allowed = ['image/png','image/jpeg','image/jpg','image/gif'];
      $type = mime_content_type($f['tmp_name']);
      if (!in_array($type, $allowed)) {
        $errors[] = 'Poster must be an image (jpg, png, gif).';
      } else {
        $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
        $name = 'poster_'.time().'.'.$ext;
        $dest = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $name;
        if (move_uploaded_file($f['tmp_name'], $dest)) {
          $uploadedFilePath = $dest;
        } else {
          $errors[] = 'Failed to save uploaded poster.';
        }
      }
    }
  }

  if (empty($errors)) {
    $subject = "New booking request: $event_type on $event_date";
    $body = "New booking request:\n\n" .
      "Event type: $event_type\n" .
      "Event date: $event_date\n" .
      "Venue: $venue\n" .
      "Client email: " . ($from_email ?: '') . "\n" .
      "Phone: " . ($phone ?: '') . "\n\n" .
      "Notes:\n$notes\n";

    // Simple mail. If you want attachments, a more complete mail library is recommended.
    $headers = "From: " . ($from_email ?: 'noreply@example.com') . "\r\n" .
               "Reply-To: " . ($from_email ?: '') . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // attempt to send and capture result
    $mailSent = mail($recipient, $subject, $body, $headers);

    // Always record the booking locally (CSV) so you have a copy even if mail fails
    $csvPath = __DIR__ . DIRECTORY_SEPARATOR . 'bookings.csv';
    $posterName = $uploadedFilePath ? basename($uploadedFilePath) : '';
    $csvLine = [$event_type, $event_date, $venue, $from_email, $phone, $notes, $posterName, date('c')];
    $fp = @fopen($csvPath, 'a');
    if ($fp) {
      // If file is new or empty, write header row first
      if (!file_exists($csvPath) || filesize($csvPath) === 0) {
        fputcsv($fp, ['Event Type','Event Date','Venue','Client Email','Phone','Notes','Poster Filename','Timestamp']);
      }
      fputcsv($fp, $csvLine);
      fclose($fp);
    }

    // write a short log with mail status for debugging
    $logPath = __DIR__ . DIRECTORY_SEPARATOR . 'bookings.log';
    $logLine = sprintf("[%s] mail=%s recipient=%s subject=%s poster=%s\n", date('c'), $mailSent ? 'OK' : 'FAIL', $recipient, str_replace("\n", ' ', $subject), $posterName);
    file_put_contents($logPath, $logLine, FILE_APPEND | LOCK_EX);

    $success = true;
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Book a session — ELANDEV Photography</title>
    <link rel="stylesheet" href="css/styles.css" />
    <style>
      .form-row{display:flex;gap:12px;flex-wrap:wrap}
      .form-row > *{flex:1 1 240px}
      form{max-width:720px}
      .error{color:#b91c1c}
      .success-modal{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.5)}
      .success-card{background:#fff;padding:28px;border-radius:8px;max-width:420px;text-align:center}
    </style>
  </head>
  <body>
    <div data-include="includes/header.html"></div>

    <main class="container">
      <h1>Book a session</h1>

      <?php if (!empty($errors)): ?>
        <div class="error">
          <ul>
            <?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <div class="form-row">
          <label>
            Event type *<br>
            <input name="event_type" value="<?php echo htmlspecialchars($_POST['event_type'] ?? '') ?>" required>
          </label>
          <label>
            Event date *<br>
            <input type="date" name="event_date" value="<?php echo htmlspecialchars($_POST['event_date'] ?? '') ?>" required>
          </label>
        </div>

        <div class="form-row">
          <label>
            Venue / Location<br>
            <input name="venue" value="<?php echo htmlspecialchars($_POST['venue'] ?? '') ?>">
          </label>
          <label>
            Your email *<br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>" required>
          </label>

        </div>

        <div class="form-row">
          <label>
            Phone number<br>
            <input name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '') ?>">
          </label>
        </div>

        <label>
          Notes / Special requests<br>
          <textarea name="notes"><?php echo htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
        </label>

        <label>
          Event poster (optional, jpg/png/gif)<br>
          <input type="file" name="poster" accept="image/*">
        </label>

        <p><button type="submit" class="btn primary">Submit booking</button></p>
      </form>
    </main>

    <?php if ($success): ?>
      <div class="success-modal" id="successModal">
        <div class="success-card">
          <h3>Booking received</h3>
          <p>Thanks — I will contact you back as soon as possible.</p>
          <p><a href="index.html" class="btn">Return home</a></p>
        </div>
      </div>
    <?php endif; ?>

    <script src="js/includes.js"></script>
  </body>
</html>
