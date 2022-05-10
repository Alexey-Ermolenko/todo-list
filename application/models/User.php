<?php
namespace Application\Models;

use Application\components\DB\Database;
use Application\components\mvc\Model\Model;
use Controller;

class User extends Model {

    private ?array $loginParams = null;

    private int $id;
    private string $name;
    private string $pass;
    private bool $is_admin;

    /**
     * @param array|null $loginParams
     */
    public function __construct(array $loginParams = null) {
        if (!is_null($loginParams)) {
            $this->setLoginParams($loginParams);
        }
    }

    /**
     * @return bool
     */
    public function toLogin(): bool
    {
        $sql = "SELECT u.id, u.name, u.pass, u.is_admin FROM user u WHERE name = :name and pass = :pass";
        $params['name'] = $this->getLoginParams()['name'];
        $params['pass'] = md5($this->getLoginParams()['pass']);

        if ($_SESSION['user'] = (new Database())->queryValue($sql, $params)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function toLogout(): bool
    {
        if (Controller::isAuth() === true) {
            unset($_SESSION['user']);
            session_destroy();

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        if ($_SESSION['user'] && $_SESSION['user']['is_admin'] === true) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getLoginParams(): array
    {
        return $this->loginParams;
    }

    /**
     * @param array $loginParams
     */
    public function setLoginParams(array $loginParams): void
    {
        $this->loginParams = $loginParams;
    }

    /**
     * @param $id
     * @return User
     */
    public static function findOne($id): User
    {
        $sql = "SELECT u.id, u.name, u.pass, u.is_admin FROM user u WHERE id = :id";
        $result = (new Database())->queryValue($sql, ['id' => (int) $id]);

        $user = new self();
        $user->id = $result['id'];
        $user->name = $result['name'];
        $user->pass = $result['pass'];
        $user->is_admin = $result['is_admin'];

        return $user;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * @param bool $is_admin
     */
    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
    }
}
