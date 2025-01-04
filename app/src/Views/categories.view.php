<?php

use Entities\Category;

/** @var Category[] $categories */

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Categories</h1>
        </div>
    </div>

    <div class="row">
        <div>
            <table>
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Asset Count</th>
					<th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category->name ?></td>
                        <td><?= $category->description ?></td>
                        <td><?= $category->asset_count ?></td>
						<td>
							<a href="/assets?category_id=<?= $category->id ?>">View</a>
						</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
