<?php namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class UserTransformer extends TransformerAbstract
{
    /**
     * @param  User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name' => $user->name
        ];
    }
}
