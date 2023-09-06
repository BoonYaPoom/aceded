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
            // คำสั่ง SQL สร้าง View
            DB::statement("
            CREATE OR REPLACE VIEW web_counter_like_comment AS
            SELECT COUNT(DISTINCT web_like_comment.like_id) AS numlikecomment,
                web_comment.comment_id AS comment_id,
                web_comment.web_id AS web_id,
                web_like_comment.status AS status
            FROM web_comment
            LEFT JOIN web_like_comment ON web_comment.comment_id = web_like_comment.comment_id
            WHERE web_like_comment.status = '1'
            GROUP BY web_comment.web_id, web_like_comment.status, web_comment.comment_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_counter_like_comment_view');
    }
};
