<?= $this -> extend("layouts/default") ?>

<?= $this -> section("title") ?>
<title>Events</title>
<?= $this -> endSection() ?>

<?= $this -> section("content") ?>
<h1>Events</h1>

<ul>
    <?php foreach($events as $event): ?>

        <li>
            <?= $event['id'] ?>
            <?= $event['event_name'] ?>
            <?= $event['description'] ?>
            <?= $event['short_description'] ?>
            <?= $event['description'] ?>
            <?= $event['img_url'] ?>
        </li>

    <?php endforeach; ?>
</ul>
<?= $this -> endSection() ?>
