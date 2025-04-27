<?php
session_start();

// Initialize session variables if not set
if (!isset($_SESSION['expenses'])) {
    $_SESSION['expenses'] = [];
}
if (!isset($_SESSION['budget'])) {
    $_SESSION['budget'] = 0;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['set_budget'])) {
        $_SESSION['budget'] = floatval($_POST['budget']);
    } elseif (isset($_POST['add_expense'])) {
        $expense = [
            'category' => $_POST['category'],
            'amount' => floatval($_POST['amount']),
            'date' => date('Y-m-d')
        ];
        $_SESSION['expenses'][] = $expense;
    }
}

// Calculate totals
$total_expenses = array_sum(array_column($_SESSION['expenses'], 'amount'));
$remaining_budget = $_SESSION['budget'] - $total_expenses;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My First Budget Tracker</title>
    <style>
        body { 
        font-family: 'Comic Sans MS', cursive, sans-serif; 
        background-color: #f5f5dc; /* Light beige background */
            color: #333; 
            margin: 0; 
            padding: 20px; 
        }
        .container { 
            width: 60%; 
            margin: auto; 
            background-color: #ffffff; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
            border: 2px solid #d2691e; /* Terracotta red border */
        }
        h1 { 
            text-align: center; 
            color: #d2691e; /* Terracotta red */
            font-size: 2.5em; 
            margin-bottom: 20px; 
        }
        h2 { 
            color: #008080; /* Muted teal */
            font-size: 1.8em; 
            margin-top: 20px; 
        }
        form { 
            margin-bottom: 20px; 
            background-color: #f0e68c; /* Light beige form background */
            padding: 20px; 
            border-radius: 10px; 
        }
        input[type="text"], input[type="number"] { 
            width: 97%; 
            padding: 15px; 
            margin: 10px 0; 
            border: 1px solid #d2691e; /* Terracotta red border */
            border-radius: 8px; 
            font-size: 1.2em; 
        }
        input[type="submit"] { 
            padding: 15px; 
            background-color: #008080; /* Muted teal button */
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 1.2em; 
            transition: background-color 0.3s; 
        }
        input[type="submit"]:hover { 
            background-color: #006666; /* Darker teal on hover */
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #d2691e; /* Terracotta red border for table */
            padding: 12px; 
            text-align: left; 
            font-size: 1.2em; 
        }
        th { 
            background-color: #f0e68c; /* Light beige header */
            color: #333; 
        }
        tr:nth-child(even) { 
            background-color: #e0f7fa; /* Light teal for even rows */
        }
        tr:hover { 
            background-color: #b2dfdb; /* Slightly darker teal on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>My Budget Tracker</h1>

    <h2>Set a Budget</h2>
    <form method="POST">
        <input type="number" name="budget" placeholder="Enter your monthly budget" required>
        <input type="submit" name="set_budget" value="Set Budget">
    </form>

    <h2>Track Expenses</h2>
    <form method="POST">
        <input type="text" name="category" placeholder="Expense Category" required>
        <input type="number" name="amount" placeholder="Expense Amount" required>
        <input type="submit" name="add_expense" value="Add Expense">
    </form>

    <h2>Summary</h2>
    <p>Total Budget: ₱<?php echo number_format($_SESSION['budget'], 2); ?></p>
    <p>Total Expenses: ₱<?php echo number_format($total_expenses, 2); ?></p>
    <p>Remaining Budget: ₱<?php echo number_format($remaining_budget, 2); ?></p>

    <h2>Expense List</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Category</th>
            <th>Amount</th>
        </tr>
        <?php foreach ($_SESSION['expenses'] as $expense): ?>
            <tr>
                <td><?php echo $expense['date']; ?></td>
                <td><?php echo htmlspecialchars($expense['category']); ?></td>
                <td>₱<?php echo number_format($expense['amount'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>