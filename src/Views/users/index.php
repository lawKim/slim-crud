<!DOCTYPE html>
<html>
<head><title>User List</title></head>
<body>
    <h1>Users</h1>
    
    <?php if (!empty($formResponse)): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?php
            switch ($formResponse) {
                case 'delete_failed':
                    echo 'Failed to delete user.';
                    break;
                case 'user_not_found':
                    echo 'User not found.';
                    break;
                default:
                    echo 'An error occurred.';
            }
            ?>
        </div>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr> 
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= htmlspecialchars($user->name) ?></td>
            <td><?= htmlspecialchars($user->email) ?></td>
            <td>
                <a href="/slim/users/<?= $user->id ?>/edit">Edit</a> 
                <form action="/slim/users/<?= $user->id ?>/delete" method="POST" style="display: inline;" enctype="multipart/form-data"> 
                      <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form> 
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="/slim/users/create">Add New User</a>
</body>
</html>