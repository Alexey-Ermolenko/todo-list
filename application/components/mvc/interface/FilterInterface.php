<?php

namespace application\components\mvc\interface;

/**
 * Интерфейс для реализации статусов записей.
 * Реализация getStatusAsText и getStatusList присутствует в DefaultStatusConstantMessages trait
 *
 * Interface FilterInterface
 * @package common\components\helpers
 */
interface FilterInterface
{
    public function setFilters();
}
