# wa-bot-php-sdk

## Installation
Add new repository to your `composer.json`

Example:
```
"repositories": [
    {
        "url": "https://github.com/lockerace/wa-bot-php-sdk.git",
        "type": "git"
    }
],
```
And then run `composer require lockerace/wa-bot-sdk`
        
## Usage

Import `use Lockerace\WaBot\Facades\WaBot;` to any code you want

### Add Phone

Run `$qrCode = WaBot::getQRCode();` and display `$qrCode` on your website. And scan the QR Code using your device.
It may return false initially, because the engine still starting up so instead you can do this:
```
$qrCode = WaBot::getQRCode();
sleep(5);
$qrCode = WaBot::getQRCode();
```
### List Phones
Run `$phones = WaBot::getPhones();`

`status`:
- 1: online
- 2: offline

`verbosity`:
- 0: silent
- 1: normal
### List Groups
Run `$groups = WaBot::getGroups($phoneID);`
### Send Text
Run `$messageResult = WaBot::sendText($phoneID, $recipient, $message, $quotedMessageID);`
- `$recipient` format is international phone number without the plus (+) or zero (0) prefix, e.g.: `+1 202 555 0185` become `12025550185`, `+62 812-3456-7890` become `6281234567890`

### Send Document
Run `$messageResult = WaBot::sendDocument($phoneID, $recipient, $contents, $fileName, $quotedMessageID);`
- max size is 2GB
- `$contents` could be string or buffer (e.g.: `$contents = Storage::disk('local')->get($fn);`)
- `$fileName` only the file name without the path (e.g: `document.zip`, `document.pdf`)

### Send Image
Run `$messageResult = WaBot::sendImage($phoneID, $recipient, $contents, $fileName, $quotedMessageID);`
- max size is 16MB
- `$contents` could be string or buffer (e.g.: `$contents = Storage::disk('local')->get($fn);`)
- `$fileName` only the file name without the path (e.g: `photo.jpg`, `photo.png`, `photo.gif`)

## Log Out
To log out, go to your device and tap the Log out button