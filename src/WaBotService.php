<?php

declare(strict_types=1);

namespace Lockerace\WaBot;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Lockerace\WaBot\Models\WaBotSentResult;
use Throwable;

/**
 * @property-read string $channelName channel name
 */
class WaBotService
{
    protected $_channelName;
    protected $_config;
    protected $_baseUrl;

    public function __construct()
    {
        $configID = config('wabot.default');
        $connections = config('wabot.connections');
        $this->_config = $connections[$configID];
        $prefix = $this->_config['channel_prefix'];
        $authKey = $this->_config['api_key'];
        $this->_channelName = $prefix . '-user-' . $authKey;
        $this->_baseUrl = $this->_config['scheme'] . '://' . $this->_config['host'] . ':' . $this->_config['port'];
    }

    public function __get(string $name)
    {
        switch ($name) {
            case 'channelName':
                return $this->_channelName;
            default:
                return null;
        }
    }

    public function __toString()
    {
        return json_encode([
            'channelName' => $this->_channelName,
        ]);
    }

    protected function getPhoneBaseUrl($phoneID)
    {
        return $this->_baseUrl . '/' . $phoneID;
    }

    protected function request($method, $url, $opt)
    {
        $client = new Client();
        $headers = [
            'X-Api-Key' => $this->_config['api_key'],
        ];
        $opt['headers'] = empty($opt['headers']) ? $headers : array_merge($opt['headers'], $headers);
        try {
            $res = $client->request($method, $url, $opt);
            if ($res->getStatusCode() >= 200 && $res->getStatusCode() <= 299) {
                return [
                    'success' => true,
                    'data' => (string) $res->getBody(),
                ];
            } else {
                return [
                    'success' => false,
                    'data' => (string) $res->getBody(),
                ];
            }
        } catch (Throwable $th) {
            if ($th instanceof ClientException) {
                Log::error($th->getResponse()->getBody());
            } else {
                Log::error($th);
            }
            return [
                'success' => false,
                'data' => '',
            ];
        }
    }

    public function sendText(string $phoneID, string $recipient, string $message, ?array $quoted)
    {
        if (empty($phoneID)) {
            throw new Exception('$phoneID is required');
        }
        if (empty($recipient)) {
            throw new Exception('$recipient is required');
        }
        if (empty($message)) {
            throw new Exception('$message is required');
        }
        $opt = [
            'json' => [
                'to' => $recipient,
                'message' => $message,
                'quoted' => $quoted,
            ]
        ];
        $url = $this->getPhoneBaseUrl($phoneID) . '/send';
        $res = $this->request('POST', $url, $opt);
        if ($res['success']) {
            return new WaBotSentResult(json_decode($res['data'], true));
        } else {
            return false;
        }
    }

    public function sendDocument(string $phoneID, string $recipient, mixed $documentContents, string $documentFileName, ?array $quoted)
    {
        if (empty($phoneID)) {
            throw new Exception('$phoneID is required');
        }
        if (empty($recipient)) {
            throw new Exception('$recipient is required');
        }
        if (empty($documentContents)) {
            throw new Exception('$documentContents is required');
        }
        if (empty($documentFileName)) {
            throw new Exception('$documentFileName is required');
        }
        $opt = [
            'multipart' => [
                [
                    'name' => 'to',
                    'contents' => $recipient,
                ],
                [
                    'name' => 'document',
                    'contents' => $documentContents,
                    'filename' => $documentFileName,
                ],
                [
                    'name' => 'quoted',
                    'contents' => $quoted,
                ]
            ],
        ];
        $url = $this->getPhoneBaseUrl($phoneID) . '/send/document';
        $res = $this->request('POST', $url, $opt);
        if ($res['success']) {
            return new WaBotSentResult(json_decode($res['data'], true));
        } else {
            return false;
        }
    }

    public function sendImage(string $phoneID, string $recipient, mixed $imageContents, string $imageFileName, ?array $quoted)
    {
        if (empty($phoneID)) {
            throw new Exception('$phoneID is required');
        }
        if (empty($recipient)) {
            throw new Exception('$recipient is required');
        }
        if (empty($imageContents)) {
            throw new Exception('$imageContents is required');
        }
        if (empty($imageFileName)) {
            throw new Exception('$imageFileName is required');
        }
        $opt = [
            'multipart' => [
                [
                    'name' => 'to',
                    'contents' => $recipient,
                ],
                [
                    'name' => 'image',
                    'contents' => $imageContents,
                    'filename' => $imageFileName,
                ],
                [
                    'name' => 'quoted',
                    'contents' => $quoted,
                ]
            ],
        ];
        $url = $this->getPhoneBaseUrl($phoneID) . '/send/image';
        $res = $this->request('POST', $url, $opt);
        if ($res['success']) {
            return new WaBotSentResult(json_decode($res['data'], true));
        } else {
            return false;
        }
    }
}
