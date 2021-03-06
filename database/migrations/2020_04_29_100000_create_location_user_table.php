<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationUserTable extends Migration
{
    public function up()
    {
        Schema::create('location_user', function (Blueprint $table) {
            $table->foreignIdFor(app('location'))->index();
            $table->foreignIdFor(app('user'))->index();
            $table->timestamps();
        });
    }
}
