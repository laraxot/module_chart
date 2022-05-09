<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
//---- models ---
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMixedChartTable.
 */
class CreateMixedChartTable extends XotBaseMigration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //-- CREATE --
        $this->tableCreate(
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        //-- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table) {
                //if (! $this->hasColumn('backtop')) {
                //    $table->string('backtop')->nullable();
                //}
            }
        );
    }
}
