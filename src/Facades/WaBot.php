<?php

declare(strict_types=1);

namespace Lockerace\WaBot\Facades;

use Illuminate\Support\Facades\Facade;
use Lockerace\WaBot\Models\WaBotPhone;
use Lockerace\WaBot\Models\WaBotSentResult;

/**
 * @method static string|false getQRCode()
 * @method static WaBotPhone[]|false getPhones()
 * @method static WaBotGroup[]|false getGroups(string $phoneID)
 * @method static WaBotSentResult|false sendText(string $phoneID, string $recipient, string $message, ?array $quoted)
 * @method static WaBotSentResult|false sendDocument(string $phoneID, string $recipient, mixed $documentContents, string $documentFileName, ?array $quoted)
 * @method static WaBotSentResult|false sendImage(string $phoneID, string $recipient, mixed $imageContents, string $imageFileName, ?array $quoted)
 */
class WaBot extends Facade
{
  /**
   * {@inheritDoc}
   */
  protected static function getFacadeAccessor(): string
  {
    return \Lockerace\WaBot\WaBotService::class;
  }
}
