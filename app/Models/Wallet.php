<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;

class Wallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'balance'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return Transaction::query()
            ->where('to', $this->user->id)
            ->orWhere('from', $this->user->id);
    }

    protected function add($amount) {
        $this->balance += $amount;
        $this->save();
    }

    protected function sub($amount) {
        $this->balance -= $amount;
        $this->save();
    }

    public function sendToUser(User $user, $amount) {
        $this->sub($amount);
        $user->wallet->add($amount);
    }

    public function sendToUserWithTransaction(User $user, $amount) {
        $this->sendToUser($user, $amount);

        return Transaction::create([
            'from' => $this->user->id,
            'to' => $user->id,
            'amount' => $amount,
        ]);
    }

    public function setBalance($amount) {
        $this->balance = $amount;
        $this->save();

        return $this;
    }

}
