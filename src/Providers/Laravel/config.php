<?php
declare(strict_types=1);

return [
    /**
     * Provide a default pre-defined location ID.
     *
     * By doing this, you can skip passing an ID
     * along to most of the methods which requires one.
     */
    'defaultLocationId' => null,

    /**
     * Change the underlying HTTP client.
     */
    'client' => null,
];