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
     CREATE OR REPLACE VIEW blog_counter_like_comment AS
     SELECT COUNT(DISTINCT blog_like_comment.like_id) AS numlikecomment,
         blog_comment.comment_id AS comment_id,
         blog_comment.blog_id AS blog_id,
         blog_comment.status AS status
     FROM blog_comment
     LEFT JOIN blog_like_comment ON blog_comment.comment_id = blog_like_comment.comment_id
     WHERE blog_comment.status = '1'
     GROUP BY blog_comment.comment_id, blog_comment.blog_id, blog_comment.status
 ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_counter_like_comment_view');
    }
};
