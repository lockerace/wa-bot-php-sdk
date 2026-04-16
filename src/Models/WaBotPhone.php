<?php

declare(strict_types=1);

namespace Lockerace\WaBot\Models;

use JsonSerializable;

class WaBotPhone implements JsonSerializable
{
    public readonly string $id;
    public readonly string $phone;
    public readonly int $status;
    public readonly int $verbosity;

    public function __construct(?array $data)
    {
        if (!empty($data)) {
            $this->id = $data['id'];
            $this->phone = $data['phone'];
            $this->status = intval($data['status']);
            $this->verbosity = intval($data['verbosity']);
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'status' => $this->status,
            'verbosity' => $this->verbosity,
        ];
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
