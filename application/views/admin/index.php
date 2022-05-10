<?php
/**
 * @var array $items
 */
?>
<h1>админка!</h1>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th>#</th>
            <th>name</th>
            <th>text</th>
            <th>email</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td width="30"><?= $item['id'] ?></td>
                <td width="50"><?= $item['name'] ?></td>
                <td width="200"><?= mb_strimwidth($item['text'], 0, 120, "...") ?></td>
                <td width="50"><?= $item['email'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>



