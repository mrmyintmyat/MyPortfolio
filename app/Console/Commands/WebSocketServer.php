<?php

namespace App\Console\Commands;

use App\WebSocket\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Illuminate\Console\Command;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\CommentHandler;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app-websocket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the WebSocket server';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('WebSocket server started on port 8080');

        // Bootstrap Laravel
        $app = require __DIR__.'/../../../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new CommentHandler()
                )
            ),
            8080
        );
        $server->run();
    }
}
