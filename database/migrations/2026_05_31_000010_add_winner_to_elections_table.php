<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('elections', function (Blueprint $table) {
            $table->unsignedBigInteger('winner_candidate_id')->nullable()->after('ended_at');
            $table->text('winner_notes')->nullable()->after('winner_candidate_id');

            $table->foreign('winner_candidate_id')->references('candidate_id')->on('candidates')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elections', function (Blueprint $table) {
            $table->dropForeign(['winner_candidate_id']);
            $table->dropColumn(['winner_candidate_id', 'winner_notes']);
        });
    }
};
