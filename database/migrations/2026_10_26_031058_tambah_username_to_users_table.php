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
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 50) -> nullable() -> unique() -> after('name');
            });
        }
    

        $dipakai = DB::table('users')
            ->whereNotNull('username')
            ->where('username', '!=', '')
            ->pluck('username')
            ->map(fn ($u) => strtolower($u))
            ->flip()
            ->all();

        $kosong = DB::table('users')
            ->whereNull('username')
            ->orWhere('username', '')
            ->orderBy('id')
            ->get();

        foreach ($kosong as $user) {
            $dasar = strtolower(preg_replace('/[^A-Za-z0-9._-]/', '', Str::before($user->email, '@')));
            $dasar = $dasar !== '' ? substr($dasar, 0, 45) : 'user' . $user->id;

            $nama = $dasar;
            $i = 1;
            while (isset($dipakai[$nama])) {
                $nama = $dasar . $i++;
            }
            $dipakai[$nama] = true;

            DB::table('users')->where('id', $user->id)->update(['username' => $nama]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table -> dropUnique(['username']);
                $table -> dropColumn('username');
            });    
        }
    }
};
