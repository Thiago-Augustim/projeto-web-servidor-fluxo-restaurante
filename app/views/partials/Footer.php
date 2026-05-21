    <?php
    function sanitizarParaJs(string $titulo): string
    {
      $nome = trim($titulo, "' ");
      $nome = mb_strtolower($nome, 'UTF-8');
      $nome = str_replace(
        ['á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç'],
        ['a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c'],
        $nome
      );
      $nome = preg_replace('/[^a-z0-9]+/', '-', $nome);
      return trim($nome, '-');
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="/js/<?= sanitizarParaJs($titulo) ?>.js"></script>
<script src="/js/script.js"></script>
    </body>

    </html>