<!DOCTYPE html>
<html>
<head><title>Add User</title></head>
<body>
    <h1>Add New User</h1>
    
    <!-- Error Messages -->
    <?php if (!empty($formResponse)): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?php
            switch ($formResponse) {
                case 'invalid_input':
                    echo 'Name and email are required!';
                    break;
                case 'database_error':
                    echo 'Failed to save user. Please try again.'; 
                    break;
                default:
                    echo 'An error occurred.';
            }
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/slim/users">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/slim/users">Back to list</a>
</body>
</html>