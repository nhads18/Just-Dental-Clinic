<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class SecureMediaController extends Controller
{
    /**
     * Serve an uploaded valid-ID image (sensitive PII).
     *
     * Only authenticated users may access it; a patient may open only the
     * valid ID attached to one of their own appointments, while an admin may
     * open any. The filename is reduced to its basename to defeat path
     * traversal. This route must NEVER be public.
     */
    public function validId($filename)
    {
        $filename = basename($filename);

        $path = storage_path('app/public/valid_ids/' . $filename);
        if (! is_file($path)) {
            abort(404);
        }

        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        if ($user->usertype !== 'admin') {
            $owns = Appointment::where('user_id', $user->id)
                ->get(['image_path'])
                ->contains(fn ($a) => $a->image_path && basename($a->image_path) === $filename);

            if (! $owns) {
                abort(403);
            }
        }

        return response()->file($path);
    }
}
