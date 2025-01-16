<?php

/** @var string $selector */
?>
<script src="/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
	selector: '<?= $selector ?? '' ?>',
	license_key: 'gpl',
	plugins: 'image code lists link autoresize',
	menubar: 'file edit insert view format table tools help',
	autoresize_bottom_margin: 100,
	toolbar_sticky: true,
	resize: true
});
</script>
