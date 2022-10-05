<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ---- models ---
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateChartsTable.
 */
class CreateChartsTable extends XotBaseMigration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table) {
                $table->increments('id');
                $table->nullableMorphs('style');
                $table->string('color')->nullable();
                $table->string('bg_color')->nullable();
                $table->integer('font_family')->nullable();
                $table->integer('font_style')->nullable();
                $table->string('font_size')->nullable();

                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table) {
                if ($this->tableExists('charts') && $this->tableExists('chart_styles')) {
                    $this->tableDrop('charts');
                    $this->rename('chart_styles', 'charts');
                }

                if (! $this->hasColumn('y_grace')) {
                    $table->integer('y_grace')->nullable();
                    $table->boolean('yaxis_hide')->nullable();
                }
                if (! $this->hasColumn('list_color')) {
                    $table->string('list_color')->nullable();
                }
                if (! $this->hasColumn('grace')) {
                    $table->string('grace')->nullable();
                }
                if ($this->hasColumn('grace')) {
                    $table->dropColumn('grace');
                }
                if (! $this->hasColumn('x_label_angle')) {
                    $table->string('x_label_angle')->nullable();
                }

                if ($this->hasColumn('font_family')) {
                    $table->integer('font_family')->nullable()->change();
                }
                if ($this->hasColumn('font_style')) {
                    $table->integer('font_style')->nullable()->change();
                }
                if ($this->hasColumn('font_size')) {
                    $table->integer('font_size')->nullable()->change();
                }
                if (! $this->hasColumn('show_box')) {
                    $table->boolean('show_box')->nullable();
                }
                if (! $this->hasColumn('x_label_margin')) {
                    $table->integer('x_label_margin')->nullable();
                }
                if (! $this->hasColumn('width')) {
                    $table->integer('width')->nullable();
                    $table->integer('height')->nullable();
                }
                // indica il tipo di grafico pie/bar/...
                if (! $this->hasColumn('type')) {
                    $table->string('type')->nullable();
                }
                // spessore delle barre
                if (! $this->hasColumn('plot_perc_width')) {
                    $table->integer('plot_perc_width')->nullable();
                }
                if (! $this->hasColumn('plot_value_show')) {
                    $table->boolean('plot_value_show')->nullable();
                    $table->string('plot_value_format')->nullable();
                    $table->string('plot_value_pos')->nullable();
                }
                if ($this->hasColumn('plot_value_pos')) {
                    $table->boolean('plot_value_pos')->nullable()->change();
                }
                // colore delle percentuali visualizzati nelle barre
                if (! $this->hasColumn('plot_value_color')) {
                    $table->string('plot_value_color')->nullable();
                }
                if (! $this->hasColumn('group_by')) {
                    $table->string('group_by')->nullable();
                }
                if (! $this->hasColumn('sort_by')) {
                    $table->string('sort_by')->nullable();
                }
                if ($this->hasColumn('style_type')) {
                    $table->renameColumn('style_type', 'post_type');
                    $table->renameColumn('style_id', 'post_id');
                }
                if (! $this->hasColumn('lang')) {
                    $table->string('lang')->nullable();
                }
            }
        );
    }
}
