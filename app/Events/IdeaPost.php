<?php
namespace App\Events;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class IdeaPost implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $idea_id;
  public $contents;
  public $owner;
  public function __construct($idea_id, $contents, $owner)
  {
      $this->idea_id = $idea_id;
      $this->contents = $contents;
      $this->owner = $owner;
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
