<?php
namespace App\Business;
use App\Model\UserModel;
use App\System\BusinessException;


class UserBusiness{
    /**
     * Regra de Negocio responsável por buscar um id especifico
     * 
     * @param Object $data
     * @return Object
     */
    public static function fetch($data){
        $list = [];
        //percorro cada model de usuario encontra e defino um template de exibição
        foreach (UserModel::list($data) as $key => $row) {
            $list[] = array(
                'id' => $row->GetId(),
                'nome' => $row->GetNome(),
                'email' => $row->GetEmail(),
                'usuario' => $row->GetUsuario()
            );
        }

        return $list;
    }
    /**
     * Regra de Negocio responsável por buscar um id especifico
     *
     * @param Object $data
     * @return Object
     */
    public static function findById($data){
        //Tento buscar por um id
        $user_model = UserModel::findById($data->id);
        //Se nao foi possivel retorne null
        if(is_null($user_model)) return null;
        //Se conseguiu encontrar o registro, monto o template do retorno desses dados.
        return array(
            'id' => $user_model->GetId(),
            'nome' => $user_model->GetNome(),
            'email' => $user_model->GetEmail(),
            'usuario' => $user_model->GetUsuario()
        );
    }
    /**
     * Regra de Negocio responsável pela inclusão/alteração de um usuário
     *
     * @param Object $data
     * @return Object
     */
    public static function save($data){
        $user_model = new UserModel();
        //Atribuo os dados recebidos em um novo model.
        $user_model->SetId($data->id);
        $user_model->SetNome($data->nome);
        $user_model->SetEmail($data->email);
        $user_model->SetUsuario($data->usuario);
        $user_model->SetSenha(md5($data->senha));

        
        //Realizo o salvar
        if(is_null($user_model->GetId())) $result =  UserModel::insert($user_model);
        else $result = UserModel::update($user_model);
        //Aqui pode optar por receber um true ou false ou os dados do ultimo incluido
        return array(
            'id' => $result->GetId(),
            'nome' => $result->GetNome(),
            'email' => $result->GetEmail(),
            'usuario' => $result->GetUsuario()
        ) ;
    }
    /**
     * Regra de Negocio responsável pela exclusão do usuário
     *
     * @param Object $data Neste objeto teremos o id do usuário
     * @return bool 
     */
    public static function delete($data){
        //Verifico se aquele usuario existe
        $user_model = UserModel::findById($data->id);
        if(is_null($user_model)) return false;
        else return UserModel::delete($user_model);
    }


}