<!DOCTYPE html>
<html>
<head><title>Edit User</title></head>
<body>
    <h1>Edit User</h1>
    
    <?php if (!empty($formResponse)): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?php 
            switch ($formResponse) {
                case 'invalid_input':
                    echo 'Name and email are required!';
                    break;
                case 'update_failed':
                    echo 'Failed to update user. Please try again.';
                    break;
                case 'update_success':
                    echo 'Data Updated';
                    break;
                default:
                    echo 'An error occurred.';
            }
            ?>
        </div>
    <?php endif; ?>
 
    <form method="POST" action="/slim/users/<?= $user->id ?>/edit">
        <input type="hidden" name="_method" value="PUT"> 
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($user->name) ?>" required><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required><br><br>
        <button type="submit">Update</button>
    </form>
    <br>
    <a href="/slim/users">Back to list</a>
</body>
</html>