<?php
    $paginator = $this->Paginator->setTemplates([
        'number'=> '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',

        'current'=> '<li class="page-item active"><a href="{{url}}" class="page-link">{{text}}</a></li>',

        'first'=> '<li class="page-item"><a href="{{url}}" class="page-link">&laquo Primeira</a></li>',

        'last'=> '<li class="page-item"><a href="{{url}}" class="page-link">Última &raquo</a></li>',

        'prevActive'=> '<li class="page-item"><a href="{{url}}" class="page-link">&lt</a></li>',

        'nextActive'=> '<li class="page-item"><a href="{{url}}" class="page-link">&gt</a></li>',
    ]);
?>

<nav aria-label="paginacao">
    <ul class="pagination pagination-sm justify-content-center">
        <?php
        echo $paginator->first();
        if($paginator->hasPrev()){
            echo $paginator->prev();
        }
        echo $paginator->numbers();
        if($paginator->hasNext()){
            echo $paginator->next();
        }
        echo $paginator->last();
        ?>
    </ul>
</nav>