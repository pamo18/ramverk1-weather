<h1><?= $title ?></h1>
<p>Below you can validate an IP Address to see if it is valid and which type it is.</p>
<p>If the IP Address has a domain name then it is shown too.</p>
<p>Click on the validate button to view the IP Address details on the current page.</p>
<p>Click on the validate JSON button too show the IP Address details in JSON format, retrievable from <a href="ip-validate-json">/ip-validate-json</a></p>

<form class="form wider-form center" action="ip-validate" method="post">
    <input class="center" type="text" name="ip-address" placeholder="Type ip address here" value=<?= $ipAddress ?>>
    <input class="button narrow-button center" type="submit" name="do-validate" value="Validate">
    <input class="button narrow-button center" type="submit" name="do-validate-json" value="Validate JSON" formaction="ip-validate-json">
</form>

<div class="search <?= ($status === "invalid" ? "invalid" : null) ?>">
    <?php if ($ipAddress) { ?>
        <p>The ip address <?= $ipAddress ?> is <?= $status ?></P>
        <p>The IP type is <?= $type ?></p>
        <p>The domain name is <?= $domain ?></p>
    <?php } ?>
</div>

<div class="test-ip">
    <h4>Test Validate</h4>
    <p><a href="ip-validate?test-ip=8.8.8.8">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-validate?test-ip=10.10.10.10">Test valid IPv4 address</a></p>
    <p><a href="ip-validate?test-ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334">Test valid IPv6 address</a></p>
    <p><a href="ip-validate?test-ip=10.258.0.0">Test invalid IPv4 address</a></p>
    <p><a href="ip-validate?test-ip=2001:0db8:85a3:0000:0000:8a2er:0370:7334">Test invalid IPv6 address</a></p>
</div>
<div class="test-ip-json">
    <h4>Test Validate JSON</h4>
    <p><a href="ip-validate-json?test-ip=8.8.8.8">Test valid IPv4 address with domain</a></p>
    <p><a href="ip-validate-json?test-ip=10.10.10.10">Test valid IPv4 address</a></p>
    <p><a href="ip-validate-json?test-ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334">Test valid IPv6 address</a></p>
    <p><a href="ip-validate-json?test-ip=10.258.0.0">Test invalid IPv4 address</a></p>
    <p><a href="ip-validate-json?test-ip=2001:0db8:85a3:0000:0000:8a2er:0370:7334">Test invalid IPv6 address</a></p>
</div>
