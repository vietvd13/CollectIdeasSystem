<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-01
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Models\User;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
          switch (Route::getCurrentRoute()->getActionMethod()){
                case 'update':
                    return $this->getCustomRule();
                case 'store':
                    return $this->getCustomRule();
                default:
                    return [];
          }
    }

     public function getCustomRule(){
        if(Route::getCurrentRoute()->getActionMethod() == 'update'){
            return [

            ];
        }
        if(Route::getCurrentRoute()->getActionMethod() == 'store'){
            return  [
                User::NAME => 'required|string',
                User::EMAIL => 'required|email',
                User::PASSWORD => 'required|unique:users|regex:/(^[a-zA-Z]+[a-zA-Z0-9\\-]*$)/u',
                // User::BIRTH =>  ,
                // User::ROLE
            ];
        }
     }

    public function messages()
    {
        return [
            'required' => ':attribute not null'
        ];
    }
}
