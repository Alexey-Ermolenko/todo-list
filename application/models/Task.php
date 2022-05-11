<?php
namespace application\models;

use application\components\DB\Database;
use application\components\mvc\model\Model;

use components\Helper;

class Task extends Model
{
    private $id;
    private int $user_id;
    private string $name;
    private string $email;
    private string $text;
    private int $status;

    public User $user;
    private static ?array $tasks;
    private Task $model;


    /**
     * @param string|null $order
     * @param string|null $dir
     * @param int|null $offset
     * @param int|null $limit
     * @return array|null
     */
    public static function findAll(?string $order = 't.id', ?string $dir = 'ASC', ?int $offset = 1, ?int $limit = 3): ?array
    {
        $param = [
            ':order'  => $order ? trim($order) : 't.id',
            ':dir'    => $dir ? trim($dir) : 'ASC',
            ':offset' => $offset ? trim($offset) : 1,
            ':limit' => $limit ? trim($limit) : 1,
        ];

        $sql = "SELECT t.id,
                       u.id AS user_id,
                       u.name AS user_name,
                       t.name AS task_name,
                       t.email AS task_email,
                       t.text AS task_text,
                       t.status_id
                  FROM task t
                  JOIN user u ON u.id = t.user_id
                 ORDER BY ". $param[':order'] . " ". $param[':dir']. "
                 LIMIT ". $param[':offset'] ." , " .$param[':limit'];

        $result = (new Database())->queryValues($sql);

        foreach ($result as $item) {
            self::$tasks[] = self::getModel($item);;
        }

        return self::$tasks;
    }

    /**
     * @param $id
     * @return Task
     */
    public static function findOne($id): Task
    {
        $model = null;

        $sql = "SELECT t.id,
                       u.id AS user_id,
                       u.name AS user_name,
                       t.name AS task_name,
                       t.email AS task_email,
                       t.text AS task_text,
                       t.status_id
                  FROM task t
                  JOIN user u ON u.id = t.user_id
                 WHERE t.id = :id 
                 LIMIT 1
        ";

        if ($res = (new Database())->queryValue($sql, ['id' => (int)$id])) {
            $model = self::getModel($res);
        }

        return $model;
    }

    public static function count() {
        $sql = 'SELECT count(t.id) as count FROM task t';

        return (int)(new Database())->queryValue($sql)['count'];
    }
    /**
     * @param $res
     * @return Task
     */
    public static function getModel($res): Task
    {
        $model = new self();
        $model->id = $res['id'];
        $model->name = $res['task_name'];
        $model->email = $res['task_email'];
        $model->text = $res['task_text'];
        $model->status = $res['status_id'];

        $model->user = $model->getUser($res['user_id']);
        return $model;
    }

    /**
     * @return array|null
     */
    public static function getStatusList(): ?array
    {
        return (new Database())->queryValues('SELECT s.id, s.name FROM status s');
    }
    /**
     * @return array|null
     */
    public static function getUserList(): ?array
    {
        return (new Database())->queryValues('SELECT u.id, u.name FROM user u');
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function getUser($id): User
    {
        return User::findOne($id);
    }

    /**
     * @param int $id
     */
    public function setUser(int $id): void
    {
        $this->user = User::findOne($id);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusName(): string {
        return (string)(new Database())->queryValue('SELECT name FROM status WHERE id = :id', ['id' => (int)$this->status])['name'];
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


    /**
     * @return bool
     */
    public function save(): bool
    {
        $res = false;
        $fields = [
            'name' => 'name',
            'email' => 'email',
            'text' => 'text',
            'status_id' => 'status_id',
            'user_id' => 'user_id',
        ];

        $params = [
            'name' => $this->name,
            'email' => $this->email,
            'text' => $this->text,
            'status_id' => $this->status,
            'user_id' => $this->user->getId(),
        ];

        $where = 'id = ' . $this->id;

        if ($this->id) {
            $res = (new Database())->update('task', $fields, $where, $params);
        } else {
            $res = (new Database())->insert('task', $params);
        }

        return $res;
    }

    public static function delete($id) {
        if ((new Database())->deleteById('task', $id) === true) {
            Helper::redirect('/main/index');
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
