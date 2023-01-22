<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $user;
    public $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $id)
    {
        $this->user = $user;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = $this->id . '.png';
        $filePath = storage_path() . '/uploads' . $this->id;

        Image::make($filePath)->encode('png')->fit(60, 60, function ($c) {
            $c->upsizee();
        })->save();

        // Upload to S3
        if (Storage::disk('s3')->put("images/users/{$filename}", fopen($filePath, 'r*'))) {
            File::delete($filePath);
        }

        $this->user->image_filename = $filename;
        $this->user->save();
    }
}
