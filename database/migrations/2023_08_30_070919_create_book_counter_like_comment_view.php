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
        CREATE OR REPLACE VIEW book_counter_like_comment AS
        SELECT
            COUNT(DISTINCT book_like_comment.like_id) AS numlikecomment,
            book_comment.comment_id AS comment_id,
            book_comment.book_id AS book_id,
            book_like_comment.status AS status
        FROM
            book_comment
            LEFT JOIN book_like_comment ON book_comment.comment_id = book_like_comment.comment_id
        WHERE
            book_like_comment.status = '1'
        GROUP BY
            book_comment.book_id,
            book_like_comment.status,
            book_comment.comment_id
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_counter_like_comment_view');
    }
};
