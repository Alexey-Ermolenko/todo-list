<?php
/**
 * @var array $tasks
 * @var string $page
 * @var int $count
 * @var int $limit
 */

$pages = ceil($count / $limit);

$prevlink = ($page > 1) ? '<a href="/main/index/?order=' . $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page - 1) .'" aria-label="Previous"><span aria-hidden="true">Previous</span></a>' : '<span class="disabled">Previous</span>';
$nextlink = ($page < $pages) ? '<a href="/main/index/?order=' . $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page + 1) .'" aria-label="Next"><span aria-hidden="true">Next</span></a>' : '<span class="disabled">Next</span>';

?>
<h1>Task list</h1>
<br/>
<a href="/main/add" class="btn btn-primary active" role="button" aria-pressed="true">Add new task</a>
<br/>
<br/>
<table class="table table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th>
            name
            <a href="/main/index/?order=task_name&sort=asc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
            <a href="/main/index/?order=task_name&sort=desc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
        </th>
        <th>text</th>
        <th>
            email
            <a href="/main/index/?order=email&sort=asc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
            <a href="/main/index/?order=email&sort=desc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
        </th>
        <th>
            Статус
            <a href="/main/index/?order=status_id&sort=asc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
            <a href="/main/index/?order=status_id&sort=desc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
        </th>
        <th>Имя пользователя
            <a href="/main/index/?order=user_name&sort=asc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
            <a href="/main/index/?order=user_name&sort=desc&page=<?=$page?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
        </th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $item) { ?>
            <tr>
                <td width="30"><?= $item->getId() ?></td>
                <td width="150"><?= $item->getName() ?></td>
                <td width="200"><?= mb_strimwidth($item->getText(), 0, 80, "...") ?></td>
                <td width="60"><?= $item->getEmail() ?></td>
                <td width="50"><?= $item->getStatusName() ?></td>
                <td width="50"><?= $item->user->getName() ?></td>
                <td width="30">
                    <a <?= Controller::isAuth()!==true ? 'disabled="disabled"' : ''?> href="/main/edit/<?= $item->getId() ?>" class="btn btn-primary a-btn-slide-text">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        <span><strong>Edit</strong></span>
                    </a>
                </td>
                <td width="30">
                    <a <?= Controller::isAuth()!==true ? 'disabled="disabled"' : ''?> href="/main/del/<?= $item->getId() ?>" class="btn btn-danger a-btn-slide-text">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <span><strong>Delete</strong></span>
                    </a>
                </td>
            </tr>
    <?php } ?>
    </tbody>
</table>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li>
            <?=$prevlink?>
        </li>
        <li>
            <?=$nextlink?>
        </li>
    </ul>
</nav>