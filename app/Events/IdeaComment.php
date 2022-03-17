<?php
namespace App\Events;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaComment implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $idea_id;
  public $comment;
  public $owner;
  public function __construct($idea_id, $comment, $owner)
  {
      $this->idea_id = $idea_id;
      $this->comment = $comment;
      $this->owner = $owner;
  }

  public function broadcastOn()
  {
      return ['collect_idea'];
  }

  public function broadcastAs()
  {
      return 'idea-comment';
  }
}
