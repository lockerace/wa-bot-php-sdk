<?php

declare(strict_types=1);

namespace Lockerace\WaBot\Models;

use JsonSerializable;

class WaBotGroup implements JsonSerializable
{
    public readonly string $id;
    public readonly string $name;

    public function __construct(?array $data)
    {
        if (!empty($data)) {
            $this->id = $data['id'];
            $this->name = $data['name'];
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
