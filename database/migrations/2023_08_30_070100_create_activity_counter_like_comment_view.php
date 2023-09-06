<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW activity_counter_like_comment AS
        SELECT COUNT(DISTINCT activity_like_comment.like_id) AS numlikecomment,
            activity_comment.comment_id AS comment_id,
            activity_comment.activity_id AS activity_id,
            activity_comment.status AS status
        FROM activity_comment
        LEFT JOIN activity_like_comment ON activity_comment.comment_id = activity_like_comment.comment_id
        WHERE activity_comment.status = '1'
        GROUP BY activity_comment.comment_id, activity_comment.activity_id, activity_comment.status
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_counter_like_comment_view');
    }
};
