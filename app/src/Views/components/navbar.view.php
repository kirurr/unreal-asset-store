<?php /**
       * @var array{ id: int, name: string, email: string } $user
       */ ?>
<nav>
	<ul class="navbar flex justify-center p-4 bg-gray-100 rounded-lg gap-4">
		<li>
			<a href="/">Home</a>
		</li>
		<li class="sublist-wrapper">
			<a href="#"class="sublist-toggle">Assets</a>
			<ul class="sublist">
				<li><a href="/assets">All</a></li>
				<li><a href="/assets/top">Top</a></li>
				<li><a href="/assets/new">New</a></li>
			</ul>
		</li>
		<li class="sublist-wrapper">
			<a href="#"class="sublist-toggle">Categories</a>
			<ul class="sublist">
				<li><a href="/categories">All</a></li>
				<li><a href="/categories/top">Top</a></li>
				<li><a href="/categories/new">New</a></li>
			</ul>
		</li>
    <? if($user): ?>
        <? if($user['role'] === 'admin'): ?>
            <li><a href="/admin">admin</a></li>
        <? endif ?>
        <li><a href="/profile">profile</a></li>
        <li><a href="/signout">sign out</a></li>
    <? else:?>
        <li><a href="/signin">sign in</a></li>
        <li><a href="/signup">sign up</a></li>
    <? endif ?>
	</ul>


</nav>
