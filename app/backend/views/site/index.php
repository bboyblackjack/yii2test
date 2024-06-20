<?php if(!empty($images)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Solution</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($images as $image): ?>
            <tr>
                <td><a href="<?= $image->path ?>"><?= $image->id ?></a></td>
                <td><?= $image->is_accepted ? "<p class='text-success'>Accepted</p>" : "<p class='text-danger'>Declined</p>" ?></td>
                <td><a href="<?= yii\helpers\Url::to(['site/cancel', 'id' => $image->id, 'token' => 'xyz123'])?>" class="btn btn-danger">Cancel</a></td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p class="alert alert-info">No solutions!</p>
<?php endif; ?>
