<h1><?= $title ?></h1>
<p>Below you can geotag an IP Address.</p>
<p>If the IP Address can be geotagged then the results will be shown in a table along with a map and country flag.</p>
<p>Click on the Geotag button to view the geotag details on the current page.</p>
<p>Click on the Geotag JSON button to view the geotag details in JSON format.</p>

<form class="form wider-form center" action="ip-geotag" method="post">
    <input class="center" type="text" name="ip-address" placeholder="Type ip address here" value=<?= $ipAddress ?>>
    <input class="button narrow-button center" type="submit" name="do-geotag" value="Geotag">
    <input class="button narrow-button center" type="submit" name="do-geotag-json" value="Geotag JSON" formaction="ip-geotag-json">
</form>

<?php if ($geoTag && array_key_exists("Country name", $geoTag)) { ?>
    <h2 class="center">
        <?= array_key_exists('City', $geoTag) ? $geoTag["City"] . ", " : null ?>
        <?= array_key_exists('Region name', $geoTag) ? $geoTag['Region name'] . ", " : null ?>
        <?= $geoTag['Country name'] ?>
    </h2>
    <div class="geotag-columns">
        <div class="geotag-column-1">
            <iframe class="geotag-iframe"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $geoTag["Longitude"] - 0.1 ?>,
                                                                              <?= $geoTag["Latitude"] - 0.1 ?>,
                                                                              <?= $geoTag["Longitude"] + 0.1 ?>,
                                                                              <?= $geoTag["Latitude"] + 0.1 ?>
                                                                              &amp;layer=mapnik&amp;marker=<?= $geoTag["Latitude"] ?>,<?= $geoTag["Longitude"] ?>">
            </iframe>
        </div>
        <div class="geotag-column-2">
            <img class="geotag-flag" src=<?= $geoTag["Country flag"] ?> alt=<?= $geoTag["Country flag"] ?> />
        </div>
    </div>

<?php } ?>

<?php if ($validIP && $geoTag) { ?>
    <table class="results-table">
        <thead>
            <tr class="first">
                <th width="50%">Title</th>
                <th width="50%">Value</th>
            </tr>
        </thead>
        <?php foreach ($geoTag as $key => $val) : ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $val ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php } else if (!$validIP && $ipAddress) { ?>
    <div class="search invalid">
        <p>The ip address <?= $ipAddress ?> is invalid</P>
    </div>
<?php } ?>

<div class="test-ip">
    <h4>Test Geotag</h4>
    <p><a href="ip-geotag?test-ip=8.8.8.8">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag?test-ip=1.0.1.0">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag?test-ip=1.1.1.1">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag?test-ip=2.2.2.2">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag?test-ip=5.5.5.5">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag?test-ip=10.10.10.10">Test valid IPv4 address</a></p>
    <p><a href="ip-geotag?test-ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334">Test valid IPv6 address</a></p>
    <p><a href="ip-geotag?test-ip=10.258.0.0">Test invalid IPv4 address</a></p>
    <p><a href="ip-geotag?test-ip=2001:0db8:85a3:0000:0000:8a2er:0370:7334">Test invalid IPv6 address</a></p>
</div>
<div class="test-ip-json">
    <h4>Test Geotag JSON</h4>
    <p><a href="ip-geotag-json?test-ip=8.8.8.8">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag-json?test-ip=1.0.1.0">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag-json?test-ip=1.1.1.1">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag-json?test-ip=2.2.2.2">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag-json?test-ip=5.5.5.5">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-geotag-json?test-ip=10.10.10.10">Test valid IPv4 address</a></p>
    <p><a href="ip-geotag-json?test-ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334">Test valid IPv6 address</a></p>
    <p><a href="ip-geotag-json?test-ip=10.258.0.0">Test invalid IPv4 address</a></p>
    <p><a href="ip-geotag-json?test-ip=2001:0db8:85a3:0000:0000:8a2er:0370:7334">Test invalid IPv6 address</a></p>
</div>
