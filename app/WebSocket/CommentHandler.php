<?php

namespace App\WebSocket;

use App\Models\User;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Facades\Log;
use Ratchet\MessageComponentInterface;
use App\Http\Controllers\WebCmNotificationController;

class CommentHandler implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Parse the query string from the connection's URI
        $queryString = parse_url($conn->httpRequest->getRequestTarget(), PHP_URL_QUERY);
        parse_str($queryString, $queryParameters);

        // Get the encrypted post ID from the query parameters
        $encryptedPostId = isset($queryParameters['post_id']) ? $queryParameters['post_id'] : null;

        // Decrypt the post ID
        $decryptedPostId = decrypt($encryptedPostId);

        // Attach the decrypted post ID to the client object
        $conn->postId = $decryptedPostId;
        // Store the new connection
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        $messageData = json_decode($message, true);
        // Check if the message type is 'new_comment' and it has a routeOrPostId
        if (isset($messageData['type']) && isset($messageData['post_id'])) {
            // Get the route or post identifier from the message
            $post_id = decrypt($messageData['post_id']);

            foreach ($this->clients as $client) {
                // Check if the client is interested in the same route or post
                // For example, you might have some logic to match the route or post identifier
                if ($client->resourceId !== $from->resourceId && $client->postId === $post_id) {
                    $client->send($message); // Access 'comment' as array element
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Remove the connection when it's closed
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        // Log any errors that occur
        Log::error("An error occurred on connection {$conn->resourceId}: {$e->getMessage()}");
    }
}
