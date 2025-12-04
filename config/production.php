<?php

/*
 * Force production database configuration
 * This file ensures MySQL is used in production regardless of environment variables
 */

// Only apply this configuration in production
if (app()->environment('production')) {
    // Force database connection to MySQL
    config(['database.default' => 'mysql']);
    
    // Ensure queue connections also use MySQL
    config(['queue.batching.database' => 'mysql']);
    config(['queue.failed.database' => 'mysql']);
}