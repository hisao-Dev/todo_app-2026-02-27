<?php
function getHourOptions() {
    for ($h = 0; $h < 24; $h++) {
        $hh = sprintf('%02d', $h);
        echo "<option value='$hh'>$hh</option>";
    }
}
?>
</select>

<?php
function getMinutesOptions() {
    for ($m = 0; $m < 60; $m += 5) {
        $mm = sprintf('%02d', $m);
        echo "<option value='$mm'>$mm</option>";
    }
}
?>