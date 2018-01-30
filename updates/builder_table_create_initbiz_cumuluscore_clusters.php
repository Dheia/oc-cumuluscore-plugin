<?php namespace Initbiz\CumulusCore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateInitbizCumuluscoreClusters extends Migration
{
    public function up()
    {
        Schema::create('initbiz_cumuluscore_clusters', function ($table) {
            $table->increments('cluster_id')->unsigned();
            $table->string('full_name');
            $table->string('slug')->unique();
            $table->integer('plan_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initbiz_cumuluscore_clusters');
    }
}
