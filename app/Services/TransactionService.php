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
        $status = DB::transaction(function () use ($callback) {
            try {
                call_user_func($callback);
                DB::commit();
                return [
                    'status' => 200,
                    'message' => SUCCESS_POST_IDEA
                ];
            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'status' => 500,
                    'message' => $th
                ];
            }
        });
        return $status;
    }
}
