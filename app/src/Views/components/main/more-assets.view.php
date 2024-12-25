<div>
	<h1>More Assets</h1>
	<ul>
		<li><a href="/?variant=today" >new today</a></li>
		<li><a href="/?variant=week" >new this week</a></li>
		<li><a href="/?variant=month" >new this month</a></li>
		<li><a href="/?variant=popular" >poluar all time</a></li>
	</ul>
	<? foreach ($assets as $asset): ?>
		<p> <?= $asset->name ?> </p>
	<? endforeach; ?>
</div>
