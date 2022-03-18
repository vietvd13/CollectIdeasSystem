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

  public function __construct($idea_id, $total_likes)
  {
      $this->idea_id = $idea_id;
      $this->total_likes = $total_likes;
  }

  public function broadcastOn()
  {
      return ['collect_idea'];
  }

  public function broadcastAs()
  {
      return 'idea-like';
  }
}
