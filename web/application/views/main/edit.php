<?php
/**
 * @var array $task
 * @var array $statusList
 * @var array $userList
 * @var bool $saved
 */

use components\Helper;

?>
<h1>Task</h1>

<?php if (isset($saved) && $saved === true) { ?>
    <div class="alert alert-success" role="alert">Task successfully updated</div>
<?php } ?>

<form name="task" action="/main/edit/<?=$task->getId()?>" method="post">
    <input name="id" type="hidden" value="<?=$task->getId()?>">
    <div class="form-group">
        <label for="formControlInput1">Task name</label>
        <input name="name" type="text" class="form-control" id="formControlInput1" placeholder="enter name" required value="<?=$task->getName()?>">
    </div>
    <div class="form-group">
        <label for="formControlInput2">Email address</label>
        <input name="email" type="email" class="form-control" id="formControlInput2" placeholder="name@example.com" required value="<?=$task->getEmail()?>">
    </div>
    <div class="form-group">
        <label for="formControlSelect1">Select status</label>
        <select name="status" class="form-control" id="formControlSelect1">
            <?php foreach ($statusList as $statusItem) { ?>
                <option id="<?=$statusItem['id']?>" value="<?=$statusItem['id']?>" <?= (int)$statusItem['id'] === $task->getStatus() ? 'selected' : ''?>>
                    <?=$statusItem['name']?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="formControlTextarea">Task text</label>
        <textarea name="text" class="form-control" id="formControlTextarea" rows="3"><?=$task->getText()?></textarea>
    </div>
    <div class="form-group">
        <label for="formControlSelect2">Select username</label>
        <select name="user" class="form-control" id="formControlSelect2">
            <?php foreach ($userList as $userItem) { ?>
                <option id="<?=$userItem['id']?>" value="<?=$userItem['id']?>" <?= (int)$userItem['id'] === $task->user->getId() ? 'selected' : ''?>>
                    <?=$userItem['name']?>
                </option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-2">Save</button>
    <input type="reset" class="btn btn-default" value="Reset">
</form>