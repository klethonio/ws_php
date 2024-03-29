<div class="content home">

    <aside>
        <h1 class="boxtitle">Estatísticas de Acesso:</h1>

        <article class="sitecontent boxaside">
            <h1 class="boxsubtitle">Conteúdo:</h1>
            <ul>
                <li class="view"><span>2890</span> visitas</li>
                <li class="user"><span>187</span> usuários</li>
                <li class="page"><span>28787</span> pageviews</li>
                <li class="line"></li>
                <li class="post"><span>200</span> posts</li>
                <li class="emp"><span>89</span> empresas</li>
                <li class="comm"><span>38</span> comentários</li>
            </ul>
            <div class="clear"></div>
        </article>

        <article class="useragent boxaside">
            <h1 class="boxsubtitle">Navegador:</h1>
            <ul>
                <li>
                    <p><strong>Chrome:</strong> 76%</p>
                    <span style="width: 100%"></span>
                    <p>1280 visitas</p>
                </li>

                <li>
                    <p><strong>Firefox:</strong> 21%</p>
                    <span style="width: 21%"></span>
                    <p>1280 visitas</p>
                </li>

                <li>
                    <p><strong>IE:</strong> 8%</p>
                    <span style="width: 8%"></span>
                    <p>1280 visitas</p>
                </li>    
            </ul>
            <div class="clear"></div>
        </article>
    </aside>

    <section class="content_statistics">

        <h1 class="boxtitle">Publicações:</h1>

        <section>
            <h1 class="boxsubtitle">Artigos Recentes:</h1>

            <?php for ($i = 1; $i <= 3; $i++): ?>
                <article<?php if ($i % 2 == 0) echo ' class="right"'; ?>>

                    <div class="img thumb_small"></div>
                    <h1><a target="_blank" href="../artigo/uri-do-artigo" title="Ver Post">Tchau iPhone: Galaxy S3 supera o 4S e é o celular mais vendido do mundo</a></h1>
                    <ul class="info post_actions">
                        <li><strong>Data:</strong> <?= date('d/m/Y H:i'); ?>Hs</li>
                        <li><a class="act_view" target="_blank" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Ver no site">Ver no site</a></li>
                        <li><a class="act_edit" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Editar">Editar</a></li>
                        <!--<li><a class="act_inative" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Ativar">Ativar</a></li>-->
                        <li><a class="act_ative" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Inativar">Ativar</a></li>
                        <li><a class="act_delete" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Excluir">Deletar</a></li>
                    </ul>

                </article>
            <?php endfor; ?>
        </section>          


        <section>
            <h1 class="boxsubtitle">Artigos Mais Vistos:</h1>

            <?php for ($i = 1; $i <= 3; $i++): ?>
                <article<?php if ($i % 2 == 0) echo ' class="right"'; ?>>

                    <div class="img thumb_small"></div>
                    <h1><a target="_blank" href="../artigo/uri-do-artigo" title="Ver Post">Tchau iPhone: Galaxy S3 supera o 4S e é o celular mais vendido do mundo</a></h1>
                    <ul class="info post_actions">
                        <li><strong>Data:</strong> <?= date('d/m/Y H:i'); ?>Hs</li>
                        <li><a class="act_view" target="_blank" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Ver no site">Ver no site</a></li>
                        <li><a class="act_edit" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Editar">Editar</a></li>
                        <!--<li><a class="act_inative" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Ativar">Ativar</a></li>-->
                        <li><a class="act_ative" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Inativar">Ativar</a></li>
                        <li><a class="act_delete" href="panel.php?exe=posts/post&id=ID_DO_POST" title="Excluir">Deletar</a></li>
                    </ul>

                </article>
            <?php endfor; ?>
        </section>                           

    </section> <!-- Estatísticas -->

    <div class="clear"></div>
</div> <!-- content home -->