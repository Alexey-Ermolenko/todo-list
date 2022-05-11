<?php
/**
 * @var array $tasks
 * @var string $page
 * @var int $count
 * @var int $limit
 */

$pages = ceil($count / $limit);

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
                <td width="200"><?= (strlen($item->getText()) > 13) ? substr($item->getText(),0,80).'...' : $item->getText(); ?></td>
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

<?php if (ceil($count / $limit) > 0): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="prev"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page - 1) ?>">Prev</a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="start"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page=1' ?>">1</a></li>
                <li class="dots">
                    <a>...</a>
                </li>
            <?php endif; ?>

            <?php if ($page - 2 > 0): ?><li class="page"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page - 2) ?>"><?= $page - 2 ?></a></li><?php endif; ?>
            <?php if ($page - 1 > 0): ?><li class="page"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page - 1) ?>"><?= $page - 1 ?></a></li><?php endif; ?>

            <li class="currentpage">
                <a class="btn btn-primary active" aria-pressed="true" role="button" href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page) ?>"><?= $page ?></a>
            </li>

            <?php if ($page + 1 < ceil($count / $limit) + 1): ?><li class="page"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page + 1) ?>"><?= $page + 1 ?></a></li><?php endif; ?>
            <?php if ($page + 2 < ceil($count / $limit) + 1): ?><li class="page"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page + 2) ?>"><?= $page + 2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($count / $limit)-2): ?>
                <li class="dots">
                    <a>...</a>
                </li>
                <li class="end"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. (ceil($count / $limit)) ?>"><?= ceil($count / $limit) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($count / $limit)): ?>
                <li class="next"><a href="/main/index/?order=<?= $_GET['order'] . '&sort=' . $_GET['sort'] . '&page='. ($page + 1) ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>