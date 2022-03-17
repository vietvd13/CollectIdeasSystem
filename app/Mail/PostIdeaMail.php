<?php

namespace App\Mail;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;
use App\Models\User;
class PostIdeaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $attributes;
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->attributes['owner']);
        $category = Category::find($this->attributes['category_id']);
        return $this->from(env('MAIL_FROM_ADDRESS'), "New Idea From {$user->name}")->view('email.postemail', [
            "topic_name" => $category->topic_name,
            "owner_name" => $user->name,
            "department" => $user->department->name,
            "attributes" => $this->attributes
        ])->subject($category->topic_name);
    }
}
