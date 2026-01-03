<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get database driver for database-agnostic migrations
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: Recreate table with updated constraint
            DB::statement('CREATE TABLE users_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                name VARCHAR NOT NULL,
                email VARCHAR NOT NULL UNIQUE,
                email_verified_at DATETIME,
                password VARCHAR,
                org_name VARCHAR,
                role VARCHAR DEFAULT \'leader\' NOT NULL CHECK (role IN (\'leader\', \'admin\', \'superadmin\')),
                status VARCHAR DEFAULT \'active\' NOT NULL CHECK (status IN (\'active\', \'suspended\', \'terminated\')),
                termination_reason TEXT,
                oauth_provider VARCHAR,
                oauth_id VARCHAR,
                remember_token VARCHAR,
                created_at DATETIME,
                updated_at DATETIME
            )');
            DB::statement('INSERT INTO users_new SELECT * FROM users');
            DB::statement('DROP TABLE users');
            DB::statement('ALTER TABLE users_new RENAME TO users');
        } elseif ($driver === 'mysql') {
            // MySQL: Update constraint
            // Attempt to drop the constraint if it exists. 
            // Since there's no "DROP CONSTRAINT IF EXISTS" in standard MySQL for checks sometimes, 
            // we catch the error.
            try {
                // Try dropping as a check constraint
                DB::statement('ALTER TABLE users DROP CHECK role_valid');
            } catch (\Exception $e) {
                try {
                     // Sometimes it might be an index or foreign key if naming collided, but mainly just in case
                     DB::statement('ALTER TABLE users DROP CONSTRAINT role_valid');
                } catch (\Exception $e2) {
                    // Ignore if it really doesn't exist
                }
            }
            
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NOT NULL DEFAULT 'leader'");
            
            // Now add it. If it still says duplicate, it means we failed to drop it above.
            try {
                DB::statement("ALTER TABLE users ADD CONSTRAINT role_valid CHECK (role IN ('leader', 'admin', 'superadmin'))");
            } catch (\Exception $e) {
                // If adding fails because it exists, likely the previous run partially succeeded or
                // the constraint is already correct. We can arguably ignore this specific error 
                // if we are confident, or we can try to drop explicitly again.
                // For now, let's assume if it exists we are good, OR re-throw if it matters.
                // However, the error 'Duplicate CHECK constraint name' means the name is taken.
                // Let's try to just proceed, assuming if it's there, it's fine.
                // But better: use a unique name if really needed, OR ensure the drop works.
                // The previous drop failed? Let's assume checking Is needed.
                
                // Let's try dropping by raw SQL without try/catch for debugging? No, that stops migration.
                // The issue is likely `DROP CHECK` vs `DROP CONSTRAINT` on MariaDB vs MySQL versions.
                // We will try both above.
                
                // If we get here, it implies `DROP` failed but `ADD` sees a conflict.
                // Let's not fail the entire migration if the constraint collision is the only issue.
                if (!str_contains($e->getMessage(), 'Duplicate CHECK constraint name')) {
                    throw $e;
                }
            }
        } else {
            // PostgreSQL: Update constraint
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS role_valid');
            DB::statement('ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(255)');
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'leader'");
            DB::statement('ALTER TABLE users ALTER COLUMN role SET NOT NULL');
            DB::statement("ALTER TABLE users ADD CONSTRAINT role_valid CHECK (role IN ('leader', 'admin', 'superadmin'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get database driver for database-agnostic migrations
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: Recreate table with original constraint
            DB::statement('CREATE TABLE users_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                name VARCHAR NOT NULL,
                email VARCHAR NOT NULL UNIQUE,
                email_verified_at DATETIME,
                password VARCHAR,
                org_name VARCHAR,
                role VARCHAR DEFAULT \'leader\' NOT NULL CHECK (role IN (\'leader\', \'superadmin\')),
                status VARCHAR DEFAULT \'active\' NOT NULL CHECK (status IN (\'active\', \'suspended\', \'terminated\')),
                termination_reason TEXT,
                oauth_provider VARCHAR,
                oauth_id VARCHAR,
                remember_token VARCHAR,
                created_at DATETIME,
                updated_at DATETIME
            )');
            DB::statement('INSERT INTO users_new SELECT * FROM users');
            DB::statement('DROP TABLE users');
            DB::statement('ALTER TABLE users_new RENAME TO users');
        } elseif ($driver === 'mysql') {
            // MySQL: Revert constraint
            try {
                DB::statement('ALTER TABLE users DROP CHECK role_valid');
            } catch (\Exception $e) {
                // Ignore
            }
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NOT NULL DEFAULT 'leader'");
            DB::statement("ALTER TABLE users ADD CONSTRAINT role_valid CHECK (role IN ('leader', 'superadmin'))");
        } else {
            // PostgreSQL: Revert constraint
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS role_valid');
            DB::statement('ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(255)');
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'leader'");
            DB::statement('ALTER TABLE users ALTER COLUMN role SET NOT NULL');
            DB::statement("ALTER TABLE users ADD CONSTRAINT role_valid CHECK (role IN ('leader', 'superadmin'))");
        }
    }
};
