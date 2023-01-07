<?php

/**
 * AdminEmpresa.class [ MODEL ADMIN ]
 * Responável por gerenciar as empresas no admin do sistema!
 * 
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class AdminCompany
{

    private $id;
    private $data;
    private $error;
    private $result;

    //Nome da tabela no banco de dados
    const table = 'app_companies';

    /**
     * <b>Cadastrar a Empresa:</b> Envelope os dados da empresa em um array atribuitivo e execute esse método
     * para cadastrar a mesma no banco.
     * @param array $data
     * @return null|array
     */
    public function exeCreate(array $data): null|array
    {
        $this->data = $data;

        if (in_array('', $this->data)) {
            $this->error = ["Para cadastrar uma empresa, preencha todos os campos!", WS_ALERT];
            $this->result = null;
        } else {
            $this->setData();
            if (!$this->checkName()) {
                $this->error = ["Título da artigo já existe, escolha outro.", WS_ALERT];
                $this->result = null;
            } else {
                if ($this->uploadCover()) {
                    return $this->create();
                }
            }
        }
        return null;
    }

    /**
     * <b>Atualizar a Empresa:</b> Envelope os dados em uma array atribuitivo e informe o id de uma empresa
     * para atualiza-la no banco de dados!
     * @param int $id
     * @param array $data
     * @return null|array
     */
    public function exeUpdate($id, array $data): null|array
    {
        $this->id = (int) $id;
        $this->data = $data;

        if (in_array('', $this->data)){
            $this->error = ["Para atualizar <b>{$this->data['company_title']}</b>, preencha todos os campos!", WS_ALERT];
            $this->result = false;
        } else {
            $this->setData();
            if (!$this->checkName()) {
                $this->error = ["Título da artigo já existe, escolha outro.", WS_ALERT];
            } else {
                if ($this->deleteCover()) {
                    $this->uploadCover();
                }
                return $this->update();
            }
        }
        return null;
    }

    /**
     * <b>Ativa/Inativa Empresa:</b> Informe o ID da empresa e o status e um status sendo 1 para ativo e 0 para
     * rascunho. Esse méto ativa e inativa as empresas!
     * @param int $id
     * @param array
     */
    public function exeToggleStatus(string|int $id)
    {
        $this->id = (int) $id;
        $read = new Read;
        $read->exeRead(self::table, 'WHERE company_id = :id_int', ['id_int' => $this->id]);

        if (!$read->getResult()) {
            return ['Você tentou ativar/desativar uma empresa que não existe no sistema.', WS_ALERT];
        } else {
            $company_status = $read->first()['company_status'] ? 0 : 1;
            $update = new Update;
            $update->exeUpdate(self::table, ['company_status' => $company_status], 'WHERE company_id = :id_int', ['id_int' => $this->id]);
            return ['O status da empresa foi atualizado.', WS_SUCCESS];
        }
    }

    /**
     * <b>Deleta Empresas:</b> Informe o ID da empresa a ser removida para que esse método realize uma
     * checagem excluinto todos os dados nessesários e removendo a empresa do banco!
     * @param int $id
     */
    public function exeDelete($id) {

        $this->id = (int) $id;
        $read = new Read;
        $read->exeRead(self::table, "WHERE company_id = :id_int", ['id_int' => $this->id]);

        if (!$read->getResult()) {
            return ['Você tentou remover uma empresa que não existe no sistema.', WS_ALERT];
        } else {
            extract($read->first());
            $coverPath = '../_uploads/' . $company_capa;

            if (file_exists($coverPath) && !is_dir($coverPath)) {
                unlink($coverPath);
            }

            $deleta = new Delete;
            $deleta->exeDelete(self::table, "WHERE company_id = :id_int", ['id_int' => $this->id]);

            return ["A empresa {<b>{$post_title}</b>} foi removida com sucesso do sistema.", WS_SUCCESS];
        }
    }

    /**
     * <b>Verificar Ação:</b> Retorna TRUE se ação for efetuada ou FALSE se não. Para verificar erros
     * execute um getError();
     * @return null|array
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com um erro e um tipo.
     * @return array
     */
    public function getError() {
        return $this->error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro. Realiza Upload da Capa!
    private function setData(): void
    {
        $this->data['company_name'] = Prepare::slug($this->data['company_title']);
        $this->data['company_date'] = date('Y-m-d H:i:s');
    }

    //Verifica o NAME da empresa.
    private function checkName(): bool
    {
        $condition = ( isset($this->id) ? "company_id != {$this->id} AND" : '');

        $read = new Read;
        $read->exeRead(self::table, "WHERE {$condition} company_title = :title", ['title' => $this->data['company_title']]);

        return !$read->getResult() ? true : false;
    }

    //Verifica e envia a capa da empresa para a pasta!
    private function uploadCover(): bool
    {
        if (!empty($this->data['company_capa']['tmp_name'])){
            list($w, $h) = getimagesize($this->data['company_capa']['tmp_name']);

            if ($w != 578 || $h != 288){
                $this->error = ['Capa Inválida: A Capa da empresa deve ter exatamente 578x288px do tipo .JPG, .PNG ou .GIF!', WS_INFOR];
                $this->result = null;
            } else {
                $upload = new Upload;
                $upload->uploadImage($this->data['company_capa'], $this->data['company_name'], 578, 'companies');

                if ($upload->getError()){
                    $this->error = $upload->getError();
                    $this->result = null;
                } else {
                    $this->data['company_capa'] = $upload->getResult();
                    return true;
                }
            }

            return false;
        } else {
            return true;
        }
    }

    private function deleteCover(): bool
    {
        if ($this->data['company_capa'] != 'null') {
            $read = new Read;
            $read->exeRead(self::table, "WHERE company_id = :id_int", ["id_int" => $this->id]);
            
            $capa = '../_uploads/' . $read->first()['company_capa'];
            if (file_exists($capa) && !is_dir($capa)) {
                unlink($capa);
            }
            return true;
        } else {
            unset($this->data['company_capa']);
            return false;
        }
    }

    //Cadastra a empresa no banco!
    private function create(): null|array
    {
        $create = new Create;
        $create->exeCreate(self::table, $this->data);
        if ($create->getResult()) {
            $read = new Read();
            $read->exeRead(self::table, 'WHERE company_id = :id_int', ['id_int' => $create->getResult()]);
            $this->error = null;
            $this->result = ["A empresa <b>{$this->data['company_title']}</b> foi cadastrada com sucesso no sistema!", WS_SUCCESS];
            
            return $read->first();
        } else {
            $this->error = ["Erro ao tentar criar empresa <b>{$this->data['company_title']}</b>.", WS_ERROR];
            $this->result = null;
        }
        return null;
    }

    //Atualiza a empresa no banco!
    private function update(): null|array
    {
        $update = new Update;
        $update->exeUpdate(self::table, $this->data, "WHERE company_id = :id_int", ['id_int' => $this->id]);

        if ($update->getResult()) {
            $read = new Read();
            $read->exeRead(self::table, 'WHERE company_id = :id_int', ['id_int' => $this->id]);
            $this->error = null;
            $this->result = ["A empresa <b>{$read->first()['company_title']}</b> foi atualizada com sucesso.", WS_SUCCESS];

            return $read->first();
        } else {
            $this->error = ["Erro ao tentar atualizar empresa <b>{$this->data['company_title']}</b>.", WS_ERROR];
            $this->result = null;
        }
    }

}
