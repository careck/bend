<?php
class MeterChanges extends CmfiveMigration {
    
    public function up() {
        
        // 1. fix the spelling
        $table = $this->table('bend_meter');
        if (!empty($table)) {
            $table->renameColumn('las_reading_value', 'last_reading_value')->update();
        }

        // 2. fix columntypes
        $table = $this->table('bend_meter');
        if (!empty($table)) {
            $table->changeColumn('last_reading_value', 'decimal', ['precision'=>20, 'scale'=>2]);
            $table->changeColumn('start_value', 'decimal', ['precision'=>20, 'scale'=>2]);
            $table->addBooleanColumn('is_active', true, 1);
            $table->update();
        }
        
    }
    
    public function down() {
        $table = $this->table('bend_work_entry');
        if (!empty($table)) {
            $table->renameColumn('last_reading_value', 'las_reading_value')->update();
        }

        $table = $this->table('bend_meter');
        if (!empty($table)) {
            $table->changeColumn('last_reading_value', 'biginteger');
            $table->changeColumn('start_value', 'biginteger');
            $table->removeColumn('is_active');
            $table->update();
        }
 
    }
    
}
