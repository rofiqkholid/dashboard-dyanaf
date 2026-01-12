<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Orders Table Columns:\n";
print_r(Schema::getColumnListing('orders'));

echo "\nTransactions Table Columns:\n";
print_r(Schema::getColumnListing('transactions'));

echo "\nCv_orders Table Columns:\n";
print_r(Schema::getColumnListing('cv_orders'));

$order = DB::table('orders')->first();
echo "\nFirst Order sample:\n";
print_r($order);

$cvOrder = DB::table('cv_orders')->first();
echo "\nFirst CvOrder sample:\n";
print_r($cvOrder);
