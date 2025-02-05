<?php
require_once __DIR__ . '/../servidor/config.php';
require_once __DIR__ . '/../gestores/GestorCategoria.php';

$db = conectar();
$gestor = new GestorCategorias($db);
//Obtenemos las categorías padre
$padres = $gestor->getCategoriaPadres();
// $hijos = $gestor->getCategoriaHijos();

?>

<div class="accordion" id="accordionCategories">
    <?php
    if (!empty($padres)) {
        foreach ($padres as $categoria) {
            $categoriaId = $categoria["codigo"];
            $nombreCategoria = $categoria["nombre"];
            //para funcionamiento de bootstrap
            $collapseId = "collapse" . $categoriaId;
            $headingId = "heading" . $categoriaId;
            //Ahora, vamos a obtener las categorías hijo de esta categoría padre
            $hijos = $gestor->getCategoriaHijos($categoriaId);
            ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="<?= $headingId ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
                        <?= htmlspecialchars($nombreCategoria) ?>
                    </button>
                </h2>
                <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="<?= $headingId ?>"
                    data-bs-parent="#accordionCategories">
                    <div class="accordion-body">
                        <ul class="list-unstyled">
                            <?php
                            foreach ($hijos as $hijo) {
                                $nombreSubcategoria = $hijo["nombre"];
                                ?>
                                <li><a href='/paginas/productos.php?catProds=<?= $hijo["codigo"] ?>'
                                        class='text-decoration-none text-color-custom'><?= $nombreSubcategoria ?>
                                        </a></li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>