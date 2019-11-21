<h1><?= $title ?></h1>
<p>Below you can get the weather for an IP address, place or with latitude and longitude coordinates seperated by a comma.</p>
<p>Click on the Weather forecast/history button to see the results.</p>
<p>Click on the Weather forecast/history JSON button to see the results in JSON format.</p>
<form class="form wider-form center" action="weather" method="post">
    <input class="center" type="text" name="search" placeholder="Search by IP Address, name or Latitude,Longitude" value=<?= $search ?>>
    <input class="button narrow-button" type="submit" name="do-weather" value="Weather forecast">
    <input class="button narrow-button" type="submit" name="do-weather-json" value="Weather forecast JSON" formaction="weather-json">
    <input class="button narrow-button" type="submit" name="do-weather-history" value="Weather history">
    <input class="button narrow-button" type="submit" name="do-weather-history-json" value="Weather history JSON" formaction="weather-json">
</form>

<?php if ($countryName) { ?>
    <h2 class='center'><?= $city ? "$city, " : null ?><?= $regionName ? "$regionName, " : null ?><?= $countryName ?></h2>
<?php } ?>
<?php if ($lat && $lng) { ?>
    <div class="geotag-columns">
        <div class="geotag-column-1">
            <iframe class="geotag-iframe"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $lng - 0.1 ?>,
                                                                              <?= $lat - 0.1 ?>,
                                                                              <?= $lng + 0.1 ?>,
                                                                              <?= $lat + 0.1 ?>
                                                                              &amp;layer=mapnik&amp;marker=<?= $lat ?>,<?= $lng ?>">
            </iframe>
        </div>
        <div class="geotag-column-2">
            <img class="geotag-flag" src="http://assets.ipstack.com/flags/<?= $countryCode ?>.svg" alt="<?= $countryCode ?>" />
        </div>
    </div>

<?php } ?>

<?php if ($weather) { ?>
    <table class="results-table">
        <thead>
            <tr class="first">
                <th width="20%">Day</th>
                <th width="50%">Summary</th>
                <th width="10%">Temp High</th>
                <th width="10%">Temp Low</th>
                <th width="10%">Weather</th>
            </tr>
        </thead>
        <?php foreach ($weather as $row) : ?>
            <tr>
                <td><?= $row["time"] ?></td>
                <td><?= $row["summary"] ?></td>
                <td><?= $row["temperatureHigh"] ?>&#8451;</td>
                <td><?= $row["temperatureLow"] ?>&#8451;</td>
                <td><img class="weather-icon" src="img/weather/<?= $row["icon"] ?>.svg" alt="<?= $row["icon"] ?>" /></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php } else if ($search && $geoTag) { ?>
    <div class="search invalid">
        <p>No weather available for <?= $search ?></P>
    </div>
<?php } else { ?>
    <div class="search invalid">
        <p><?= $search ?> is invalid.</P>
    </div>
<?php } ?>

<div class="test-ip">
    <h4>Test Weather</h4>
    <p><a href="weather?test-search=8.8.8.8">Test valid IPv4 address with domain</a></p>
    <p><a href="weather?test-search=1.0.1.0">Test valid IPv4 address with domain</a></p>
    <p><a href="weather?test-search=Stockholm">Test Stockholm</a></p>
    <p><a href="weather?test-search=London">Test London</a></p>
    <p><a href="weather?test-search=37.419158935547,-122.07540893555">Test coordinates for USA</a></p>
    <p><a href="weather?test-search=2001:0db8:85a3:0000:0000:8a2e:0370:7334">No weather available</a></p>
</div>
<div class="test-ip-json">
    <h4>Test Weather JSON</h4>
    <p><a href="weather-json?test-search=8.8.8.8">Test valid IPv4 address with domain</a></p>
    <p><a href="weather-json?test-search=1.0.1.0">Test valid IPv4 address with domain</a></p>
    <p><a href="weather-json?test-search=Stockholm">Test Stockholm</a></p>
    <p><a href="weather-json?test-search=London">Test London</a></p>
    <p><a href="weather-json?test-search=37.419158935547,-122.07540893555">Test coordinates for USA</a></p>
    <p><a href="weather-json?test-search=2001:0db8:85a3:0000:0000:8a2e:0370:7334">No weather available</a></p>
</div>
