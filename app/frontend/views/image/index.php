<?php if (!$isError): ?>
    <div id="image-container">
        <img src="data:image;base64,<?= $image; ?>">
        <div class="actions">
            <a href="#" data-id="<?= $id; ?>" data-path="<?= $path; ?>" class="btn btn-danger action-button" id="decline-button">Decline</a>
            <a href="#" data-id="<?= $id; ?>" data-path="<?= $path; ?>" class="btn btn-success action-button" id="accept-button">Accept</a>
        </div>
    </div>
<?php else: ?>
    <?php if ($errorMessage): ?>
        <p class="alert alert-danger">
            <?= $errorMessage; ?>
        </p>
    <?php else: ?>
    <p class="alert alert-danger">
        An error occurred, the image could not be loaded!<br>
        Please give form to the page update!
    </p>
    <?php endif; ?>
<?php endif; ?>