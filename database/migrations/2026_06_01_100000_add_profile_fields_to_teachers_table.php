<?php

use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->string('education')->nullable()->after('subject');
            $table->string('motto', 500)->nullable()->after('bio');
        });

        foreach (Teacher::withoutGlobalScopes()->get() as $teacher) {
            $base = Str::slug($teacher->name) ?: 'guru-'.$teacher->id;
            $slug = $base;
            $i = 1;
            while (Teacher::where('slug', $slug)->where('id', '!=', $teacher->id)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $teacher->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['slug', 'education', 'motto']);
        });
    }
};
