<?php

declare(strict_types=1);

namespace Ashraf\Crud\Model;

class Status
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**
     * get available statuses.
     *
     * @return []
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled'),
        ];
    }
    public static function getOptionArray()
    {
        return self::getAvailableStatuses();
    }
}
