<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexForSoftDeleteAndQuantityInStocks extends Migration
{
    public function up()
    {
        // Add index for soft_delete and quantity in stocks
        Schema::table('stocks', function (Blueprint $table) {
            // Single-column indexes
            $table->index('soft_delete', 'idx_soft_delete');
            $table->index('quantity', 'idx_quantity');
            
            // Composite index on soft_delete and quantity
            $table->index(['soft_delete', 'quantity'], 'idx_soft_delete_quantity');
        });
    }

    public function down()
    {
        // Drop the indexes if this migration is rolled back
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropIndex('idx_soft_delete');
            $table->dropIndex('idx_quantity');
            $table->dropIndex('idx_soft_delete_quantity');
        });
    }
}
