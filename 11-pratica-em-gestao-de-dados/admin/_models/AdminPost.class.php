<?php

/**
 * Description of AdminPost
 * Responsible for managing the posts in the System Admin.
 * @author Klethônio Ferreira
 */
class AdminPost
{
    private $read;
    private $create;
    private $upload;
    private $id;
    private $data;
    private $images;
    private $error;
    private $result;

    const table = 'ws_posts';

    public function __construct() {
        $this->upload = new Upload();
        $this->read = new Read();
        $this->create = new Create();
    }

    public function exeCreate(array $data): null|array
    {
        $this->data = $data;

        if (in_array('', $this->data)) {
            $this->error = ['Para cadastrar um artigo, preencha todos os campos', WS_ALERT];
            $this->result = null;
        } else {
            $this->setData();

            if (!$this->checkName()) {
                $this->error = ["Título da artigo já existe, escolha outro.", WS_ALERT];
                $this->result = null;
            } else {
                $this->uploadCover();

                return $this->create();
            }
        }
        return null;
    }

    public function exeUpdate($id, array $data): null|array
    {
        $this->id = (int) $id;
        $this->data = $data;

        if (in_array('', $this->data)) {
            $this->error = ['Para atualizar este artigo, preencha todos os campos. (Capa não precisa ser enviada.)', WS_ALERT];
            $this->result = null;
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

    public function exeToggleStatus(string|int $id): null|array
    {
        $this->id = (int) $id;
        $read = new Read;
        $read->exeRead(self::table, 'WHERE post_id = :id_int', ['id_int' => $this->id]);

        if (!$read->getResult()) {
            return ['Você tentou ativar/desativar um post que não existe no sistema.', WS_ALERT];
        } else {
            $post_status = $read->first()['post_status'] ? 0 : 1;
            $update = new Update;
            $update->exeUpdate(self::table, ['post_status' => $post_status], 'WHERE post_id = :id_int', ['id_int' => $this->id]);
            return ['O status do post foi atualizado.', WS_SUCCESS];
        }
    }

    public function exeDelete($id): array
    {
        $this->id = (int) $id;
        $read = new Read;
        $read->exeRead(self::table, "WHERE post_id = :id_int", ['id_int' => $this->id]);

        if (!$read->getResult()) {
            return ['Você tentou remover um post que não existe no sistema.', WS_ALERT];
        } else {
            extract($read->first());
            $coverPath = '../_uploads/' . $post_cover;

            if (file_exists($coverPath) && !is_dir($coverPath)) {
                unlink($coverPath);
            }

            $read->exeRead('ws_posts_gallery', "WHERE post_id = :id_int", ['id_int' => $this->id]);

            if ($read->getResult()) {
                foreach ($read->getResult() as $image) {
                    $path = '../_uploads/' . $image['gallery_image'];
                    if (file_exists($path) && !is_dir($path)) {
                        unlink($path);
                    }
                }
            }

            $delete = new Delete;
            $delete->exeDelete('ws_posts_gallery', "WHERE post_id = :id_int", ['id_int' => $this->id]);
            $delete->exeDelete(self::table, "WHERE post_id = :id_int", ['id_int' => $this->id]);

            return ["O post {<b>{$post_title}</b>} foi removido com sucesso do sistema.", WS_SUCCESS];
        }
    }

    public function uploadGallery(string|int $id, array $images): void
    {
        $this->id = (int) $id;
        $this->images = $images;

        $this->read->exeRead(self::table, "WHERE post_id = :id_int", ['id_int' => $this->id]);

        if (!$this->read->getResult()) {
            $this->error = ["Erro ao enviar galeria. O índice {$this->id} não foi encontrado no banco!", WS_ERROR];
            $this->result = null;
        } else {
            $this->getFiles();

            $i = 0;
            $u = 0;

            foreach ($this->images as $file) {
                $i++;
                $name = "{$this->id}-gb-" . substr(md5(time() + $i), 0, 5);
                $this->upload->uploadImage($file, $name);

                if ($this->upload->getResult()) {
                    $galleryImage = $this->upload->getResult();
                    $galleryCreate = ['post_id' => $this->id, 'gallery_image' => $galleryImage, 'gallery_date' => date('Y-m-d H:i:s')];
                    $this->create->exeCreate('ws_posts_gallery', $galleryCreate);
                    $u++;
                }
            }

//            if ($u > 0) {
//                $this->result = ["Galeria atualizada com sucesso. Foram enviadas {$u} imagens.", WS_INFOR];
//            }
        }
    }

    public function removeImage(string|int $id)
    {
        $id = (int) $id;
        $this->read->exeRead('ws_posts_gallery', 'WHERE gallery_id = :id_int', ['id_int' => $id]);
        if (!$this->read->getResult()) {
            $this->result = null;
            return ['Você tentou deletar uma imagem que não existe no sistema.', WS_ERROR];
        } else {
            $path = '../_uploads/' . $this->read->first()['gallery_image'];
            if (file_exists($path) && !is_dir($path)) {
                unlink($path);
                $delete = new Delete;
                $delete->exeDelete('ws_posts_gallery', 'WHERE gallery_id = :id_int', ['id_int' => $id]);
                if ($delete->getResult()) {
                    $this->error = null;
                    return ["A imagem foi removida da galeria.", WS_SUCCESS];
                } else {
                    return ["Erro ao deletar imagem do banco.", WS_ERROR];
                }
            }
        }
        
    }

    function getResult(): null|array
    {
        return $this->result;
    }

    function getError(): null|array
    {
        return $this->error;
    }

    private function setData(): void
    {
        $cover = $this->data['post_cover'];
        $content = $this->data['post_content'];
        unset($this->data['post_cover'], $this->data['post_content']);

        $this->data = array_map('strip_tags', $this->data);
        $this->data = array_map('trim', $this->data);
        $this->data['post_name'] = Prepare::slug($this->data['post_title']);
        $this->data['post_date'] = Prepare::dateToTimestap($this->data['post_date']);
        $this->data['post_type'] = 'post';
        $this->data['post_cover'] = $cover;
        $this->data['post_content'] = $content;
        $this->data['post_cat_parent'] = $this->getCatParent();
    }

    private function getCatParent(): null|int
    {
        $this->read->exeRead('ws_categories', 'WHERE category_id = :id_int', ['id_int' => $this->data['post_category']]);
        
        return $this->read->getResult() ? $this->read->first()['category_parent'] : null;
    }

    private function checkName(): bool
    {
        $condition = (isset($this->id) ? "post_id != {$this->id} AND" : '');
        $this->read->exeRead(self::table, "WHERE {$condition} post_name = :t", ['t' => $this->data['post_name']]);

        return !$this->read->getResult() ? true : false;
    }

    private function create(): null|array
    {
        $this->create->exeCreate(self::table, $this->data);
        if ($this->create->getResult()) {
            $read = new Read();
            $read->exeRead(self::table, 'WHERE post_id = :id_int', ['id_int' => $this->create->getResult()]);
            $this->error = null;
            $this->result = ["O post <b>{$read->first()['post_title']}</b> foi cadastado com sucesso.", WS_SUCCESS];

            return $read->first();
        } else {
            $this->error = ["Erro ao tentar criar post <b>{$this->data['post_title']}</b>.", WS_ERROR];
            $this->result = null;
        }
        return null;
    }

    private function update(): null|array
    {
        $update = new Update;
        $update->exeUpdate(self::table, $this->data, "WHERE post_id = :id_int", ['id_int' => $this->id]);
        
        if ($update->getResult()) {
            $read = new Read();
            $read->exeRead(self::table, 'WHERE post_id = :id_int', ['id_int' => $this->id]);
            $this->error = null;
            $this->result = ["O post <b>{$read->first()['post_title']}</b> foi atualizado com sucesso.", WS_SUCCESS];

            return $read->first();
        } else {
            $this->error = ["Erro ao tentar atualizar post <b>{$this->data['post_title']}</b>.", WS_ERROR];
            $this->result = null;
        }
    }

    private function uploadCover(): void
    {
        $this->upload->uploadImage($this->data['post_cover'], $this->data['post_name']);
        if (isset($this->upload) && $this->upload->getResult()) {
            $this->data['post_cover'] = $this->upload->getResult();
        } else {
            unset($this->data['post_cover']);
        }
    }

    private function getFiles(): void
    {
        $files = array();
        $count = count($this->images['tmp_name']);
        $keys = array_keys($this->images);

        for ($item = 0; $item < $count; $item++) {
            foreach ($keys as $key) {
                $files[$item][$key] = $this->images[$key][$item];
            }
        }

        $this->images = $files;
    }

    private function deleteCover(): bool
    {
        if ($this->data['post_cover'] != 'null') {
            $this->read->exeRead(self::table, "WHERE post_id = :post_int", ["post_int" => $this->id]);
            $capa = '../_uploads/' . $this->read->first()['post_cover'];
            if (file_exists($capa) && !is_dir($capa)) {
                unlink($capa);
            }
            return true;
        } else {
            unset($this->data['post_cover']);
            return false;
        }
    }
}
