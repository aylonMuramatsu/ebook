<?php
namespace App\Repository;

use App\Interfaces\IDataAdapter;
use App\System\Database;
use App\Model\UserModel;
use App\System\Helper;
use App\System\BusinessException;

class UserRepository implements IDataAdapter{
    public static function insert($model){
        //Verifico se esta tudo Ok com os dados
        $validation = $model->validate();
        if(!$validation->isOkay()) throw new BusinessException($validation);

        $retorno = Database::exec(
            "INSERT INTO usuario (
                nome,
                email,
                inserido_em,
                inserido_por,
                senha,
                usuario
            ) VALUES (
                :nome,
                :email,
                :inserido_em,
                :inserido_por,
                :senha,
                :usuario
            )",
            array(
                ":nome" => $model->GetNome(),
                ":email" => $model->GetEmail(),
                ":inserido_em" => Helper::Now(),
                ":inserido_por" => null,
                ":senha" => $model->GetSenha(),
                ":usuario" => $model->GetUsuario()
            )
        );

        if($retorno) return self::findById(Database::last_insert_id());
        else $retorno;
    }

    public static function update($model){
        $old_model = UserModel::findById($model->GetId());
        //Crio um model atualizado
        $user_model = new UserModel();
        $user_model->SetId($model->GetId());
        $user_model->SetNome(Helper::GetUpdated($old_model->GetNome(),$model->GetNome()));
        $user_model->SetEmail(Helper::GetUpdated($old_model->GetEmail(),$model->GetEmail()));
        $user_model->SetSenha(Helper::GetUpdated($old_model->GetSenha(),md5($model->GetSenha())));
        $user_model->SetUsuario(Helper::GetUpdated($old_model->GetUsuario(),$model->GetUsuario()));
        //Verifico se esta tudo Ok com os dados
        $validation = $user_model->validate();
        if(!$validation->isOkay()) throw new BusinessException($validation);
        
        $retorno = Database::exec(
            "UPDATE usuario SET  
                nome = :nome,
                email = :email,
                senha = :senha,
                usuario = :usuario
            WHERE id = :id
            ",
            array(
                ":nome" => $user_model->GetNome(),
                ":email" => $user_model->GetEmail(),
                ":senha" => $user_model->GetSenha(),
                ":usuario" => $user_model->GetUsuario(),
                ":id" => $user_model->GetId()
            )
            
        );

        if($retorno) return self::findById($model->GetId());
        else $retorno;
    }
    
    public static function list($filter){
        $where = "WHERE excluido = 'N' ";
        $params = [];

        if(!is_null($filter->nome)){
            $where .= " AND nome LIKE :nome"; 
            $params[":nome"] = "%$filter->nome%";
        }

        $query = Database::query(
            "SELECT * FROM usuario $where ORDER BY id DESC",
            $params
        );

        if(Database::has_rows($query)){
            $lista = [];
            foreach ($query as $key => $row) {
                $row = (object)$row;
                $user_model = new UserModel();
                $user_model->SetId($row->id);
                $user_model->SetNome($row->nome);
                $user_model->SetEmail($row->email);
                $user_model->SetInseridoEm($row->inserido_em);
                $user_model->SetInseridoPor($row->inserido_por);
                $user_model->SetSenha($row->senha);
                $user_model->SetUsuario($row->usuario);
                $lista[] = $user_model;
            }

            return $lista;
        }

        return [];
    }

    public static function delete($model){
        $retorno = Database::exec(
            "UPDATE usuario SET  
                excluido = 'S'
             WHERE id = :id",
            array(
                ":id" => $model->GetId()
            )
        );

        return $retorno;
    }
    
    public static function findById($id)
    {
        $query = Database::query(
            "SELECT * FROM usuario WHERE id = :id",
            array(":id" => $id)
        );

        if(Database::has_rows($query)){
            $row = (object)$query[0];
            $user_model = new UserModel();
            $user_model->SetId($row->id);
            $user_model->SetNome($row->nome);
            $user_model->SetEmail($row->email);
            $user_model->SetInseridoEm($row->inserido_em);
            $user_model->SetInseridoPor($row->inserido_por);
            $user_model->SetSenha($row->senha);
            $user_model->SetUsuario($row->usuario);

            return $user_model;
        }

        return null;
    }

    public static function request_login($data){
        $query  = Database::query(
            "SELECT * FROM usuario WHERE excluido = 'N' AND usuario = :usuario AND senha = :senha",
            array(
                ":usuario" => $data->usuario,
                ":senha" => md5($data->senha)
            )
        );
        if(Database::has_rows($query)){
            $row = (object)$query[0];
            return self::findById($row->id);
        }

        return null;
    }
}