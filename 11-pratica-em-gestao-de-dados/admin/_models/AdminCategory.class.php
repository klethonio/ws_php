<?php

/**
 * Descritpion de AdminCategory
 * Responsible for generating system categories in the admin.
 * 
 * @author Klethônio Ferreira
 */
class AdminCategory
{
    private $read;
    private $data;
    private $id;
    private $error;
    private $result;

    const table = 'ws_categories';
    
    public function __construct() {
        $this->read = new Read;
    }

    public function exeCreate(array $data): null|array
    {
        $this->data = $data;

        if (in_array('', $this->data)) {
            $this->error = ['Para cadastrar uma categoria, preencha todos os campos', WS_ALERT];
            $this->result = null;
        } else {
            $this->setData();

            if(!$this->checkName()){
                $this->error = ["Título da categoria já existe, cria uma subcategoria.", WS_ALERT];
                $this->result = null;
            }else{
                return $this->create();
            }
        }
        return null;
    }

    public function exeUpdate(string|int $id, array $data): void
    {
        $this->data = $data;
        $this->id = (int) $id;

        if (in_array('', $this->data)) {
            $this->error = ["Para atualizar <b>{$this->data['category_title']}</b>, preencha todos os campos", WS_ALERT];
        } else {
            $this->setData();
            
            if(!$this->checkName()){
                $this->error = ["Título da categoria já existe, cria uma subcategoria.", WS_ALERT];
            } else {
                $this->update();
            }
        }
    }

    public function exeDelete(string|int $id): array
    {
        $this->id = (int) $id;
        $this->read->exeRead(self::table, "WHERE category_id = :category_id_int", ['category_id_int' => $this->id]);

        if (!$this->read->getResult()) {
            return ['Você tentou remover uma categoria que não existe no sistema.', WS_ALERT];
        } else {
            extract($this->read->first());

            if (!$category_parent && !$this->checkCats()) {
                return ["A seção <b>{$category_title}</b> não pode ser deletada pois possui categorias cadastradas. Remova ou altere as sub-categorias.", WS_ALERT];
            } elseif ($category_parent && !$this->checkPosts()) {
                return ["A categoria <b>{$category_title}</b> não pode ser deletada pois possui artigos cadastradas. Remova ou altere todos os artigos.", WS_ALERT];
            } else {
                $type = empty($category_parent) ? 'seção' : 'categoria';
                $delete = new Delete;
                $delete->exeDelete(self::table, 'WHERE category_id = :category_id_int', ['category_id_int' => $this->id]);
                return ["A {$type} <b>{$category_title}</b> foi removida com sucesso do sistema.", WS_SUCCESS];
            }
        }
    }

    function getResult()
    {
        return $this->result;
    }

    function getError(): null|array
    {
        return $this->error;
    }
    
    private function setData(): void
    {
        $this->data = array_map('strip_tags', $this->data);
        $this->data = array_map('trim', $this->data);
        $this->data['category_name'] = Prepare::slug($this->data['category_title']);
        $this->data['category_date'] = Prepare::dateToTimestap($this->data['category_date']);
        $this->data['category_parent'] = $this->data['category_parent'] == 'null' ? null : $this->data['category_parent'];
    }

    private function checkName(): bool
    {
        $cond = !empty($this->id) ? "category_id != {$this->id} AND" : '';
        $this->read->exeRead(self::table, "WHERE {$cond} category_title = :title", ['title' => $this->data['category_title']]);
        
        return (!$this->read->getResult()) ? true : false;
    }

    private function checkCats(): bool
    {
        $this->read->exeRead(self::table, "WHERE category_parent = :parent_int", ['parent_int' => $this->id]);

        return (!$this->read->getResult()) ? true : false;
    }

    private function checkPosts(): bool
    {
        $this->read->exeRead('ws_posts', "WHERE post_category = :category_id_int", ['category_id_int' => $this->id]);
        
        return (!$this->read->getResult()) ? true : false;
    }

    private function create(): null|array
    {
        $create = new Create;
        $create->exeCreate(self::table, $this->data);

        if ($create->getResult()) {
            $read = new Read();
            $read->exeRead(self::table, 'WHERE category_id = :id_int', ['id_int' => $create->getResult()]);
            $this->error = null;
            $type = empty($read->first()['category_parent']) ? 'seção' : 'categoria';
            $this->result = ["A {$type} <b>{$read->first()['category_title']}</b> foi cadastada com sucesso.", WS_SUCCESS];

            return $read->first();
        } else {
            $this->error = ["Erro ao tentar criar categoria <b>{$this->data['category_title']}</b>.", WS_ERROR];
            $this->result = null;
        }
        return null;
    }

    private function update(): null|array
    {
        $update = new Update;
        $update->exeUpdate(self::table, $this->data, 'WHERE category_id = :category_id_int', ['category_id_int' => $this->id]);

        if ($update->getResult()) {
                $read = new Read();
                $read->exeRead(self::table, 'WHERE category_id = :id_int', ['id_int' => $this->id]);
                $this->error = null;
                $type = empty($this->data['category_parent']) ? 'seção' : 'categoria';
                $this->result = ["A {$type} <b>{$read->first()['category_title']}</b> foi atualizada com sucesso.", WS_SUCCESS];

                return $read->first();
        } else {
            $this->error = ["Erro ao tentar atualizar categoria <b>{$this->data['category_title']}</b>.", WS_ERROR];
        }
    }

}
