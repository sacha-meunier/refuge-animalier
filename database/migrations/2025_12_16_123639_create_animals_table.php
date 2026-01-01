<?php

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Specie;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', AnimalGender::cases())->nullable();
            $table->dateTime('age')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', AnimalStatus::cases())->default(AnimalStatus::IN_PROGRESS);
            $table->string('pictures')->nullable();
            $table->boolean('published')->nullable();
            $table->dateTime('admission_date')->nullable();
            $table->foreignIdFor(Coat::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Specie::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Breed::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
