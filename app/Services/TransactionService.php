<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;
use Illuminate\Support\Facades\DB;
class TransactionService
{

    protected $repository;

    public static function transaction($callback) {
        $status = DB::transaction(function () use ($callback){
            try {
                call_user_func($callback);
                DB::commit();
                return true;
            } catch (\Throwable $th) {
                DB::rollBack();
                return $th;
            }
        });
        error_log($status);
        return $status;
    }
}
