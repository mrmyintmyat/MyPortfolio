<?php
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

WebSocketsRouter::webSocket('/comments', \App\WebSocket\CommentHandler::class);
