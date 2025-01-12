<h1>Hello <?= $user_name ?></h1>


<h3>Delete user</h3>
<form action="/users/<?= $user_id ?>" method="post">
    <input type="hidden" name="_method" value="delete">
    <button>Submit</button>
</form>