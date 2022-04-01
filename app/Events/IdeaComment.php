<?php
namespace App\Events;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaComment implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $attributes;
  private $idea_id;
  public function __construct(array $attributes)
  {
        $this->attributes = $attributes;
        $this->idea_id = $attributes['idea_id'];
  }

  public function broadcastOn()
  {
      return ['collect_idea'];
  }

  public function broadcastAs()
  {
      return "idea-comment-{$this->idea_id}";
  }
}
