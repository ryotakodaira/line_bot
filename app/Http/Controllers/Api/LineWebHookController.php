<?php
/**
 * Created by PhpStorm.
 * User: RyotaKodaira
 * Date: 2019-03-05
 * Time: 17:40
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Exception;

/**
 * Class LineWebHookController
 * @package App\Http\Controllers\Api
 */
class LineWebHookController extends Controller
{

    /**
     * @param Request $request
     * @throws LINEBot\Exception\InvalidSignatureException
     */
    public function webHook(Request $request)
    {
        // Botの印象情報をENVから受け取る
        $lineAccessToken = config('line.access_token');
        $lineChannelSecret = config('line.channel_secret');

        // 署名をチェックする
        // 署名が正しくなければ不正なアクセスとみなして何も行わない
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);
        if (!SignatureValidator::validateSignature($request->getContent(), $lineChannelSecret, $signature)) {
            return;
        }

        $lineBot = new LINEBot(new CurlHTTPClient ($lineAccessToken), ['channelSecret' => $lineChannelSecret]);

        try {
            // イベントをパースする
            /** @var LINEBot\Event\BaseEvent[]|LINEBot\Event\MessageEvent\TextMessage[] $events */
            $events = $lineBot->parseEventRequest($request->getContent(), $signature);

            foreach ($events as $event) {
                $replyToken = $event->getReplyToken();
                $message = new TextMessageBuilder('送信ありがとうございます！🙇‍♂️');
                $lineBot->replyMessage($replyToken, $message);
            }
        } catch (Exception $e) {
            logger($e->getMessage());
            return;
        }

        return;
    }
}
