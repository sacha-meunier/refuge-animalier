<?php

use App\Models\Coat;
use App\Models\Note;
use App\Models\Breed;
use App\Models\Specie;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->tinyInteger('age');
            $table->string('description');
            $table->enum('status', ['validated', 'in_progress', 'adopted'])->default('in_progress');
            $table->string('pictures')->nullable();
            $table->boolean('published');
            $table->dateTime('admission_date');
            $table->foreignIdFor(Coat::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Note::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Specie::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Breed::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
