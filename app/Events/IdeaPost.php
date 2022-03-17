<?php
namespace App\Events;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class IdeaPost implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $payload;
  public function __construct(array $payload)
  {
      $this->payload = $payload;
  }

  public function broadcastOn()
  {
      return ['collect_idea'];
  }

  public function broadcastAs()
  {
      return 'idea-post';
  }
}
