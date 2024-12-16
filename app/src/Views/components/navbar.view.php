<nav>
    <a href="/">home</a>
    <?php if($user): ?>
        <? if($user['role'] === 'admin'): ?>
            <a href="/admin">admin</a>
        <? endif ?>
        <a href="/profile">profile</a>
        <a href="/signout">sign out</a>
    <? else:?>
        <a href="/signin">sign in</a>
        <a href="/signup">sign up</a>
    <? endif ?>
</nav>
