<?php

declare(strict_types=1);

namespace Lockerace\WaBot\Models;

use JsonSerializable;

class WaBotSentResult implements JsonSerializable
{
    public readonly string $id;
    public readonly int $messageTimestamp;
    public readonly int $status;

    public function __construct(?array $data)
    {
        if (!empty($data)) {
            $this->id = $data['id'];
            $this->messageTimestamp = intval($data['messageTimestamp']);
            $this->status = intval($data['status']);
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'messageTimestamp' => $this->messageTimestamp,
            'status' => $this->status,
        ];
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
