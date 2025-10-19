<!DOCTYPE html>
<html lang="en">
<?php header('Access-Control-Allow-Origin: *'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="">
        <input type="text" name="loc_start" id="loc_start" value="-6.9970452136082075, 110.47314124171348">
        <input type="text" name="loc_end" id="loc_end">
        <button type="button" id="hitung">Count</button>
    </form>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    document.getElementById('hitung').addEventListener('click', function (e) {
        // e.preventDefault();


        const xhr = new XMLHttpRequest();
        var asal = document.getElementById('loc_start').value;
        var tujuan = document.getElementById('loc_end').value;

        $.ajax({
            'url': 'https://script.google.com/macros/s/AKfycbxnoQk8-pXSbwKyO-npAG_Ox41azuvfyPVtPLRiYkRRqKGkhGZrzsKF2f3pdsYOV53Efw/exec?action=count-distance',
            data: {
                'origin': asal,
                'objective': tujuan,
            },
            success: function (data) {
                console.log(data);
            }
        })


        // xhr.open('GET', 'https://script.google.com/macros/s/AKfycbxnoQk8-pXSbwKyO-npAG_Ox41azuvfyPVtPLRiYkRRqKGkhGZrzsKF2f3pdsYOV53Efw/exec?action=count-distance&asal=' + asal + '&objective=' + tujuan);
        // xhr.onload = function () {
        //     console.log(this.status);

        //     if (this.status === 200) {
        //         const response = JSON.parse(this.response);
        //         console.log(response);
        //         alert(response);
        //     }
        // }
        // xhr.send();
    })
</script>

</html>