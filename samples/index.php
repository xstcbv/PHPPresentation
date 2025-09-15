<?php
include_once 'Sample_Header.php';
$requirements = [
    'php' => ['PHP 5.3.0', version_compare(PHP_VERSION, '5.3.0', '>=')],
    'xml' => ['PHP extension XML', extension_loaded('xml')],
    'zip' => ['PHP extension ZipArchive (optional)', extension_loaded('zip')],
    'gd' => ['PHP extension GD (optional)', extension_loaded('gd')],
    'xmlw' => ['PHP extension XMLWriter (optional)', extension_loaded('xmlwriter')],
    'xsl' => ['PHP extension XSL (optional)', extension_loaded('xsl')],
];
if (!CLI) {
    ?>
<div class="jumbotron">
<p>Welcome to PHPPresentation, a library written in pure PHP that provides a set of classes to write to and read from different document file formats, i.e. Office Open XML (.pptx) and Open Document Format (.odp).</p>
<p>&nbsp;</p>
<p>
    <a class="btn btn-lg btn-primary" href="https://github.com/PHPOffice/PHPPresentation" role="button"><i class="fa fa-github fa-lg" title="GitHub"></i>  Fork us on Github!</a>
    <a class="btn btn-lg btn-primary" href="https://phpoffice.github.io/PHPPresentation/" role="button"><i class="fa fa-book fa-lg" title="Docs"></i>  Read the Docs</a>
</p>
</div>
<?php
}
if (!CLI) {
    echo '<h3>Requirement check:</h3>';
    echo '<ul>';
    foreach ($requirements as $key => $value) {
        [$label, $result] = $value;
        $status = $result ? 'passed' : 'failed';
        echo "<li>{$label} ... <span class='{$status}'>{$status}</span></li>";
    }
    echo '</ul>';
    include_once 'Sample_Footer.php';
} else {
    echo 'Requirement check:' . PHP_EOL;
    foreach ($requirements as $key => $value) {
        [$label, $result] = $value;
        $status = $result ? '32m passed' : '31m failed';
        echo "{$label} ... \033[{$status}\033[0m" . PHP_EOL;
    }
}
