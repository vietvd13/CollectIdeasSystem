<?php
namespace App\Events;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaLiked implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $idea_id;
  public $total_likes;
  public $payload;
  public function __construct(array $payload)
  {
    $this->payload = $payload;
    $this->idea_id = $payload['idea_id'];
  }

  public function broadcastOn()
  {
      return ['collect_idea'];
  }

  public function broadcastAs()
  {
      return "idea-like-{$this->idea_id}";
  }
}
