<?php

namespace App\Http\Controllers\Front;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BotManController extends Controller
{

    // mỗi lần request - yêu cầu tức là mỗi lần người dùng nhắn đến là 1 lần gửi đến route /botman
    //  là mỗi khi người dùng gõ là laravel khởi động lại toàn bộ ứng dụng để xử lý route đó mặc dù ứng dụng và 
    // cách xử lý đang nhẹ nên em mang nó ra riêng một controller 
    // vậy nên mỗi khi người dùng nhắn đến chatbot thì nó chỉ cần gọi lại controller là được 
    // đảm bảo khi có nhiều khách hàng hỏi đến thì việc phản hồi sẽ bớt chậm hơn 
    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $botman = BotManFactory::create([]);

        $botman->hears('{message}', function (BotMan $bot, $message) {
            Log::channel('chatbot')->info('User said: ' . $message);

            if (preg_match('/mua hàng|đặt hàng|muốn mua/i', $message)) {
                $bot->reply('Dạ vâng 💖! Bạn vui lòng để lại *số điện thoại* để nhân viên bên mình liên hệ nhé.');
            } elseif (preg_match('/\d{9,11}/', $message)) {
                $bot->reply("Cảm ơn bạn ❤️! Bên mình đã nhận được số điện thoại: *$message* 📞");
            } elseif (preg_match('/liên hệ|tư vấn/i', $message)) {
                $bot->reply("Bạn có thể liên hệ qua hotline 📞 *0597 687 959* hoặc Zalo 💬 *https://zalo.me/0123456789*");
            } else {
                $bot->reply("Bạn có muốn mình tư vấn sản phẩm phù hợp không ạ? 💄");
            }
        });

        $botman->listen();
    }
}
