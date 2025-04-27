<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Grading System</title>
  <style>
    body {
      background: #fbe4ea;
      font-family: Arial, sans-serif;
      color: #5a3e42;
    }

    .container {
      max-width: 500px;
      margin: 40px auto;
      padding: 30px;
      background: #fff0f5;
      border: 2px solid #f2c2d1;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(220, 150, 170, 0.3);
    }

    h1 {
      text-align: center;
      color: #d36c9d;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #f5bfd2;
      border-radius: 8px;
      background: #fff5fa;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #ee9ca7;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #f28ca3;
    }

    .result {
      margin-top: 20px;
      padding: 15px;
      background-color: #ffd6e0;
      border: 1px solid #f8b6c8;
      border-radius: 10px;
      text-align: center;
    }

    .result span {
      color: #c74d83;
      font-size: 24px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Student Grading System</h1>
    <form method="POST">
      <label>Student Name:</label>
      <input type="text" name="student_name" required>

      <?php
      $subjects = ['Math', 'Science', 'English', 'Filipino', 'History'];
      foreach ($subjects as $subject) {
        echo "
          <label>$subject Grade:</label>
          <input type='number' name='grades[]' min='0' max='100' required>
        ";
      }
      ?>
      <button type="submit" name="submit">Calculate Average</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
      $name = htmlspecialchars($_POST['student_name']);
      $grades = $_POST['grades'];
      $sum = array_sum($grades);
      $count = count($grades);
      $average = $count ? round($sum / $count, 2) : 0;

      echo "<div class='result'>";
      echo "<h2>$name's General Average:</h2>";
      echo "<span>$average</span>";
      echo "</div>";
    }
    ?>
  </div>
</body>
</html>
